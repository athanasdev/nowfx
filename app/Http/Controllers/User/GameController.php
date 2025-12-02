<?php

namespace App\Http\Controllers\User; // Assuming this is the correct namespace for your GameController

use App\Http\Controllers\Controller;
use App\Models\GameSetting;
use App\Models\Referral;
use App\Models\ReferralSetting; // Make sure this model exists if used in distributeReferralCommissions
use App\Models\UserInvestment;
use App\Models\Transaction; // Uncomment if you implement Transaction logging
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class GameController extends Controller
{




    public function aitrading()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view this page.');
        }

        // Use Carbon::now('UTC') for correct comparison with UTC database timestamps
        $nowUTC = Carbon::now('UTC');

        // Fetches a game setting that is currently active
        $activeGameSetting = GameSetting::where('is_active', true)
            ->where('start_time', '<=', $nowUTC)
            ->where('end_time', '>', $nowUTC)
            ->orderBy('start_time', 'desc')
            ->first();

        // If no game is active, find the next upcoming one
        if (!$activeGameSetting) {
            $activeGameSetting = GameSetting::where('is_active', true)
                ->where('start_time', '>', $nowUTC)
                ->orderBy('start_time', 'asc')
                ->first();
        }

        // Fetch user's pending investments for the active game
        $activeUserInvestment = collect();
        if ($activeGameSetting) {
            $activeUserInvestment = UserInvestment::where('user_id', $user->id)
                ->where('game_setting_id', $activeGameSetting->id)
                ->where('investment_result', 'pending')
                ->get();
        }

    
        // --- Bot Statistics ---

        // The corrected query to SUM the profit from all 'gain' trades in the last 24 hours
        $bot_profit_24h = UserInvestment::where('user_id', $user->id)
            ->where('investment_result', 'gain')
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->sum('daily_profit_amount');

        // 2. Calculate Trades and Success Rate in the last 24h
        $trades_in_24h_query = UserInvestment::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subDay());

        $bot_trades_24h = (clone $trades_in_24h_query)->count();
        $successful_trades_24h = (clone $trades_in_24h_query)->where('investment_result', 'gain')->count();

        if ($bot_trades_24h > 0) {
            $success_rate = ($successful_trades_24h / $bot_trades_24h) * 100;
        } else {
            $success_rate = 0;
        }
        // This is the variable holding the calculated percentage, e.g., 85.7
        $bot_success_rate = number_format($success_rate, 1);


        // 3. Calculate Bot Uptime
        $first_investment = UserInvestment::where('user_id', $user->id)->oldest()->first();
        $bot_uptime_seconds = 0;
        if ($first_investment) {
            // Calculate difference in seconds between the first investment and now
            $bot_uptime_seconds = $first_investment->created_at->diffInSeconds(Carbon::now());
        }

        // 4. Check if the bot is globally active (e.g., from a user setting)
        $is_bot_globally_active = $user->is_trading_bot_enabled ?? false;

        // Pass all calculated variables to the view
        return view('user.pages.index', compact(
            'user',
            'activeGameSetting',
            'activeUserInvestment',
            'bot_profit_24h',
            'bot_trades_24h',
            'bot_success_rate', 
            'bot_uptime_seconds',
            'is_bot_globally_active'
        ));
    }


// public function placeTrade(Request $request)
// {
//     /** @var \App\Models\User $user */
//     $user = Auth::user();

//     $nowLocal = Carbon::now();

//     // Validate the request
//     $validatedData = $request->validate([
//         'crypto_category' => [
//             'required',
//             Rule::in([
//                 'BTC','ETH','XRP','SOL','PI','LTC','BCH','ADA','DOT','BNB','DOGE','SHIB','LINK','MATIC','TRX',
//                 'EOS','XLM','ATOM','VET','FIL','NEO','ALGO','XTZ','AAVE','UNI','SUSHI','ICP','AVAX','FTT',
//                 'MKR','CAKE','KSM','ZEC','DASH','COMP','SNX','YFI','BAT','ENJ','CHZ','OMG','QTUM','NANO',
//                 'RVN','ONT','HNT','FTM'
//             ])
//         ],
//         'trade_type' => ['required', Rule::in(['buy', 'sell'])],
//         'amount' => 'required|numeric|min:15|max:' . $user->balance,
//     ], [
//         'amount.max' => 'Insufficient balance for this trade amount.',
//         'amount.min' => 'The minimum trade amount is $15.'
//     ]);

//     // Check 1-minute cooldown
//     $tradeWithinLastMinute = UserInvestment::where('user_id', $user->id)
//         ->where('created_at', '>=', $nowLocal->copy()->subMinute())
//         ->exists();

//     if ($tradeWithinLastMinute) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Hi champions, kindly await at least 1 minute before placing another trade.'
//         ]);
//     }

//     // Get active signal
//     $gameSetting = GameSetting::where('is_active', true)
//         ->where('start_time', '<=', $nowLocal)
//         ->where('end_time', '>', $nowLocal)
//         ->orderBy('start_time', 'desc')
//         ->first();

//     if (!$gameSetting) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Hi champions, kindly await the signal time.'
//         ]);
//     }

//     // Check for existing pending trade
//     $existingPendingInvestment = UserInvestment::where('user_id', $user->id)
//         ->where('game_setting_id', $gameSetting->id)
//         ->where('investment_result', 'pending')
//         ->exists();

//     if ($existingPendingInvestment) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Hi champions, you have an active trade in this signal.'
//         ]);
//     }

//     // Calculate daily profit
//     $dailyProfit = $validatedData['amount'] * ($gameSetting->earning_percentage / 100);

//     // Place trade in DB transaction
//     DB::beginTransaction();
//     try {
//         $user->balance -= $validatedData['amount'];
//         $user->save();

//         UserInvestment::create([
//             'user_id' => $user->id,
//             'game_setting_id' => $gameSetting->id,
//             'investment_date' => $nowLocal->toDateString(),
//             'amount' => $validatedData['amount'],
//             'game_start_time' => $gameSetting->start_time,
//             'game_end_time' => $gameSetting->end_time,
//             'type' => $validatedData['trade_type'],
//             'crypto_category' => $validatedData['crypto_category'],
//             'investment_result' => 'pending',
//             'daily_profit_amount' => $dailyProfit,
//             'total_profit_paid_out' => 0,
//             'principal_returned' => false,
//         ]);

//         DB::commit();

//         // Return success for toast
//         return response()->json([
//             'success' => true,
//             'message' => 'Your trade has been placed successfully!'
//         ]);
//     } catch (\Exception $e) {
//         DB::rollBack();
//         Log::error('Trade placement failed for user ' . $user->id . ': ' . $e->getMessage());

//         return response()->json([
//             'success' => false,
//             'message' => 'An unexpected server error occurred. Please try again.'
//         ]);
//     }
// }


//  public function placeTrade(Request $request)
// {
//     /** @var \App\Models\User $user */
//     $user = Auth::user();

//     $nowLocal = Carbon::now();

//     // Validate the request
//     $validatedData = $request->validate([
//         'crypto_category' => [
//             'required',
//             Rule::in([
//                 'BTC','ETH','XRP','SOL','PI','LTC','BCH','ADA','DOT','BNB','DOGE','SHIB','LINK','MATIC','TRX',
//                 'EOS','XLM','ATOM','VET','FIL','NEO','ALGO','XTZ','AAVE','UNI','SUSHI','ICP','AVAX','FTT',
//                 'MKR','CAKE','KSM','ZEC','DASH','COMP','SNX','YFI','BAT','ENJ','CHZ','OMG','QTUM','NANO',
//                 'RVN','ONT','HNT','FTM'
//             ])
//         ],
//         'trade_type' => ['required', Rule::in(['buy', 'sell'])],
//         'amount' => 'required|numeric|min:15|max:' . $user->balance,
//     ], [
//         'amount.max' => 'Insufficient balance for this trade amount.',
//         'amount.min' => 'The minimum trade amount is $15.'
//     ]);

//     // Check 1-minute cooldown
//     $tradeWithinLastMinute = UserInvestment::where('user_id', $user->id)
//         ->where('created_at', '>=', $nowLocal->copy()->subMinute())
//         ->exists();

//     if ($tradeWithinLastMinute) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Please wait at least 1 minute before placing another trade.'
//         ]);
//     }

//     // Prevent trade if the last game has ended
//     $lastGame = GameSetting::where('is_active', true)
//         ->orderBy('end_time', 'desc')
//         ->first();

//     if (!$lastGame || $nowLocal->gt($lastGame->end_time)) {
//         return response()->json([
//             'success' => false,
//             'message' => 'No active signal available. Please wait for the next game.'
//         ]);
//     }

//     // Get active game for this exact moment
//     $gameSetting = GameSetting::where('is_active', true)
//         ->where('start_time', '<=', $nowLocal)
//         ->where('end_time', '>', $nowLocal)
//         ->orderBy('start_time', 'desc')
//         ->first();

//     if (!$gameSetting) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Hi champions, kindly await the signal time.'
//         ]);
//     }

//     // Check for existing pending trade
//     $existingPendingInvestment = UserInvestment::where('user_id', $user->id)
//         ->where('game_setting_id', $gameSetting->id)
//         ->where('investment_result', 'pending')
//         ->exists();

//     if ($existingPendingInvestment) {
//         return response()->json([
//             'success' => false,
//             'message' => 'You already have an active trade in this signal.'
//         ]);
//     }

//     // Calculate daily profit
//     $dailyProfit = $validatedData['amount'] * ($gameSetting->earning_percentage / 100);

//     // Place trade in DB transaction
//     DB::beginTransaction();
//     try {
//         $user->balance -= $validatedData['amount'];
//         $user->save();

//         UserInvestment::create([
//             'user_id' => $user->id,
//             'game_setting_id' => $gameSetting->id,
//             'investment_date' => $nowLocal->toDateString(),
//             'amount' => $validatedData['amount'],
//             'game_start_time' => $gameSetting->start_time,
//             'game_end_time' => $gameSetting->end_time,
//             'type' => $validatedData['trade_type'],
//             'crypto_category' => $validatedData['crypto_category'],
//             'investment_result' => 'pending',
//             'daily_profit_amount' => $dailyProfit,
//             'total_profit_paid_out' => 0,
//             'principal_returned' => false,
//         ]);

//         DB::commit();

//         return response()->json([
//             'success' => true,
//             'message' => 'Your trade has been placed successfully!'
//         ]);
//     } catch (\Exception $e) {
//         DB::rollBack();
//         Log::error('Trade placement failed for user ' . $user->id . ': ' . $e->getMessage());

//         return response()->json([
//             'success' => false,
//             'message' => 'An unexpected server error occurred. Please try again.'
//         ]);
//     }
// }



public function placeTrade(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Always work in UTC since game times are stored in UTC
    $nowUtc = Carbon::now('UTC');

    // Validate the request
    $validatedData = $request->validate([
        'crypto_category' => [
            'required',
            Rule::in([
                'BTC','ETH','XRP','SOL','PI','LTC','BCH','ADA','DOT','BNB','DOGE','SHIB','LINK','MATIC','TRX',
                'EOS','XLM','ATOM','VET','FIL','NEO','ALGO','XTZ','AAVE','UNI','SUSHI','ICP','AVAX','FTT',
                'MKR','CAKE','KSM','ZEC','DASH','COMP','SNX','YFI','BAT','ENJ','CHZ','OMG','QTUM','NANO',
                'RVN','ONT','HNT','FTM'
            ])
        ],
        'trade_type' => ['required', Rule::in(['buy', 'sell'])],
        'amount' => 'required|numeric|min:1|max:' . $user->balance,
    ], [
        'amount.max' => 'Insufficient balance for this trade amount.',
        'amount.min' => 'The minimum trade amount is $1.'
    ]);

    // Check 1-minute cooldown
    $tradeWithinLastMinute = UserInvestment::where('user_id', $user->id)
        ->where('created_at', '>=', $nowUtc->copy()->subMinute())
        ->exists();

    if ($tradeWithinLastMinute) {
        return response()->json([
            'success' => false,
            'message' => 'Please wait at least 1 minute before placing another trade.'
        ]);
    }

    // Prevent trade if the last game has already ended
    $lastGame = GameSetting::where('is_active', true)
        ->orderBy('end_time', 'desc')
        ->first();

    if (!$lastGame || $nowUtc->gt(Carbon::parse($lastGame->end_time, 'UTC'))) {
        return response()->json([
            'success' => false,
            'message' => 'Hi champions, kindly await the signal time.'
        ]);
    }

    // Get currently active game
    $gameSetting = GameSetting::where('is_active', true)
        ->where('start_time', '<=', $nowUtc)
        ->where('end_time', '>', $nowUtc)
        ->orderBy('start_time', 'desc')
        ->first();

    if (!$gameSetting) {
        return response()->json([
            'success' => false,
            'message' => 'Hi champions, kindly await the signal time.'
        ]);
    }

    // Check for existing pending trade
    $existingPendingInvestment = UserInvestment::where('user_id', $user->id)
        ->where('game_setting_id', $gameSetting->id)
        ->where('investment_result', 'pending')
        ->exists();

    if ($existingPendingInvestment) {
        return response()->json([
            'success' => false,
            'message' => 'You already have an active trade in this signal.'
        ]);
    }

    // Calculate daily profit
    $dailyProfit = $validatedData['amount'] * ($gameSetting->earning_percentage / 100);

    // Place trade in DB transaction
    DB::beginTransaction();
    try {
        $user->balance -= $validatedData['amount'];
        $user->save();

        UserInvestment::create([
            'user_id' => $user->id,
            'game_setting_id' => $gameSetting->id,
            'investment_date' => $nowUtc->toDateString(),
            'amount' => $validatedData['amount'],
            'game_start_time' => $gameSetting->start_time,
            'game_end_time' => $gameSetting->end_time,
            'type' => $validatedData['trade_type'],
            'crypto_category' => $validatedData['crypto_category'],
            'investment_result' => 'pending',
            'daily_profit_amount' => $dailyProfit,
            'total_profit_paid_out' => 0,
            'principal_returned' => false,
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Your trade order has been placed successfully!'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Trade placement failed for user ' . $user->id . ': ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'An unexpected server error occurred. Please try again.'
        ]);
    }
}




 

    /**
     * Close an active trade and determine result.
     */


    public function closeTrade(Request $request)
    {

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $now = Carbon::now();

        $validatedData = $request->validate([
            'user_investment_id' => 'required|exists:user_investments,id',
        ]);

        $investment = UserInvestment::where('id', $validatedData['user_investment_id'])
            ->where('user_id', $user->id)
            ->where('investment_result', 'pending')
            ->first();

        if (!$investment) {
            return redirect()->back()->with('error', 'Invalid or already processed investment.');
        }

        DB::beginTransaction();

        try {
            $investment->investment_result = 'canceled';
            $investment->daily_profit_amount = 0;
            $investment->total_profit_paid_out = 0;
            $investment->principal_returned = true;
            $investment->game_end_time = $now;
            $investment->save();

            $user->balance += $investment->amount;
            $user->save();

            Transaction::create([
                'user_id'        => $user->id,
                'type'           => 'credit',
                'amount'         => $investment->amount,
                'balance_before' => $user->balance - $investment->amount,
                'balance_after'  => $user->balance,
                'status'         => 'refunded',
                'description'    => 'Trade cancelled...',
            ]);

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Trade cancelled. Your investment has been refunded.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error cancelling trade: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not cancel trade. Please try again.');
        }

    }


    /**
     * Distribute referral commissions based on a user's profit from a specific investment.
     */

    protected function distributeReferralCommissions(User $referredUser, float $profitAmount)
    {
        if ($profitAmount <= 0) {
            return;
        }

        $currentReferrer = $referredUser->referrer;
        $level = 1;
        $maxLevels = 3; // Max referral levels to pay commission

        while ($currentReferrer && $level <= $maxLevels) {
            $referralSetting = ReferralSetting::where('level', $level)->first();

            if ($referralSetting && $referralSetting->commission_percentage > 0) {
                $commission = $profitAmount * ($referralSetting->commission_percentage / 100);

                if ($commission > 0) {
                    $currentReferrer->balance += $commission;
                    $currentReferrer->save();


                    Transaction::create([
                        'user_id' => $currentReferrer->id,
                        'type' => 'credit',
                        'amount' => $commission,
                        'balance_before' => $currentReferrer->balance,
                        'balance_after' => $currentReferrer->balance + $commission,
                        'status' => 'gain',
                        'description' => "Level {$level} commission from user {$referredUser->username}'s trade profit.",

                    ]);
                    Log::info("Awarded Level {$level} commission of {$commission} to user {$currentReferrer->username} from profit of user {$referredUser->username}");
                }
            }

            // Move to the next level referrer
            if (!$currentReferrer->referrer) break; // No more upline referrers
            $currentReferrer = $currentReferrer->referrer;
            $level++;
        }
    }
}