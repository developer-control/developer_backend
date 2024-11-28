<?php

use App\Http\Controllers\Base\ImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Location\CityController;
use App\Http\Controllers\Location\ProvinceController;
use App\Http\Controllers\Master\RolePermissionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');



/**
 * group route for image
 * 
 * Handle to set device token and delete device token for send notification FCM
 * 
 */
Route::group(['prefix' => 'images'], function () {
    Route::post('/article-image', [ImageController::class, 'storeArticleImage']);
});

/**
 * group route for access user setting
 * 
 * Handle to set device token and delete device token for send notification FCM
 * 
 */

Route::group(['prefix' => 'access-users'], function () {
    Route::get('/role', [RolePermissionController::class, 'index'])->name('master_role');
    Route::get('/role-datatable', [RolePermissionController::class, 'roleDatatable']);
    Route::post('/role/create', [RolePermissionController::class, 'store'])->name('store_role');
    Route::post('/role/update/{id}', [RolePermissionController::class, 'update'])->name('update_role');
    Route::delete('/role/delete/{id}', [RolePermissionController::class, 'destroy'])->name('delete_role');
});

/**
 * group route for location settings
 * 
 * Handle to set device token and delete device token for send notification FCM
 * 
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
