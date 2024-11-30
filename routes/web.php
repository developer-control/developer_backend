<?php

use App\Http\Controllers\Base\ImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Location\CityController;
use App\Http\Controllers\Location\ProvinceController;
use App\Http\Controllers\Master\DeveloperController;
use App\Http\Controllers\Master\RolePermissionController;
use App\Http\Controllers\Project\AreaController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Project\UnitController;
use App\Http\Controllers\Project\BlocController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');



/**
 * group route for image
 */
Route::group(['prefix' => 'images'], function () {
    Route::post('/article-image', [ImageController::class, 'storeArticleImage']);
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
    Route::post('/create', [DeveloperController::class, 'store'])->name('store_developer');
    Route::post('/update/{id}', [DeveloperController::class, 'update'])->name('update_developer');
    Route::delete('/delete/{id}', [DeveloperController::class, 'destroy'])->name('delete_developer');
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
    Route::get('/datatable', [UnitController::class, 'unitDatatable']);
    Route::post('/create', [UnitController::class, 'store'])->name('store_unit');
    Route::post('/update/{id}', [UnitController::class, 'update'])->name('update_unit');
    Route::delete('/delete/{id}', [UnitController::class, 'destroy'])->name('delete_unit');
});
/**
 * group route for location settings
 */

Route::group(['prefix' => 'locations'], function () {
    // route group for provinces 
    Route::group(['prefix' => 'provinces'], function () {
        Route::get('/', [ProvinceController::class, 'index'])->name('location_province');
        Route::get('/initialize', [ProvinceController::class, 'initializeProvince'])->name('initialize_province');
        Route::get('/datatable', [ProvinceController::class, 'provinceDatatable']);
        Route::post('/create', [ProvinceController::class, 'store'])->name('store_province');
        Route::post('/update/{id}', [ProvinceController::class, 'update'])->name('update_province');
        Route::delete('/delete/{id}', [ProvinceController::class, 'destroy'])->name('delete_province');
    });

    Route::group(['prefix' => 'cities'], function () {
        Route::get('/', [CityController::class, 'index'])->name('location_city');
        Route::get('/initialize', [CityController::class, 'initializeCity'])->name('initialize_city');
        Route::get('/datatable', [CityController::class, 'cityDatatable']);
        Route::post('/create', [CityController::class, 'store'])->name('store_city');
        Route::post('/update/{id}', [CityController::class, 'update'])->name('update_city');
        Route::delete('/delete/{id}', [CityController::class, 'destroy'])->name('delete_city');
    });
});
