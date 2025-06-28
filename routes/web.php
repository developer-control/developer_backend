<?php

use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\ComplainController;
use App\Http\Controllers\Admin\PaymentUserController;
use App\Http\Controllers\Admin\RenovationPermitController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Base\ImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Location\CityController;
use App\Http\Controllers\Location\ProvinceController;
use App\Http\Controllers\Master\BillTypeController;
use App\Http\Controllers\Master\DeveloperBankController;
use App\Http\Controllers\Master\DeveloperController;
use App\Http\Controllers\Master\DeveloperPermissionController;
use App\Http\Controllers\Master\EmergencyController;
use App\Http\Controllers\Master\FeatureController;
use App\Http\Controllers\Master\OwnershipUnitController;
use App\Http\Controllers\Master\PermissionController;
use App\Http\Controllers\Master\RolePermissionController;
use App\Http\Controllers\Master\SubscriptionController;
use App\Http\Controllers\Master\SupportController;
use App\Http\Controllers\Post\ArticleController;
use App\Http\Controllers\Post\BannerController;
use App\Http\Controllers\Post\PromotionController;
use App\Http\Controllers\Project\AccessCardController;
use App\Http\Controllers\Project\AreaController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Project\UnitController;
use App\Http\Controllers\Project\BlocController;
use App\Http\Controllers\Project\FacilityController;
use App\Http\Controllers\Project\UserUnitController;
use App\Http\Controllers\Setting\FaqController;
use App\Http\Controllers\Setting\PaymentMasterController;
use App\Http\Controllers\Setting\TermConditionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');


/**
 * group route for image
 */
Route::group(['prefix' => 'images'], function () {
    Route::post('/article-image', [ImageController::class, 'storeArticleImage']);
    Route::post('/promotion-image', [ImageController::class, 'storePromotionImage']);
    Route::post('/banner-image', [ImageController::class, 'storeBannerImage']);
    Route::post('/facility-image', [ImageController::class, 'storeFacilityImage']);
    Route::post('/developer-bank-image', [ImageController::class, 'storeBankDeveloperImage']);
});

/**
 * group route master developer
 */
Route::prefix('bills')->name('bill.')->group(function () {
    Route::get('/', [BillController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [BillController::class, 'dataTable'])->name('data')->middleware('office.permission:read');
    Route::get('/detail/{id}', [BillController::class, 'show'])->name('detail')->middleware('office.permission:read');
    Route::get('/create', [BillController::class, 'create'])->name('create')->middleware('office.permission:create');
    Route::post('/store', [BillController::class, 'store'])->name('store')->middleware('office.permission:create');
    Route::get('/edit/{id}', [BillController::class, 'edit'])->name('edit')->middleware('office.permission:edit');
    Route::post('/update/{id}', [BillController::class, 'update'])->name('update')->middleware('office.permission:edit');
    Route::delete('/delete/{id}', [BillController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');

    Route::prefix('types')->name('type.')->group(function () {
        Route::get('/', [BillTypeController::class, 'index'])->name('index')->middleware('office.permission:read');
        Route::get('/datatable', [BillTypeController::class, 'billTypeDatatable'])->name('data')->middleware('office.permission:read');
        Route::post('/create', [BillTypeController::class, 'store'])->name('store')->middleware('office.permission:create');
        Route::post('/update/{id}', [BillTypeController::class, 'update'])->name('update')->middleware('office.permission:edit');
        Route::delete('/delete/{id}', [BillTypeController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
        Route::get('/option', [BillTypeController::class, 'optionBillType'])->name('option');
    });
});

Route::prefix('payments')->name('payment.')->group(function () {
    Route::get('/', [PaymentUserController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [PaymentUserController::class, 'dataTable'])->name('data')->middleware('office.permission:read');
    Route::get('/detail/{id}', [PaymentUserController::class, 'show'])->name('detail')->middleware('office.permission:read');
    Route::post('/approve/{id}', [PaymentUserController::class, 'updateApprove'])->name('approve')->middleware('office.permission:action');
    Route::post('/reject/{id}', [PaymentUserController::class, 'updateReject'])->name('reject')->middleware('office.permission:action');
});

Route::group(['prefix' => 'posts'], function () {
    Route::prefix('articles')->name('article.')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('index')->middleware('office.permission:read');
        Route::get('/create', [ArticleController::class, 'create'])->name('create')->middleware('office.permission:create');
        Route::post('/store', [ArticleController::class, 'store'])->name('store')->middleware('office.permission:create');
        Route::get('/edit/{id}', [ArticleController::class, 'edit'])->name('edit')->middleware('office.permission:edit');
        Route::post('/update/{id}', [ArticleController::class, 'update'])->name('update')->middleware('office.permission:edit');
        Route::delete('/delete/{id}', [ArticleController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
    });
    Route::prefix('promotions')->name('promotion.')->group(function () {
        Route::get('/', [PromotionController::class, 'index'])->name('index')->middleware('office.permission:read');
        Route::get('/create', [PromotionController::class, 'create'])->name('create')->middleware('office.permission:create');
        Route::post('/store', [PromotionController::class, 'store'])->name('store')->middleware('office.permission:create');
        Route::get('/edit/{id}', [PromotionController::class, 'edit'])->name('edit')->middleware('office.permission:edit');
        Route::post('/update/{id}', [PromotionController::class, 'update'])->name('update')->middleware('office.permission:edit');
        Route::delete('/delete/{id}', [PromotionController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
    });
    Route::prefix('banners')->name('banner.')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('index')->middleware('office.permission:read');
        Route::get('/create', [BannerController::class, 'create'])->name('create')->middleware('office.permission:create');
        Route::post('/store', [BannerController::class, 'store'])->name('store')->middleware('office.permission:create');
        Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('edit')->middleware('office.permission:edit');
        Route::post('/update/{id}', [BannerController::class, 'update'])->name('update')->middleware('office.permission:edit');
        Route::delete('/delete/{id}', [BannerController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
    });
});
Route::prefix('complains')->name('complain.')->group(function () {
    Route::get('/', [ComplainController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [ComplainController::class, 'dataTable'])->name('data')->middleware('office.permission:read');
    Route::get('/detail/{id}', [ComplainController::class, 'show'])->name('detail')->middleware('office.permission:read');
    Route::post('/solved/{id}', [ComplainController::class, 'updateSolve'])->name('solve')->middleware('office.permission:action');
});

Route::prefix('projects')->name('project.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [ProjectController::class, 'projectDatatable'])->name('data')->middleware('office.permission:read');
    Route::post('/create', [ProjectController::class, 'store'])->name('store')->middleware('office.permission:create');
    Route::post('/update/{id}', [ProjectController::class, 'update'])->name('update')->middleware('office.permission:edit');
    Route::delete('/delete/{id}', [ProjectController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
    Route::get('/option', [ProjectController::class, 'optionProject'])->name('option');
});

/**
 * group route master areas
 */
Route::prefix('areas')->name('area.')->group(function () {
    Route::get('/', [AreaController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [AreaController::class, 'areaDatatable'])->name('data')->middleware('office.permission:read');
    Route::post('/create', [AreaController::class, 'store'])->name('store')->middleware('office.permission:create');
    Route::post('/update/{id}', [AreaController::class, 'update'])->name('update')->middleware('office.permission:edit');
    Route::delete('/delete/{id}', [AreaController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
    Route::get('/option', [AreaController::class, 'optionArea'])->name('option');
});
/**
 * group route master project bloc
 */
Route::prefix('blocs')->name('bloc.')->group(function () {
    Route::get('/', [BlocController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [BlocController::class, 'blocDatatable'])->name('data')->middleware('office.permission:read');
    Route::post('/create', [BlocController::class, 'store'])->name('store')->middleware('office.permission:create');
    Route::post('/update/{id}', [BlocController::class, 'update'])->name('update')->middleware('office.permission:edit');
    Route::delete('/delete/{id}', [BlocController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
    Route::get('/option', [BlocController::class, 'optionBloc'])->name('option');
});
/**
 * group route master project units
 */
Route::prefix('units')->name('unit.')->group(function () {
    Route::get('/', [UnitController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [UnitController::class, 'unitDatatable'])->name('data')->middleware('office.permission:read');
    Route::get('/detail/{id}', [UnitController::class, 'show'])->name('detail')->middleware('office.permission:read');
    Route::post('/create', [UnitController::class, 'store'])->name('store')->middleware('office.permission:create');
    Route::post('/update/{id}', [UnitController::class, 'update'])->name('update')->middleware('office.permission:edit');
    Route::delete('/delete/{id}', [UnitController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
    Route::get('/option', [UnitController::class, 'optionUnit'])->name('option');

    Route::prefix('request')->name('request.')->group(function () {
        Route::get('/', [UserUnitController::class, 'indexRequest'])->name('index')->middleware('office.permission:read');
        Route::get('/datatable', [UserUnitController::class, 'requestDatatable'])->name('data')->middleware('office.permission:read');
        Route::post('/approve/{id}', [UserUnitController::class, 'updateApprove'])->name('approve')->middleware('office.permission:action');
        Route::post('/reject/{id}', [UserUnitController::class, 'updateReject'])->name('reject')->middleware('office.permission:action');
        Route::get('/history', [UserUnitController::class, 'indexHistoryRequest'])->name('history.index')->middleware('office.permission:read');
        Route::get('/history/datatable', [UserUnitController::class, 'historyRequestDatatable'])->name('history.data')->middleware('office.permission:read');
    });
    Route::prefix('ownerships')->name('ownership.')->group(function () {
        Route::get('/', [OwnershipUnitController::class, 'index'])->name('index')->middleware('office.permission:read');
        Route::get('/datatable', [OwnershipUnitController::class, 'ownershipDatatable'])->name('data')->middleware('office.permission:read');
        Route::post('/create', [OwnershipUnitController::class, 'store'])->name('store')->middleware('office.permission:create');
        Route::post('/update/{id}', [OwnershipUnitController::class, 'update'])->name('update')->middleware('office.permission:edit');
        Route::delete('/delete/{id}', [OwnershipUnitController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
        Route::get('/option', [OwnershipUnitController::class, 'optionOwnership'])->name('option');
    });
});
Route::prefix('facilities')->name('facility.')->group(function () {
    Route::get('/', [FacilityController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [FacilityController::class, 'facilityDatatable'])->name('data')->middleware('office.permission:read');
    Route::get('/create', [FacilityController::class, 'create'])->name('create')->middleware('office.permission:create');
    Route::post('/store', [FacilityController::class, 'store'])->name('store')->middleware('office.permission:create');
    Route::get('/edit/{id}', [FacilityController::class, 'edit'])->name('edit')->middleware('office.permission:edit');
    Route::post('/update/{id}', [FacilityController::class, 'update'])->name('update')->middleware('office.permission:edit');
    Route::delete('/delete/{id}', [FacilityController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
});

/**
 * group route master developer
 */
Route::prefix('developers')->name('developer.')->group(function () {
    Route::get('/', [DeveloperController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [DeveloperController::class, 'developerDatatable'])->name('data')->middleware('office.permission:read');
    Route::post('/create', [DeveloperController::class, 'store'])->name('store')->middleware('office.permission:create');
    Route::post('/update/{id}', [DeveloperController::class, 'update'])->name('update')->middleware('office.permission:edit');
    Route::delete('/delete/{id}', [DeveloperController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
    Route::get('/option', [DeveloperController::class, 'optionDeveloper'])->name('option');
    Route::prefix('/{developer:id}/permission')->name('permission.')->group(function () {
        Route::get('/edit', [DeveloperPermissionController::class, 'edit'])->name('edit')->middleware('office.permission:edit');
        Route::post('/update', [DeveloperPermissionController::class, 'update'])->name('update')->middleware('office.permission:edit');
    });
    Route::prefix('banks')->name('bank.')->group(function () {
        Route::get('/', [DeveloperBankController::class, 'index'])->name('index')->middleware('office.permission:read');
        Route::get('/datatable', [DeveloperBankController::class, 'dataTable'])->name('data')->middleware('office.permission:read');
        Route::get('/create', [DeveloperBankController::class, 'create'])->name('create')->middleware('office.permission:create');
        Route::post('/store', [DeveloperBankController::class, 'store'])->name('store')->middleware('office.permission:create');
        Route::get('/edit/{id}', [DeveloperBankController::class, 'edit'])->name('edit')->middleware('office.permission:edit');
        Route::post('/update/{id}', [DeveloperBankController::class, 'update'])->name('update')->middleware('office.permission:edit');
        Route::delete('/delete/{id}', [DeveloperBankController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
    });
    // tutup dulu karena beda flow sistem
    Route::get('/subscriptions/{id}', [DeveloperController::class, 'showSubscription'])->name('developer_subscription');
    Route::get('/subscriptions/{id}/datatable', [DeveloperController::class, 'dataTableSubscription']);
    Route::post('/subscription/store/{id}', [DeveloperController::class, 'storeSubscription'])->name('store_developer_subscription');
    Route::delete('/subscription/delete/{id}', [DeveloperController::class, 'destroySubscription'])->name('delete_developer_subscription');
});

Route::prefix('supports')->name('support.')->group(function () {
    Route::get('/', [SupportController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [SupportController::class, 'supportDatatable'])->name('data')->middleware('office.permission:read');
    Route::post('/create', [SupportController::class, 'store'])->name('store')->middleware('office.permission:create');
    Route::post('/update/{id}', [SupportController::class, 'update'])->name('update')->middleware('office.permission:edit');
    Route::delete('/delete/{id}', [SupportController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
});

Route::prefix('emergency-numbers')->name('emergency.')->group(function () {
    Route::get('/', [EmergencyController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [EmergencyController::class, 'emergencyDatatable'])->name('data')->middleware('office.permission:read');
    Route::post('/create', [EmergencyController::class, 'store'])->name('store')->middleware('office.permission:create');
    Route::post('/update/{id}', [EmergencyController::class, 'update'])->name('update')->middleware('office.permission:edit');
    Route::delete('/delete/{id}', [EmergencyController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
});

Route::prefix('term-conditions')->name('term-condition.')->group(function () {
    Route::get('/', [TermConditionController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/create', [TermConditionController::class, 'create'])->name('create')->middleware('office.permission:create');
    Route::post('/store', [TermConditionController::class, 'store'])->name('store')->middleware('office.permission:create');
    Route::get('/edit/{id}', [TermConditionController::class, 'edit'])->name('edit')->middleware('office.permission:edit');
    Route::post('/update/{id}', [TermConditionController::class, 'update'])->name('update')->middleware('office.permission:edit');
    Route::delete('/delete/{id}', [TermConditionController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
});

Route::prefix('faqs')->name('faq.')->group(function () {
    Route::get('/', [FaqController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [FaqController::class, 'faqDatatable'])->name('data')->middleware('office.permission:read');
    Route::post('/store', [FaqController::class, 'store'])->name('store')->middleware('office.permission:create');
    Route::post('/update/{id}', [FaqController::class, 'update'])->name('update')->middleware('office.permission:edit');
    Route::delete('/delete/{id}', [FaqController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
});

/**
 * group route master features
 */
Route::prefix('features')->name('feature.')->group(function () {
    Route::get('/', [FeatureController::class, 'index'])->name('index')->middleware('office.permission:read');
    Route::get('/datatable', [FeatureController::class, 'dataTable'])->name('data')->middleware('office.permission:read');
    Route::post('/create', [FeatureController::class, 'store'])->name('store')->middleware('office.permission:create');
    Route::post('/update/{id}', [FeatureController::class, 'update'])->name('update')->middleware('office.permission:edit');
    Route::delete('/delete/{id}', [FeatureController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
});

/**
 * group route for access user setting
 */

Route::prefix('access-users')->group(function () {
    Route::prefix('role')->name('role.')->group(function () {
        Route::get('/', [RolePermissionController::class, 'index'])->name('index')->middleware('office.permission:read');
        Route::get('/datatable', [RolePermissionController::class, 'roleDatatable'])->name('data')->middleware('office.permission:read');
        Route::post('/create', [RolePermissionController::class, 'store'])->name('store')->middleware('office.permission:create');
        Route::post('/update/{id}', [RolePermissionController::class, 'update'])->name('update')->middleware('office.permission:edit');
        Route::delete('/delete/{id}', [RolePermissionController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
    });
    Route::prefix('permission')->name('permission.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index')->middleware('office.permission:read');
        Route::get('/datatable', [PermissionController::class, 'permissionDatatable'])->name('data')->middleware('office.permission:read');
        Route::post('/create', [PermissionController::class, 'store'])->name('store')->middleware('office.permission:create');
        Route::post('/update/{id}', [PermissionController::class, 'update'])->name('update')->middleware('office.permission:edit');
        Route::delete('/delete/{id}', [PermissionController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
    });
});

Route::prefix('locations')->name('location.')->group(function () {
    // route group for provinces 
    Route::prefix('provinces')->name('province.')->group(function () {
        Route::get('/', [ProvinceController::class, 'index'])->name('index')->middleware('office.permission:read');
        Route::get('/datatable', [ProvinceController::class, 'provinceDatatable'])->name('data')->middleware('office.permission:read');
        Route::post('/create', [ProvinceController::class, 'store'])->name('store')->middleware('office.permission:create');
        Route::get('/initialize', [ProvinceController::class, 'initializeProvince'])->name('initialize')->middleware('office.permission:create');
        Route::post('/update/{id}', [ProvinceController::class, 'update'])->name('update')->middleware('office.permission:edit');
        Route::delete('/delete/{id}', [ProvinceController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
        Route::get('/option-provinces', [ProvinceController::class, 'indexOption'])->name('option');
    });

    Route::prefix('cities')->name('city.')->group(function () {
        Route::get('/', [CityController::class, 'index'])->name('index')->middleware('office.permission:read');
        Route::get('/datatable', [CityController::class, 'cityDatatable'])->name('data')->middleware('office.permission:read');
        Route::get('/initialize', [CityController::class, 'initializeCity'])->name('initialize')->middleware('office.permission:create');
        Route::post('/create', [CityController::class, 'store'])->name('store')->middleware('office.permission:create');
        Route::post('/update/{id}', [CityController::class, 'update'])->name('update')->middleware('office.permission:edit');
        Route::delete('/delete/{id}', [CityController::class, 'destroy'])->name('delete')->middleware('office.permission:delete');
        Route::get('/option-cities', [CityController::class, 'indexOption'])->name('option');
    });
});


/**
 * group route master developer
 */
Route::group(['prefix' => 'access-cards'], function () {
    Route::get('/', [AccessCardController::class, 'index'])->name('menu_access_card');
    Route::get('/datatable', [AccessCardController::class, 'dataTable']);
});

/**
 * group route master developer
 */
Route::group(['prefix' => 'renovation-permits'], function () {
    Route::get('/', [RenovationPermitController::class, 'index'])->name('menu_renovation_permit');
    Route::get('/detail/{id}', [RenovationPermitController::class, 'show'])->name('menu_detail_renovation_permit');
    Route::post('/validation-permit/{id}', [RenovationPermitController::class, 'updateValidate'])->name('validate_renovation_permit');
    Route::get('/datatable', [RenovationPermitController::class, 'dataTable']);
});


Route::group(['prefix' => 'payment-masters'], function () {
    Route::get('/', [PaymentMasterController::class, 'index'])->name('menu_payment_master');
    Route::get('/datatable', [PaymentMasterController::class, 'dataTable']);
    Route::post('/store', [PaymentMasterController::class, 'store'])->name('store_payment_master');
    Route::post('/update/{id}', [PaymentMasterController::class, 'update'])->name('update_payment_master');
    Route::delete('/delete/{id}', [PaymentMasterController::class, 'destroy'])->name('delete_payment_master');
});




/**
 * route subscription di tutup dulu karena flow diganti ke per developer diakses permission berbeda saja
 * 
 */
Route::group(['prefix' => 'subscriptions'], function () {
    Route::get('/', [SubscriptionController::class, 'index'])->name('menu_subscription');
    Route::get('/datatable', [SubscriptionController::class, 'dataTable']);
    Route::get('/detail/{id}', [SubscriptionController::class, 'show'])->name('detail_subscription');
    Route::post('/subscription-feature/{id}', [SubscriptionController::class, 'subscribeFeature'])->name('subscription_feature');
    Route::post('/create', [SubscriptionController::class, 'store'])->name('store_subscription');
    Route::post('/update/{id}', [SubscriptionController::class, 'update'])->name('update_subscription');
    Route::delete('/delete/{id}', [SubscriptionController::class, 'destroy'])->name('delete_subscription');
});
