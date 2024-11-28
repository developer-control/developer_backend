<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class DeviceController extends Controller
{
    /**
     * Set Device Token.
     * 
     * Send device token to set for send notification
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);

        $device = $request->user()->devices()->whereToken($request->token)->first();

        if ($device) {
            $device->touch();
        } else {
            $device = $request->user()->devices()->create($request->all());
        }

        return ApiResponse::success($device, 'Create device token success', 200);
    }

    /**
     * Destroy Device token.
     * 
     * Remove device token from database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $request->validate(['token' => ['required', 'string', 'exists:devices,token']]);

        $model = $request->user()->devices()->firstWhere('token', $request->token);

        optional($model)->delete();
        return ApiResponse::success(null, 'Delete device token success', 204);
    }
}
