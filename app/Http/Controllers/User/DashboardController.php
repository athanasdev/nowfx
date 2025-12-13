<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GameSetting;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;  // Your User model
use App\Models\UserInvestment;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    // public function home()
    // {
    //     $user = Auth::user();

    //     $nowUTC = Carbon::now('UTC');

    //     // Fetch the currently active game
    //     $activeGameSetting = GameSetting::where('is_active', 1)
    //         ->where('start_time', '<=', $nowUTC)
    //         ->where('end_time', '>', $nowUTC)
    //         ->orderBy('start_time', 'desc')
    //         ->first();

    //     // Fetch pending investments only for the active game
    //     $activeUserInvestment = collect(); // default empty
    //     if ($activeGameSetting) {
    //         $activeUserInvestment = UserInvestment::where('user_id', $user->id)
    //             ->where('game_setting_id', $activeGameSetting->id)
    //             ->where('investment_result', 'pending')
    //             ->orderBy('created_at', 'desc')
    //             ->get();
    //     }

    //     // Fetch all investments for history
    //     $allUserInvestments = UserInvestment::where('user_id', $user->id)
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     return view('user.pages.index', compact(
    //         'user',
    //         'activeGameSetting',
    //         'activeUserInvestment',
    //         'allUserInvestments'
    //     ));
    // }

    public function home()
    {
        $user = Auth::user();

        // Fetch **all pending investments** for Open Orders
        $activeUserInvestment = UserInvestment::where('user_id', $user->id)
            ->where('investment_result', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch all investments for Order History
        $allUserInvestments = UserInvestment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.pages.index', compact('user', 'activeUserInvestment', 'allUserInvestments'));
    }

    public function trading()
    {
        $user = Auth::user();

        // Fetch **all pending investments** for Open Orders
        $activeUserInvestment = UserInvestment::where('user_id', $user->id)
            ->where('investment_result', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch all investments for Order History
        $allUserInvestments = UserInvestment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.pages.trade', compact('user', 'activeUserInvestment', 'allUserInvestments'));
    }

    public function myaccount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // The last argument ('transactions_page') is important for multiple paginations on one page.
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'transactions_page');

        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'withdrawals_page');

        // Assuming you have a `Payment` model for the `payments` table
        $deposits = Payment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'deposits_page');

        // --- Your Existing Statistics Calculations (These are all correct) ---
        $totalReferralEarning = Transaction::where('user_id', $user->id)
            ->where('type', 'credit')
            ->where(function ($query) {
                $query
                    ->where('description', 'like', '%Referral Commission%')
                    ->orWhere('description', 'like', '%commission from%');
            })
            ->sum('amount');

        $investedCapital = UserInvestment::where('user_id', $user->id)
            ->sum('amount');

        $total_gains = UserInvestment::where('user_id', $user->id)
            ->where('investment_result', 'gain')
            ->sum('daily_profit_amount');

        $total_losses = UserInvestment::where('user_id', $user->id)
            ->where('investment_result', 'lose')
            ->sum('amount');

        $lifetime_pnl = $total_gains - $total_losses;

        $totalWithdraws = Withdrawal::where('user_id', $user->id)
            ->where('status', 'complete')
            ->sum('amount');

        $payments = Payment::where('user_id', $user->id)
            ->where('payment_status', 'finished')
            ->orderBy('id', 'asc')
            ->paginate(10);

        // --- Pass ALL data to the view ---
        return view('user.pages.account', compact(
            'user',
            'transactions',  // This is now a paginated collection
            'withdrawals',  // The new withdrawals collection
            'deposits',  // The new deposits collection
            'totalReferralEarning',
            'investedCapital',
            'lifetime_pnl',
            'totalWithdraws',
            'payments'
        ));
    }

    public function mywallet()
    {
        $user = Auth::user();
        return view('user.pages.wallet.wallet', compact('user'));
    }

    /**
     * New method to fetch transactions for the authenticated user as JSON.
     */
    public function order()
    {
        return view('user.order');
    }

    public function assets()
    {
        return view('user.layouts.assets');
    }

    public function language()
    {
        return view('user.language');
    }

    public function market()
    {
        return view('user.pages.markets.index');
    }

    public function market_cap()
    {
        return view('user.pages.market-capital.index');
    }

    public function market_cap_bar()
    {
        return view('user.pages.market-capital-bar.index');
    }
}
