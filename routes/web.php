<?php

use App\Http\Controllers\Base\ImageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name(
    'home'
);

Route::post('/store-article-image', [ImageController::class, 'storeArticleImage']);
