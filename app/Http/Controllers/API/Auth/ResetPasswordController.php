<?php

namespace App\Http\Controllers\API\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\Contracts\Auth\CanResetPassword;

class ResetPasswordController extends Controller
{
    /**
     * Forget Password.
     * 
     * Handle a forget password user from api
     *
     * @unauthenticated
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        // Cek apakah email terdaftar
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return ApiResponse::error('Email not found', 404);
        }
        // Generate OTP
        $otp = random_int(100000, 999999);
        PasswordReset::updateOrCreate(
            ['email' => $request->email],
            [
                'token' => $otp,
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10),
                'created_at' => now(),
            ]
        );
        Mail::to($user->email)->send(new ResetPasswordMail($otp));
        return response()->json(['message' => 'Reset link sent to your email.']);
    }
    /**
     * Validation Token.
     * 
     * Handle a Validation Token user from api
     *
     * @unauthenticated
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            ApiResponse::error('User not found', 404);
        }
        $resetRequest = PasswordReset::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('otp_expires_at', '>', now())
            ->first();

        if (!$resetRequest) {
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        }

        $data = ['otp' => $request->otp, 'email' => $request->email, 'status' => $resetRequest ? true : false];
        return ApiResponse::success($data, 'validation otp success user can reset password', 200);
    }

    /**
     * Reset Password.
     * 
     * Handle a reset password from user for api
     *
     * @unauthenticated
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);
        // Cek OTP
        $resetRequest = PasswordReset::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('otp_expires_at', '>', now())
            ->first();

        if (!$resetRequest) {
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        }

        // Update password user
        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        // Hapus OTP setelah reset password
        PasswordReset::where('email', $request->email)->delete();

        return response()->json(['message' => 'Password reset successfully']);
    }
}
