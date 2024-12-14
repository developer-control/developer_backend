<?php

namespace App\Http\Controllers\API\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
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

        $status = Password::sendResetLink(
            $request->only('email'),
            function ($user, $token) {
                // Gunakan email untuk mengirim deep link ini
                Mail::to($user->email)->send(new ResetPasswordMail($token));
            }
        );
        if ($status === Password::INVALID_USER) {
            return ApiResponse::error('User not found', 404);
        }
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset link sent to your email.']);
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
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
            'token' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            ApiResponse::error('User not found', 404);
        }
        $status = Password::tokenExists($user, $request->token);
        $data = ['token' => $request->token, 'email' => $request->email, 'status' => $status ? true : false];
        return ApiResponse::success($data, 'validation token success user can reset password', 200);
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
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);
        $response = Password::reset(
            $this->credentials($request),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($response)
            : $this->sendResetFailedResponse($response);
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse($response)
    {
        return new JsonResponse(['message' => trans($response)], 200);
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse($response)
    {

        throw ValidationException::withMessages([
            'email' => [trans($response)],
        ]);
    }
}
