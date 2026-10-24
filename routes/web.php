<?php

use App\Http\Controllers\CompanyRegistrationController;
use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;
use Spatie\ResponseCache\Middlewares\CacheResponse;

// Guest full-page cache (10 min, config/responsecache.php) on the busiest read-only pages.
// Only URLs without a query string are cached (filters/pagination render fresh).
// Cleared whenever an admin saves or deletes content (FlushesSiteCache).
Route::get('/', [HomePageController::class, 'index'])->name('home')->middleware(CacheResponse::class);

Route::get('privacy-policy', [HomePageController::class, 'privacy'])->name('privacy-policy');
Route::get('terms-of-use', [HomePageController::class, 'terms'])->name('terms-of-use');

Route::get('site-map', [HomePageController::class, 'sitemap'])->name('site-map');
Route::get('sitemap.xml', [HomePageController::class, 'sitemapXml'])->name('sitemap.xml');

Route::get('property-details/{id}', [HomePageController::class, 'property_details'])->name('property-details')->middleware(CacheResponse::class);

Route::get('buy', [HomePageController::class, 'buy'])->name('buy')->middleware(CacheResponse::class);
Route::get('sell', [HomePageController::class, 'sell'])->name('sell')->middleware(CacheResponse::class);
Route::get('rent', [HomePageController::class, 'rent'])->name('rent')->middleware(CacheResponse::class);

Route::get('article/{slug}', [HomePageController::class, 'article_details'])->name('article-details');

Route::get('location/{id}', [HomePageController::class, 'locationProperties'])->name('location.properties')->middleware(CacheResponse::class);
Route::get('contact-us', [HomePageController::class, 'contact'])->name('contact');
// Public forms: 5 submissions per minute per visitor (spam / disk-filling uploads).
Route::post('contact-us', [HomePageController::class, 'contactInquirySubmit'])->name('contact.submit')->middleware('throttle:5,1');
Route::get('service', [HomePageController::class, 'service'])->name('service');
Route::get('about-us', [HomePageController::class, 'aboutUs'])->name('about-us');
Route::get('blog', [HomePageController::class, 'blog'])->name('blog');
Route::get('post-property', [HomePageController::class, 'postProperty'])->name('post-property');
Route::post('post-property', [HomePageController::class, 'postPropertySubmit'])->name('post-property.submit')->middleware('throttle:5,1');

Route::get('company-register',  [CompanyRegistrationController::class, 'show'])->name('company.register');
Route::post('company-register', [CompanyRegistrationController::class, 'submit'])->name('company.register.submit')->middleware('throttle:5,1');

