<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;



class UserAuthController extends Controller
{
    
    
    

    public function showRegisterForm(Request $request)
    {
        
        return view('user.pages.signup');
    }



    public function register(Request $request)
    {

        $request->validate([
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'currency' => 'required|string',
            'invitation_code' => 'required|string|exists:users,referral_code',
            'password' => 'required|string|confirmed|min:8',
            'agree' => 'required|accepted',
        ]);

        // 1. Look for the referring user via referral_code
        $referrer = null;
        if ($request->filled('invitation_code')) {
            $referrer = User::where('referral_code', $request->invitation_code)->first();
        }

        // 2. Generate unique_id and referral_code
        do {
            $uniqueId = rand(8000000000, 8999999999);
        } while (User::where('unique_id', $uniqueId)->exists());

        do {
            $referralCode = strtoupper(Str::random(6));
        } while (User::where('referral_code', $referralCode)->exists());

        // 3. Create the new user with the referrer_id if found
        $user = User::create([

            'username' => $request->username,
            'email' => $request->email,
            'currency' => $request->currency,
            'password' => Hash::make($request->password),
            'unique_id' => $uniqueId,
            'referral_code' => $referralCode,
            'referrer_id' => optional($referrer)->id,
            'balance' => 1

        ]);


        Auth::login($user);

        // Check if withdrawal settings are missing
        if (is_null($user->withdrawal_address) || is_null($user->withdrawal_pin_hash)) {
            return redirect()->route('withdraw.setup')->with('warning', 'Please set your withdrawal address and PIN first.');
        }

        return redirect()->route('dashboard');
    }

    public function showLoginForm()
    {
        return view('user.pages.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status === 'blocked') {
                Auth::logout();

                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your account is inactive. Please contact support.'
                    ], 403);

                }

                return back()->withErrors([
                    'username' => 'Your account is inactive. Please contact support.',
                ])->withInput();
            }

            $request->session()->regenerate();

            // Check if withdrawal settings are missing
            if (is_null($user->withdrawal_address) || is_null($user->withdrawal_pin_hash)) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Please set your withdrawal address and PIN first.',
                        'redirect' => route('withdraw.setup')
                    ]);
                }

                return redirect()->route('withdraw.setup')->with('warning', 'Please set your withdrawal address and PIN first.');
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Logged in successfully.',
                    'redirect' => route('dashboard')
                ]);
            }

            return redirect()->intended(route('dashboard'))->with('success', 'Logged in successfully.');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password ..!'
            ], 422);
        }

        return back()->withErrors([
            'username' => 'Invalid Username or Password ..!',
        ])->onlyInput('username');


    }

// public function login(Request $request)
// {
//     // Validate input
//     $credentials = $request->validate([
//         'username' => 'required|string',
//         'password' => 'required|string|min:6',
//     ]);

//     // Attempt login
//     if (!Auth::attempt($credentials)) {
//         // Invalid credentials
//         if ($request->ajax()) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Invalid username or password.'
//             ], 401);
//         }
//         return back()->withErrors([
//             'username' => 'Invalid username or password.'
//         ])->onlyInput('username');
//     }

//     $user = Auth::user();

//     // Blocked account check
//     if ($user->status === 'blocked') {
//         Auth::logout();

//         if ($request->ajax()) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Your account is inactive. Please contact support.'
//             ], 403);
//         }

//         return back()->withErrors([
//             'username' => 'Your account is inactive. Please contact support.'
//         ])->withInput();
//     }

//     // Regenerate session
//     $request->session()->regenerate();

//     // Check withdrawal setup
//     if (is_null($user->withdrawal_address) || is_null($user->withdrawal_pin_hash)) {
//         if ($request->ajax()) {
//             return response()->json([
//                 'success' => true,
//                 'message' => 'Please set your withdrawal address and PIN first.',
//                 'redirect' => route('withdraw.setup')
//             ]);
//         }

//         return redirect()->route('withdraw.setup')->with('warning', 'Please set your withdrawal address and PIN first.');
//     }

//     // Successful login
//     if ($request->ajax()) {
//         return response()->json([
//             'success' => true,
//             'message' => 'Logged in successfully.',
//             'redirect' => route('dashboard')
//         ]);
//     }

//     return redirect()->intended(route('dashboard'))->with('success', 'Logged in successfully.');
// }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');
    }
}