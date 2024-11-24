<?php

use App\Http\Controllers\Base\ImageController;
use App\Http\Controllers\HomeController;
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
 * group route for image
 * 
 * Handle to set device token and delete device token for send notification FCM
 * 
 */
Route::group(['prefix' => 'access-users'], function () {
    Route::get('/role', [RolePermissionController::class, 'index'])->name('master_role');
});
