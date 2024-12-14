<?php

use App\Http\Controllers\API\Auth\DeviceController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use App\Http\Controllers\API\ComplainController;
use App\Http\Controllers\API\DeveloperController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\Posts\ArticleController;
use App\Http\Controllers\API\Project\AreaController;
use App\Http\Controllers\API\Project\BlocController;
use App\Http\Controllers\API\Project\OwnershipUnitController;
use App\Http\Controllers\API\Project\ProjectController;
use App\Http\Controllers\API\Project\UnitController;
use App\Http\Controllers\Base\ImageController;
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
Route::post('/auth/send-verify-email', [RegisterController::class, 'sendEmailVerification']);
Route::post('/auth/verify-email', [RegisterController::class, 'verify']);
Route::post('/forget-password', [ResetPasswordController::class, 'sendResetLink']);
Route::post('/forget-password/validation-token', [ResetPasswordController::class, 'validateToken']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
/*
|--------------------------------------------------------------------------
| Authentication & Authorization
|--------------------------------------------------------------------------
|
| Route with auth sanctum for user
|
 */

Route::middleware(['auth:sanctum', 'verified.api'])->group(function () {
    Route::post('/auth/logout', [LoginController::class, 'logout']);
    Route::post('/media/store-image', [ImageController::class, 'storeImage']);
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
    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index']);
        Route::get('/areas', [AreaController::class, 'index']);
        Route::get('/blocs', [BlocController::class, 'index']);
        Route::get('/ownership-units', [OwnershipUnitController::class, 'index']);

        Route::prefix('units')->group(function () {
            Route::get('/', [UnitController::class, 'index']);
            Route::post('/store-claim-unit', [UnitController::class, 'storeClaimUnit']);
            Route::get('/user-unit', [UnitController::class, 'indexMyUnit']);
            Route::get('/history-user-unit', [UnitController::class, 'indexHistoryMyUnit']);
            Route::get('/user-unit/detail/{id}', [UnitController::class, 'showUnitUser']);
        });
    });
    Route::prefix('complains')->group(function () {
        Route::get('/', [ComplainController::class, 'index']);
        Route::get('/detail/{id}', [ComplainController::class, 'show']);
        Route::post('/store', [ComplainController::class, 'store']);

        Route::put('/update/{id}', [ComplainController::class, 'update']);
        Route::delete('/delete/{id}', [ComplainController::class, 'destroy']);
    });
});


Route::prefix('locations')->group(function () {
    Route::get('/provinces', [LocationController::class, 'indexProvince']);
    Route::get('/cities', [LocationController::class, 'indexCity']);
});

Route::prefix('posts')->group(function () {
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/article/detail/{id}', [ArticleController::class, 'show']);
});
