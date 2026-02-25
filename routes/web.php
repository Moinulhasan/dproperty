<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::get('privacy-policy', [HomePageController::class, 'privacy'])->name('privacy-policy');
Route::get('terms-of-use', [HomePageController::class, 'terms'])->name('terms-of-use');

Route::get('site-map', [HomePageController::class, 'sitemap'])->name('site-map');

Route::get('property-details/{id}', [HomePageController::class, 'property_details'])->name('property-details');

Route::get('buy', [HomePageController::class, 'buy'])->name('buy');
Route::get('sell', [HomePageController::class, 'sell'])->name('sell');
Route::get('rent', [HomePageController::class, 'rent'])->name('rent');

Route::get('article/{slug}', [HomePageController::class, 'article_details'])->name('article-details');

