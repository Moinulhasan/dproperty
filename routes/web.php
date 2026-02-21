<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::get('privacy-policy', [HomePageController::class, 'privacy'])->name('privacy-policy');
Route::get('terms-of-use', [HomePageController::class, 'terms'])->name('terms-of-use');

Route::get('site-map', [HomePageController::class, 'sitemap'])->name('site-map');
