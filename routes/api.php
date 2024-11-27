<?php

use App\Http\Controllers\API\Auth\DeviceController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/auth/login', [LoginController::class, 'login']);

Route::post('auth/{provider}/login', [LoginController::class, 'loginProvider']);
Route::post('/auth/register', [RegisterController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Authentication & Authorization
|--------------------------------------------------------------------------
|
| Route with auth sanctum for user/agent
|
 */

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/auth/logout', [LoginController::class, 'logout']);
    /**
     * Devices
     * 
     * Handle to set device token and delete device token for send notification FCM
     * 
     */

    Route::group(['prefix' => 'devices'], function () {
        Route::post('/store', [DeviceController::class, 'store']);
        Route::delete('/delete', [DeviceController::class, 'destroy']);
    });
});
