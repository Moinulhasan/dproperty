<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomePageController::class,'index'])->name('home');
Route::get('privacy-policy', function () {
    return view('pages.privacy_policy');
})->name('privacy-policy');
Route::get('terms-of-use', function () {
   return view('pages.tc');
})->name('terms-of-use');

Route::get('site-map', function () {
    return view('pages.sitemap');
})->name('site-map');
Route::get('welcome', function () {
    return view('welcome');
})->name('welcome');
