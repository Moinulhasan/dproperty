<?php


use App\Http\Controllers\Admin\AppSettingsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\DashboardController;
use \Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/post-login', [AuthController::class, 'postLogin'])->name('postlogin');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::group(['prefix' => 'user'], function () {
        Route::get('user-list', [AuthController::class, 'userList'])->name('user.list');
        Route::get('user-add', [AuthController::class, 'userAdd'])->name('user.add');
        Route::post('user-add', [AuthController::class, 'userAddPost'])->name('user.add.post');
        Route::get('user-edit/{user}', [AuthController::class, 'userEdit'])->name('user.edit');
        Route::post('user-edit/{user}', [AuthController::class, 'userEditPost'])->name('user.update');
        Route::get('user-delete/{user}', [AuthController::class, 'userDelete'])->name('user.delete');
    });

    Route::group(['prefix' => 'slider'], function () {
        Route::get('list', [SliderController::class, 'sliderList'])->name('slider.list');
        Route::get('add', [SliderController::class, 'sliderAdd'])->name('slider.add');
        Route::post('add', [SliderController::class, 'sliderAddPost'])->name('slider.add.post');
        Route::get('edit/{slider}', [SliderController::class, 'sliderEdit'])->name('slider.edit');
        Route::post('edit/{slider}', [SliderController::class, 'sliderEditPost'])->name('slider.edit.post');
        Route::get('delete/{slider}', [SliderController::class, 'sliderDelete'])->name('slider.delete');
    });

    Route::group(['prefix'=>'services'],function(){
        Route::get('list', [ServiceController::class, 'index'])->name('service.list');
        Route::get('add', [ServiceController::class, 'add'])->name('service.add');
        Route::post('add', [ServiceController::class, 'addPost'])->name('service.add.post');
        Route::get('edit/{service}', [ServiceController::class, 'edit'])->name('service.edit');
        Route::post('edit/{service}', [ServiceController::class, 'editPost'])->name('service.edit.post');
        Route::get('delete/{service}', [ServiceController::class, 'delete'])->name('service.delete');
    });

    Route::group(['prefix' => 'testimonials'], function () {
        Route::get('list', [TestimonialController::class, 'index'])->name('testimonial.list');
        Route::get('add', [TestimonialController::class, 'add'])->name('testimonial.add');
        Route::post('add', [TestimonialController::class, 'addPost'])->name('testimonial.add.post');
        Route::get('edit/{testimonial}', [TestimonialController::class, 'edit'])->name('testimonial.edit');
        Route::post('edit/{testimonial}', [TestimonialController::class, 'editPost'])->name('testimonial.edit.post');
        Route::get('delete/{testimonial}', [TestimonialController::class, 'delete'])->name('testimonial.delete');
    });

    Route::group(['prefix' => 'properties'], function () {
        Route::get('list', [PropertyController::class, 'index'])->name('property.list');
        Route::get('add', [PropertyController::class, 'add'])->name('property.add');
        Route::post('add', [PropertyController::class, 'addPost'])->name('property.add.post');
        Route::get('edit/{property}', [PropertyController::class, 'edit'])->name('property.edit');
        Route::post('edit/{property}', [PropertyController::class, 'editPost'])->name('property.edit.post');
        Route::get('delete/{property}', [PropertyController::class, 'delete'])->name('property.delete');
    });

    Route::group(['prefix' => 'app-settings'], function () {
        Route::get('list', [AppSettingsController::class, 'appSettings'])->name('app.settings');
        Route::post('update', [AppSettingsController::class, 'updateAppSettings'])->name('app.settings.update');
    });

    Route::group(['prefix'=>'tags'],function (){
        Route::get('list',[ServiceController::class,'tagList'])->name('tag.list');
        Route::get('add',[ServiceController::class,'tagAdd'])->name('tag.add');
        Route::post('add',[ServiceController::class,'tagAddPost'])->name('tag.add.post');
        Route::get('edit/{tag}',[ServiceController::class,'tagEdit'])->name('tag.edit');
        Route::post('edit/{tag}',[ServiceController::class,'tagEditPost'])->name('tag.edit.post');
        Route::get('delete/{tag}',[ServiceController::class,'tagDelete'])->name('tag.delete');
    });
});
