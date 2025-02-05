<?php

use App\Http\Controllers\Admin\ComplainController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Base\ImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Location\CityController;
use App\Http\Controllers\Location\ProvinceController;
use App\Http\Controllers\Master\BillTypeController;
use App\Http\Controllers\Master\DeveloperController;
use App\Http\Controllers\Master\EmergencyController;
use App\Http\Controllers\Master\OwnershipUnitController;
use App\Http\Controllers\Master\RolePermissionController;
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
});

/**
 * group route for access user setting
 */

Route::group(['prefix' => 'access-users'], function () {
    Route::get('/role', [RolePermissionController::class, 'index'])->name('master_role');
    Route::get('/role-datatable', [RolePermissionController::class, 'roleDatatable']);
    Route::post('/role/create', [RolePermissionController::class, 'store'])->name('store_role');
    Route::post('/role/update/{id}', [RolePermissionController::class, 'update'])->name('update_role');
    Route::delete('/role/delete/{id}', [RolePermissionController::class, 'destroy'])->name('delete_role');
});

/**
 * group route master developer
 */
Route::group(['prefix' => 'developers'], function () {
    Route::get('/', [DeveloperController::class, 'index'])->name('master_developer');
    Route::get('/datatable', [DeveloperController::class, 'developerDatatable']);
    Route::get('/option-developers', [DeveloperController::class, 'optionDeveloper']);
    Route::post('/create', [DeveloperController::class, 'store'])->name('store_developer');
    Route::post('/update/{id}', [DeveloperController::class, 'update'])->name('update_developer');
    Route::delete('/delete/{id}', [DeveloperController::class, 'destroy'])->name('delete_developer');
});
/**
 * group route master bill
 */
Route::group(['prefix' => 'bill-types'], function () {
    Route::get('/', [BillTypeController::class, 'index'])->name('menu_bill_type');
    Route::get('/datatable', [BillTypeController::class, 'billTypeDatatable']);
    Route::get('/option-bill-types', [BillTypeController::class, 'optionBillType']);
    Route::post('/create', [BillTypeController::class, 'store'])->name('store_bill_type');
    Route::post('/update/{id}', [BillTypeController::class, 'update'])->name('update_bill_type');
    Route::delete('/delete/{id}', [BillTypeController::class, 'destroy'])->name('delete_bill_type');
});

Route::group(['prefix' => 'supports'], function () {
    Route::get('/', [SupportController::class, 'index'])->name('menu_support');
    Route::get('/datatable', [SupportController::class, 'supportDatatable']);
    Route::post('/create', [SupportController::class, 'store'])->name('store_support');
    Route::post('/update/{id}', [SupportController::class, 'update'])->name('update_support');
    Route::delete('/delete/{id}', [SupportController::class, 'destroy'])->name('delete_support');
});
Route::group(['prefix' => 'emergency-numbers'], function () {
    Route::get('/', [EmergencyController::class, 'index'])->name('menu_emergency');
    Route::get('/datatable', [EmergencyController::class, 'emergencyDatatable']);
    Route::post('/create', [EmergencyController::class, 'store'])->name('store_emergency');
    Route::post('/update/{id}', [EmergencyController::class, 'update'])->name('update_emergency');
    Route::delete('/delete/{id}', [EmergencyController::class, 'destroy'])->name('delete_emergency');
});

Route::group(['prefix' => 'term-conditions'], function () {
    Route::get('/', [TermConditionController::class, 'index'])->name('menu_term_condition');
    Route::get('/create', [TermConditionController::class, 'create'])->name('create_term_condition');
    Route::post('/store', [TermConditionController::class, 'store'])->name('store_term_condition');
    Route::get('/edit/{id}', [TermConditionController::class, 'edit'])->name('edit_term_condition');
    Route::post('/update/{id}', [TermConditionController::class, 'update'])->name('update_term_condition');
    Route::delete('/delete/{id}', [TermConditionController::class, 'destroy'])->name('delete_term_condition');
});
Route::group(['prefix' => 'faqs'], function () {
    Route::get('/', [FaqController::class, 'index'])->name('menu_faq');
    Route::get('/datatable', [FaqController::class, 'faqDatatable']);
    Route::get('/create', [FaqController::class, 'create'])->name('create_faq');
    Route::post('/store', [FaqController::class, 'store'])->name('store_faq');
    Route::get('/edit/{id}', [FaqController::class, 'edit'])->name('edit_faq');
    Route::post('/update/{id}', [FaqController::class, 'update'])->name('update_faq');
    Route::delete('/delete/{id}', [FaqController::class, 'destroy'])->name('delete_faq');
});

Route::group(['prefix' => 'posts'], function () {
    Route::prefix('articles')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('menu_article');
        Route::get('/create', [ArticleController::class, 'create'])->name('create_article');
        Route::post('/store', [ArticleController::class, 'store'])->name('store_article');
        Route::get('/edit/{id}', [ArticleController::class, 'edit'])->name('edit_article');
        Route::post('/update/{id}', [ArticleController::class, 'update'])->name('update_article');
        Route::delete('/delete/{id}', [ArticleController::class, 'destroy'])->name('delete_article');
    });
    Route::prefix('promotions')->group(function () {
        Route::get('/', [PromotionController::class, 'index'])->name('menu_promotion');
        Route::get('/create', [PromotionController::class, 'create'])->name('create_promotion');
        Route::post('/store', [PromotionController::class, 'store'])->name('store_promotion');
        Route::get('/edit/{id}', [PromotionController::class, 'edit'])->name('edit_promotion');
        Route::post('/update/{id}', [PromotionController::class, 'update'])->name('update_promotion');
        Route::delete('/delete/{id}', [PromotionController::class, 'destroy'])->name('delete_promotion');
    });
    Route::prefix('banners')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('menu_banner');
        Route::get('/create', [BannerController::class, 'create'])->name('create_banner');
        Route::post('/store', [BannerController::class, 'store'])->name('store_banner');
        Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('edit_banner');
        Route::post('/update/{id}', [BannerController::class, 'update'])->name('update_banner');
        Route::delete('/delete/{id}', [BannerController::class, 'destroy'])->name('delete_banner');
    });
});
/**
 * group route master ownership unit
 */
Route::group(['prefix' => 'ownership-units'], function () {
    Route::get('/', [OwnershipUnitController::class, 'index'])->name('master_ownership');
    Route::get('/datatable', [OwnershipUnitController::class, 'ownershipDatatable']);
    Route::get('/option-ownerships', [OwnershipUnitController::class, 'optionOwnership']);
    Route::post('/create', [OwnershipUnitController::class, 'store'])->name('store_ownership');
    Route::post('/update/{id}', [OwnershipUnitController::class, 'update'])->name('update_ownership');
    Route::delete('/delete/{id}', [OwnershipUnitController::class, 'destroy'])->name('delete_ownership');
});
/**
 * group route master projects
 */
Route::group(['prefix' => 'projects'], function () {
    Route::get('/', [ProjectController::class, 'index'])->name('menu_project');
    Route::get('/option-projects', [ProjectController::class, 'optionProject']);
    Route::get('/datatable', [ProjectController::class, 'projectDatatable']);
    Route::post('/create', [ProjectController::class, 'store'])->name('store_project');
    Route::post('/update/{id}', [ProjectController::class, 'update'])->name('update_project');
    Route::delete('/delete/{id}', [ProjectController::class, 'destroy'])->name('delete_project');
});

/**
 * group route master areas
 */
Route::group(['prefix' => 'areas'], function () {
    Route::get('/', [AreaController::class, 'index'])->name('menu_area');
    Route::get('/option-areas', [AreaController::class, 'optionArea']);
    Route::get('/datatable', [AreaController::class, 'areaDatatable']);
    Route::post('/create', [AreaController::class, 'store'])->name('store_area');
    Route::post('/update/{id}', [AreaController::class, 'update'])->name('update_area');
    Route::delete('/delete/{id}', [AreaController::class, 'destroy'])->name('delete_area');
});
/**
 * group route master project bloc
 */
Route::group(['prefix' => 'blocs'], function () {
    Route::get('/', [BlocController::class, 'index'])->name('menu_bloc');
    Route::get('/option-blocs', [BlocController::class, 'optionBloc']);
    Route::get('/datatable', [BlocController::class, 'blocDatatable']);
    Route::post('/create', [BlocController::class, 'store'])->name('store_bloc');
    Route::post('/update/{id}', [BlocController::class, 'update'])->name('update_bloc');
    Route::delete('/delete/{id}', [BlocController::class, 'destroy'])->name('delete_bloc');
});
/**
 * group route master project units
 */
Route::group(['prefix' => 'units'], function () {
    Route::get('/', [UnitController::class, 'index'])->name('menu_unit');
    Route::get('/detail/{id}', [UnitController::class, 'show'])->name('menu_detail_unit');
    Route::get('/datatable', [UnitController::class, 'unitDatatable']);
    Route::post('/create', [UnitController::class, 'store'])->name('store_unit');
    Route::post('/update/{id}', [UnitController::class, 'update'])->name('update_unit');
    Route::delete('/delete/{id}', [UnitController::class, 'destroy'])->name('delete_unit');

    Route::get('/request-units', [UserUnitController::class, 'indexRequest'])->name('menu_request_claim_unit');
    Route::get('/request-units/datatable', [UserUnitController::class, 'requestDatatable']);
    Route::post('/request-unit/approve/{id}', [UserUnitController::class, 'updateApprove'])->name('approve_claim_unit');
    Route::post('/request-unit/reject/{id}', [UserUnitController::class, 'updateReject'])->name('reject_claim_unit');

    Route::get('/history-request-units', [UserUnitController::class, 'indexHistoryRequest'])->name('menu_history_claim_unit');
    Route::get('/history-request-unit/datatable', [UserUnitController::class, 'historyRequestDatatable']);
});
/**
 * group route for location settings
 */

Route::group(['prefix' => 'locations'], function () {
    // route group for provinces 
    Route::group(['prefix' => 'provinces'], function () {
        Route::get('/', [ProvinceController::class, 'index'])->name('location_province');
        Route::get('/option-provinces', [ProvinceController::class, 'indexOption']);
        Route::get('/initialize', [ProvinceController::class, 'initializeProvince'])->name('initialize_province');
        Route::get('/datatable', [ProvinceController::class, 'provinceDatatable']);
        Route::post('/create', [ProvinceController::class, 'store'])->name('store_province');
        Route::post('/update/{id}', [ProvinceController::class, 'update'])->name('update_province');
        Route::delete('/delete/{id}', [ProvinceController::class, 'destroy'])->name('delete_province');
    });

    Route::group(['prefix' => 'cities'], function () {
        Route::get('/', [CityController::class, 'index'])->name('location_city');
        Route::get('/option-cities', [CityController::class, 'indexOption']);
        Route::get('/initialize', [CityController::class, 'initializeCity'])->name('initialize_city');
        Route::get('/datatable', [CityController::class, 'cityDatatable']);
        Route::post('/create', [CityController::class, 'store'])->name('store_city');
        Route::post('/update/{id}', [CityController::class, 'update'])->name('update_city');
        Route::delete('/delete/{id}', [CityController::class, 'destroy'])->name('delete_city');
    });
});

Route::prefix('facilities')->group(function () {
    Route::get('/', [FacilityController::class, 'index'])->name('menu_facility');
    Route::get('/datatable', [FacilityController::class, 'facilityDatatable']);
    Route::get('/create', [FacilityController::class, 'create'])->name('create_facility');
    Route::post('/store', [FacilityController::class, 'store'])->name('store_facility');
    Route::get('/edit/{id}', [FacilityController::class, 'edit'])->name('edit_facility');
    Route::post('/update/{id}', [FacilityController::class, 'update'])->name('update_facility');
    Route::delete('/delete/{id}', [FacilityController::class, 'destroy'])->name('delete_facility');
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
Route::group(['prefix' => 'complains'], function () {
    Route::get('/', [ComplainController::class, 'index'])->name('menu_complain');
    Route::get('/detail/{id}', [ComplainController::class, 'show'])->name('menu_detail_complain');
    Route::post('/solved-complain/{id}', [ComplainController::class, 'updateSolve'])->name('solve_complain');
    Route::get('/datatable', [ComplainController::class, 'dataTable']);
});
