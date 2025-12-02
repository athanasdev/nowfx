<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Referral;
use App\Models\ReferralSetting;
use App\Models\ReferralSettings;
use App\Models\Team;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminUserController extends Controller
{
    public function passwordResetList()
    {
        $resetRequests = DB::table('password_reset_tokens')
            ->select('email', 'username', 'unique_id', 'code', 'created_at')
            ->get();

        return view('admin.dashbord.pages.password', compact('resetRequests'));
    }

    public function traderList()
    {
        $traders = User::select('id', 'unique_id', 'username', 'email', 'balance', 'status', 'Withdraw_amount', 'email', 'created_at')
            ->paginate(100000);

        $totalUsers = User::count();

        $blockedUsers = User::where('status', 'blocked')->count();

        $activeTraders = User::where('status', 'active')->count();

        $withdrawRequests = Withdrawal::where('status', 'pending')->distinct('user_id')->count('user_id');

        return view('admin.dashbord.pages.trader', compact(
            'traders',
            'totalUsers',
            'blockedUsers',
            'activeTraders',
            'withdrawRequests'
        ));
    }

    public function systemLogs()
    {
        $transactions = Transaction::select('id', 'user_id', 'type', 'amount', 'description', 'created_at')
            ->paginate(10);
        return view('admin.dashbord.pages.logs', compact('transactions'));
    }

    public function depost()
    {
        $deposits = Deposit::with('user')->orderBy('created_at', 'desc')->paginate(100000);

        $pendingCount = Deposit::where('status', 'pending')->count();
        $completedCount = Deposit::where('status', 'completed')->count();

        $pendingTotal = Deposit::where('status', 'pending')->sum('amount');
        $completedTotal = Deposit::where('status', 'completed')->sum('amount');

        return view('admin.dashbord.pages.depost', [
            'withdraws' => $deposits,
            'pendingCount' => $pendingCount,
            'completedCount' => $completedCount,
            'pendingTotal' => $pendingTotal,
            'completedTotal' => $completedTotal,
        ]);
    }

    public function withdraw()
    {
        // Optimized aggregate queries
        $pendingCount = Withdrawal::where('status', 'pending')->count();
        $completedCount = Withdrawal::where('status', 'completed')->count();

        $pendingTotal = Withdrawal::where('status', 'pending')->sum('amount');
        $completedTotal = Withdrawal::where('status', 'completed')->sum('amount');

        // Eager load users to prevent N+1
        $withdraws = Withdrawal::with('user')->latest()->paginate(100000);

        return view('admin.dashbord.pages.withdraw', compact(
            'pendingCount',
            'completedCount',
            'pendingTotal',
            'completedTotal',
            'withdraws'
        ));
    }

    public function team()
    {
        return view('admin.dashbord.pages.team');
    }

    public function traderDetails($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404);
        }

        // Get user details
        $user = User::findOrFail($decryptedId);

        // Get transaction history
        $transactions = Transaction::where('user_id', $user->id)->latest()->get();

        // Team data logic (integrated from your team() method)
        $level1_members = User::where('referrer_id', $user->id)->get();
        $level1_count = $level1_members->count();

        $level2_members = collect();
        foreach ($level1_members as $level1_member) {
            $level2_members = $level2_members->merge(User::where('referrer_id', $level1_member->id)->get());
        }
        $level2_count = $level2_members->count();

        $level3_members = collect();
        foreach ($level2_members as $level2_member) {
            $level3_members = $level3_members->merge(User::where('referrer_id', $level2_member->id)->get());
        }
        $level3_count = $level3_members->count();

        $total_registered_users = $level1_count + $level2_count + $level3_count;
        $active_users = 0;  // You'll need to implement logic to determine active users

        // You'll need to implement logic for Deposit and Commissions based on your application's flow.
        $level1_deposit = 0.0;
        $level1_commissions = 0.0;
        $level2_deposit = 0.0;
        $level2_commissions = 0.0;
        $level3_deposit = 0.0;
        $level3_commissions = 0.0;
        $total_deposits = 0.0;
        $total_commissions = 0.0;

        // Combine referral data (if you still need the original referralSummary structure)
        $teams = Team::where('user_id', $user->id)->get()->groupBy('level');  // Assuming you have a Team model
        $referralSummary = [
            'totalMembers' => $teams->flatten()->count(),
            'totalDeposit' => $teams->flatten()->sum('deposit'),
            'totalCommissions' => $teams->flatten()->sum('commissions'),
            'levels' => $teams,
        ];

        return view('admin.dashbord.pages.traderdetails', compact(
            'user',
            'transactions',
            'referralSummary',  // Keep this if your original UI part uses it
            'total_registered_users',  // Add these new variables
            'active_users',
            'level1_count',
            'level2_count',
            'level3_count',
            'level1_deposit',
            'level1_commissions',
            'level2_deposit',
            'level2_commissions',
            'level3_deposit',
            'level3_commissions',
            'total_deposits',
            'total_commissions'
        ));
    }

    public function toggleTraderStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Toggle status
        if ($user->status === 'blocked') {
            $user->status = 'active';
            $message = 'User has been unblocked successfully.';
        } else {
            $user->status = 'blocked';
            $message = 'User has been blocked successfully.';
        }

        $user->save();

        return redirect()->back()->with('success', $message);
    }

    public function settings()
    {
        // Fetch all referral levels from the new 'referrals' table
        // If you paginate here, ensure your view handles pagination links
        $referrals = Referral::orderBy('level')->get();  // Or paginate(20) if you expect many levels

        // If you have other general settings, you might fetch them here too
        // For now, we'll focus on referrals

        return view('admin.dashbord.pages.settings', compact('referrals'));
    }

    public function aproveDepost(Request $request, $id)
    {
        // Use a database transaction for atomicity
        DB::beginTransaction();

        try {
            // 1. Find the deposit
            $deposit = Deposit::find($id);

            // Check if the deposit exists
            if (!$deposit) {
                DB::rollBack();
                return back()->with('error', 'Deposit not found.');
            }

            // Check if the deposit is already completed
            if ($deposit->status === 'completed') {
                DB::rollBack();
                return back()->with('info', 'Deposit is already completed.');
            }

            // 2. Update deposit status to 'completed'
            $deposit->status = 'completed';
            $deposit->save();

            // // If everything above is successful, commit the transaction
            DB::commit();

            return back()->with('success', 'Deposit approved and user balance updated successfully!');
        } catch (\Exception $e) {
            // If any error occurs, rollback all changes
            DB::rollBack();
            Log::error("Failed to approve deposit ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Failed to approve deposit. Please try again.');
        }
    }

    //  Aprovie with draws for the users

    public function pay($id)
    {
        $withdraw = Withdrawal::findOrFail($id);

        if ($withdraw->status !== 'pending') {
            return back()->with('error', 'Already processed.');
        }

        $withdraw->status = 'complete';
        $withdraw->save();

        return back()->with('success', 'Payment marked as complete.');
    }

    // public function returnWithdraw($id)
    // {
    //     $withdraw = Withdrawal::with('user')->findOrFail($id);

    //     // Add the amount back to the user balance
    //     $withdraw->user->balance += $withdraw->amount;
    //     $withdraw->user->save();

    //     // Delete withdrawal record
    //     $withdraw->delete();

    //     return redirect()->back()->with('success', 'Withdrawal amount returned to user balance.');
    // }

    
    public function returnWithdraw($id)
    {
        $withdraw = Withdrawal::with('user')->findOrFail($id);

        // Hesabu original amount (kwa sababu withdrawal->amount = baada ya kukatwa 5%)
        $returnAmount = $withdraw->amount / (1 - 0.05);

        // Rudisha balance ya user
        $withdraw->user->balance += $returnAmount;
        $withdraw->user->save();

        // Futa withdrawal record
        $withdraw->delete();

        return redirect()->back()->with(
            'success',
            "Withdrawal of {$withdraw->amount} (after fee) has been returned as {$returnAmount} to user balance."
        );

    }


}