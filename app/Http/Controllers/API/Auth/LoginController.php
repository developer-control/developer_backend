<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Helpers\ApiResponse;
use Illuminate\Auth\Events\Verified;

class LoginController extends Controller
{
    /**
     * Login by Email.
     * 
     * Handle a login auth request to the api.
     * @unauthenticated
     *  
     * @param  string  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
            'device_token' => 'string',
        ]);

        // getting user
        $user = User::where('email', $request->email)->first();

        // checking credentials
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponse::error('Email or password is incorrect', 422);
        }
        if (!$user->hasVerifiedEmail()) {
            return ApiResponse::error('The user has not verified email address', 403);
        }
        if (!$user->hasRole('user')) {
            return ApiResponse::error('You have no access token', 403);
        }
        if ($request->device_token) {
            $this->storeDeviceToken($user, $request->device_token);
        }
        // Returning response
        $data = [
            'token' => $user->createToken($request->device_name)->plainTextToken
        ];
        return ApiResponse::success($data, 'Login Success.');
    }

    /**
     * Login By Google.
     * 
     * Handle a login by provider request to the api.
     *
     * @unauthenticated
     * @param  string  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginProvider(string $provider, Request $request)
    {
        $request->validate([
            'token' => 'required',
            'device_name' => 'required',
            'device_token' => 'string',
        ]);
        // Getting the user from socialite using token from google
        $socialUser = Socialite::driver($provider)->stateless()->userFromToken($request->token);

        // Getting or creating user from db
        $user = User::firstOrCreate(
            ['email' => $socialUser->email],
            [
                'email_verified_at' => now(),
                'name' => $socialUser->name,
                'password' => Hash::make('password'),
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('user');
            $user->markEmailAsVerified();
            // event(new Verified($user));
        } else {
            if (!$user->hasRole('user')) {
                return ApiResponse::error('You have no access token', 402);
            }
        }
        if ($request->device_token) {
            $this->storeDeviceToken($user, $request->device_token);
        }
        $data = [
            'token' => $user->createToken($request->device_name)->plainTextToken
        ];
        return ApiResponse::success($data, 'Login Success.');
    }


    /**
     * Logout.
     * 
     * Handle a logout request to the api.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if ($request->device_token) {
            try {
                $model = $request->user()->devices()->firstWhere('token', $request->device_token);
                optional($model)->delete();
            } catch (\Throwable $th) {
                return ApiResponse::error('Logout failed, please check your connection', 409);
            }
        }

        $request
            ->user()
            ->currentAccessToken()
            ->delete();

        return ApiResponse::success(null, 'Logout success.', 200);
    }

    private function storeDeviceToken(User $user, string $token)
    {
        $device = $user->devices()->whereToken($token)->first();
        if ($device) {
            $device->touch();
        } else {
            $device = $user->devices()->create([
                'token' => $token
            ]);
        }
    }
}
