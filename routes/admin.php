<?php


use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\DashboardController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/post-login', [AuthController::class, 'postLogin'])->name('postlogin');
});

Route::group([], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'user'], function () {
        Route::get('user-list', [AuthController::class, 'userList'])->name('user.list');
    });
});
