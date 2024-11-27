<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Login by Email.
     * 
     * Handle a login auth request to the api.
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
        ]);

        // getting user
        $user = User::where('email', $request->email)->first();

        // checking credentials
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    'status' => 'unprocessable entity',
                    'message' => 'Email or password is incorrect.',
                    'data' => null,
                ],
                422
            );
        }
        if (!$user->hasRole('user')) {
            return response()->json(
                [
                    'status' => 'forbidden',
                    'message' => 'You have no access token',
                    'data' => null,
                ],
                403
            );
        }
        if ($request->device_token) {
            $this->storeDeviceToken($user, $request->device_token);
        }
        // Returning response
        return $this->sendResponseLogin($user, $request);
    }

    /**
     * Login By Google.
     * 
     * Handle a login by provider request to the api.
     *
     * @param  string  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginProvider(string $provider, Request $request)
    {
        $request->validate([
            'token' => 'required',
            'device_name' => 'required',
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
        } else {
            if (!$user->hasRole('user')) {
                return response()->json(
                    [
                        'status' => 'forbidden',
                        'message' => 'You have no access token',
                        'data' => null,
                    ],
                    403
                );
            }
        }
        if ($request->device_token) {
            $this->storeDeviceToken($user, $request->device_token);
        }
        return $this->sendResponseLogin($user, $request);
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
                return response()->json(
                    [
                        'status' => 'failed',
                        'message' => 'Logout failed, please check your connection',
                        'data' => null,
                    ],
                    409
                );
            }
        }

        $request
            ->user()
            ->currentAccessToken()
            ->delete();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Logout success.',
                'data' => null,
            ],
            200
        );
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

    private function sendResponseLogin(User $user, Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Login success.',
                'data' => [
                    'token' => $user->createToken($request->device_name)->plainTextToken
                ],
            ],
            200
        );
    }
}
