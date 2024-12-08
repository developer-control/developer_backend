<?php

namespace App\Http\Controllers\API\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    /**
     * Register User Account.
     * 
     * Handle a register user from api
     *
     * @unauthenticated
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // $user->assignRole('user');
        $user->sendEmailVerificationNotification();
        return ApiResponse::success(null, 'Register success, please check your email to verified your account.', 201);
    }

    /**
     * Send Email Verification
     * Handle a request verification email for user.
     *
     * @unauthenticated
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmailVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user->hasVerifiedEmail()) {
            $key = 'send-email.' . $user->id;
            $max = 1;
            $decay = 300;
            if (RateLimiter::tooManyAttempts($key, $max)) {
                $seconds = RateLimiter::availableIn($key);
                return ApiResponse::error('You have made a verification request, please check your email again on the spam, promotions, or primary. You can try again in ' .
                    $seconds .
                    ' seconds', 429);
            } else {
                RateLimiter::hit($key, $decay);
                $user->sendEmailVerificationNotification();
                return ApiResponse::success(null, 'Email verification has been sended, Please check your email to verify your account', 200);
            }
        }
    }
}
