<?php

namespace App\Http\Controllers\API\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        $user->assignRole('user');
        $user->generateVerificationCode();

        // Kirim email dengan kode verifikasi
        Mail::to($user->email)->send(new VerificationCodeMail($user));
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
                Mail::to($user->email)->send(new VerificationCodeMail($user));
                return ApiResponse::success(null, 'Email verification has been sended, Please check your email to verify your account', 200);
            }
        }
    }

    /**
     * Do Verify user account
     * Handle a verification email for user with verification code.
     *
     * @unauthenticated
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|size:6',
        ]);
        $user = User::where('email', $request->email)
            ->where('verification_code', $request->verification_code)
            ->first();

        if (!$user) {
            return ApiResponse::error('Invalid verification code or email.', 422);
        }
        event(new Verified($user));
        // $user->email_verified_at = now();
        $user->verification_code = null; // Hapus kode setelah verifikasi
        $user->save();
        return ApiResponse::success(null, 'Email verified successfully', 200);
        return response()->json(['message' => 'Email verified successfully.'], 200);
    }
}
