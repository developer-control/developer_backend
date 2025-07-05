<?php

use App\Http\Controllers\API\AccessCardController;
use App\Http\Controllers\API\Auth\DeviceController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use App\Http\Controllers\API\Auth\UserController;
use App\Http\Controllers\API\BillController;
use App\Http\Controllers\API\ComplainController;
use App\Http\Controllers\API\DeveloperController;
use App\Http\Controllers\API\EmergencyController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\MasterController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\Posts\ArticleController;
use App\Http\Controllers\API\Posts\BannerController;
use App\Http\Controllers\API\Posts\PromotionController;
use App\Http\Controllers\API\Project\AreaController;
use App\Http\Controllers\API\Project\BlocController;
use App\Http\Controllers\API\Project\FacilityController;
use App\Http\Controllers\API\Project\OwnershipUnitController;
use App\Http\Controllers\API\Project\ProjectController;
use App\Http\Controllers\API\Project\UnitController;
use App\Http\Controllers\API\RenovationPermitController;
use App\Http\Controllers\API\SupportController;
use App\Http\Controllers\Base\ImageController;
use App\Http\Controllers\Setting\FaqController;
use App\Http\Controllers\Setting\TermConditionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['api.developer'])->prefix('/{slug}')->group(function () {
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
        Route::post('/media/store-file', [ImageController::class, 'storeMedia']);

        Route::prefix('notifications')->group(function () {
            Route::get('/', [NotificationController::class, 'index']);
            Route::get('/notification-types', [NotificationController::class, 'indexType']);
            Route::post('/send-notification-user', [NotificationController::class, 'sendNotificationUser']);
            Route::post('/send-notification-topic', [NotificationController::class, 'sendNotificationChannel']);
        });
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

        // Route::get('/developers', [DeveloperController::class, 'index']);
        Route::get('/menus', [MenuController::class, 'index']);
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
            Route::prefix('facilities')->group(function () {
                Route::get('/', [FacilityController::class, 'index']);
                Route::get('/detail/{id}', [FacilityController::class, 'show']);
            });
        });
        Route::prefix('complains')->group(function () {
            Route::get('/', [ComplainController::class, 'index']);
            Route::get('/detail/{id}', [ComplainController::class, 'show']);
            Route::post('/store', [ComplainController::class, 'store']);

            Route::patch('/solved/{id}', [ComplainController::class, 'updateSolve']);
            Route::put('/update/{id}', [ComplainController::class, 'update']);
            Route::delete('/delete/{id}', [ComplainController::class, 'destroy']);
        });
        Route::prefix('access-cards')->group(function () {
            Route::get('/', [AccessCardController::class, 'index']);
            Route::get('/detail/{id}', [AccessCardController::class, 'show']);
            Route::post('/store', [AccessCardController::class, 'store']);

            Route::put('/update/{id}', [AccessCardController::class, 'update']);
            Route::delete('/delete/{id}', [AccessCardController::class, 'destroy']);
        });

        Route::prefix('user')->group(function () {
            Route::get('/detail', [UserController::class, 'show']);
            Route::put('/update', [UserController::class, 'update']);
            Route::delete('/delete-user', [UserController::class, 'removeUser']);
            Route::patch('/change-password', [UserController::class, 'changePassword']);
        });

        Route::get('/emergency-number', [EmergencyController::class, 'index']);

        Route::prefix('unit')->group(function () {
            // api route for get bills for unit
            Route::get('/{unit_id}/bills', [BillController::class, 'index']);
            Route::get('/{unit_id}/bill/total', [BillController::class, 'showTotalBill']);
            Route::get('/{unit_id}/bill/detail', [BillController::class, 'showListBill']);

            // api route for payment bill
            Route::get('/{unit_id}/payments/histories', [PaymentController::class, 'index']);
            Route::get('/{unit_id}/payment/history/{id}', [PaymentController::class, 'show']);
            Route::post('/{unit_id}/payment/store', [PaymentController::class, 'store']);
            Route::get('/{unit_id}/payment/banks', [PaymentController::class, 'indexBank']);
            Route::post('/{unit_id}/payment/data/store', [PaymentController::class, 'storeData']);
            Route::get('/{unit_id}/payment/info', [PaymentController::class, 'showInfoPayment']);


            Route::get('/{unit_id}/renovation-permits', [RenovationPermitController::class, 'index']);
            Route::post('/{unit_id}/renovation-permit/create', [RenovationPermitController::class, 'store']);
            Route::get('/{unit_id}/renovation-permit/detail/{id}', [RenovationPermitController::class, 'show']);
            Route::post('/{unit_id}/renovation-permit/update/{id}', [RenovationPermitController::class, 'update']);
            Route::delete('/{unit_id}/renovation-permit/delete/{id}', [RenovationPermitController::class, 'destroy']);
        });
    });

    Route::get('/supports', [SupportController::class, 'index']);

    Route::prefix('locations')->group(function () {
        Route::get('/provinces', [LocationController::class, 'indexProvince']);
        Route::get('/cities', [LocationController::class, 'indexCity']);
    });

    Route::prefix('posts')->group(function () {
        Route::get('/tags', [ArticleController::class, 'indexTag']);
        Route::get('/articles', [ArticleController::class, 'index']);
        Route::get('/article/detail/{id}', [ArticleController::class, 'show']);
        Route::get('/promotions', [PromotionController::class, 'index']);
        Route::get('/promotion/detail/{id}', [PromotionController::class, 'show']);
        Route::get('/banners', [BannerController::class, 'index']);
        Route::get('/banner/detail/{id}', [BannerController::class, 'show']);
    });

    Route::get('/term-condition', [MasterController::class, 'termCondition']);
    Route::get('/faqs', [MasterController::class, 'faq']);
});
