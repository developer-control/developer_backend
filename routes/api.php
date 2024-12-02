<?php

use App\Http\Controllers\API\Auth\DeviceController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\DeveloperController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\Project\AreaController;
use App\Http\Controllers\API\Project\BlocController;
use App\Http\Controllers\API\Project\OwnershipUnitController;
use App\Http\Controllers\API\Project\ProjectController;
use App\Http\Controllers\API\Project\UnitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// route for auth user with email or login with google
Route::post('/auth/login', [LoginController::class, 'login']);
Route::post('auth/{provider}/login', [LoginController::class, 'loginProvider']);
// route user for register account user
Route::post('/auth/register', [RegisterController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Authentication & Authorization
|--------------------------------------------------------------------------
|
| Route with auth sanctum for user
|
 */

Route::middleware('auth:sanctum')->group(function () {
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

    Route::get('/developers', [DeveloperController::class, 'index']);
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/areas', [AreaController::class, 'index']);
    Route::get('/projects/blocs', [BlocController::class, 'index']);
    Route::get('/projects/units', [UnitController::class, 'index']);
    Route::get('/projects/ownership-units', [OwnershipUnitController::class, 'index']);
    Route::post('/projects/units/upload-evidence-file', [UnitController::class, 'UploadEvidenceFile']);
    Route::post('/projects/units/store-claim-unit', [UnitController::class, 'storeClaimUnit']);
    Route::get('/projects/units/user-unit', [UnitController::class, 'indexMyUnit']);
    Route::get('/projects/units/history-user-unit', [UnitController::class, 'indexHistoryMyUnit']);
    Route::get('/projects/units/user-unit/detail/{id}', [UnitController::class, 'showUnitUser']);
});


Route::prefix('locations')->group(function () {
    Route::get('/provinces', [LocationController::class, 'indexProvince']);
    Route::get('/cities', [LocationController::class, 'indexCity']);
});
