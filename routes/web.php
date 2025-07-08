<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
});
Route::get('privacy-policy', function () {
    return view('pages.privacy_policy');
})->name('privacy-policy');
Route::get('terms-of-use', function () {
   return view('pages.tc');
})->name('terms-of-use');

Route::get('site-map', function () {
    return view('pages.sitemap');
})->name('site-map');
