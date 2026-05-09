<?php

use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\AppSettingsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyDetailController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\PropertyRequestController;
use App\Http\Controllers\Admin\ContactInquiryController;
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
        Route::post('image-delete/{property}', [PropertyController::class, 'deleteImage'])->name('property.image.delete');
    });

    Route::group(['prefix' => 'property-requests'], function () {
        Route::get('list', [PropertyRequestController::class, 'index'])->name('property-request.list');
        Route::get('show/{propertyRequest}', [PropertyRequestController::class, 'show'])->name('property-request.show');
        Route::post('update-status/{propertyRequest}', [PropertyRequestController::class, 'updateStatus'])->name('property-request.update-status');
        Route::get('delete/{propertyRequest}', [PropertyRequestController::class, 'delete'])->name('property-request.delete');
    });

    Route::group(['prefix' => 'contact-inquiries'], function () {
        Route::get('list', [ContactInquiryController::class, 'index'])->name('contact-inquiry.list');
        Route::get('show/{contactInquiry}', [ContactInquiryController::class, 'show'])->name('contact-inquiry.show');
        Route::post('update-status/{contactInquiry}', [ContactInquiryController::class, 'updateStatus'])->name('contact-inquiry.update-status');
        Route::get('delete/{contactInquiry}', [ContactInquiryController::class, 'delete'])->name('contact-inquiry.delete');
    });

    Route::group(['prefix' => 'locations'], function () {
        Route::get('list', [LocationController::class, 'index'])->name('location.list');
        Route::get('add', [LocationController::class, 'add'])->name('location.add');
        Route::post('add', [LocationController::class, 'addPost'])->name('location.add.post');
        Route::get('edit/{location}', [LocationController::class, 'edit'])->name('location.edit');
        Route::post('edit/{location}', [LocationController::class, 'editPost'])->name('location.edit.post');
        Route::get('delete/{location}', [LocationController::class, 'delete'])->name('location.delete');
    });

    Route::group(['prefix' => 'property-details'], function () {
        Route::get('list', [PropertyDetailController::class, 'index'])->name('property-detail.list');
        Route::get('add', [PropertyDetailController::class, 'add'])->name('property-detail.add');
        Route::post('add', [PropertyDetailController::class, 'addPost'])->name('property-detail.add.post');
        Route::get('edit/{propertyDetail}', [PropertyDetailController::class, 'edit'])->name('property-detail.edit');
        Route::post('edit/{propertyDetail}', [PropertyDetailController::class, 'editPost'])->name('property-detail.edit.post');
        Route::get('delete/{propertyDetail}', [PropertyDetailController::class, 'delete'])->name('property-detail.delete');
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

    Route::group(['prefix' => 'roles'], function () {
        Route::get('list', [RoleController::class, 'index'])->name('role.list');
        Route::get('add', [RoleController::class, 'add'])->name('role.add');
        Route::post('add', [RoleController::class, 'addPost'])->name('role.add.post');
        Route::get('edit/{role}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('edit/{role}', [RoleController::class, 'editPost'])->name('role.edit.post');
        Route::get('delete/{role}', [RoleController::class, 'delete'])->name('role.delete');
    });

    Route::group(['prefix' => 'permissions'], function () {
        Route::get('list', [PermissionController::class, 'index'])->name('permission.list');
        Route::get('add', [PermissionController::class, 'add'])->name('permission.add');
        Route::post('add', [PermissionController::class, 'addPost'])->name('permission.add.post');
        Route::get('edit/{permission}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::post('edit/{permission}', [PermissionController::class, 'editPost'])->name('permission.edit.post');
        Route::get('delete/{permission}', [PermissionController::class, 'delete'])->name('permission.delete');
    });

    Route::group(['prefix' => 'companies'], function () {
        Route::get('list', [CompanyController::class, 'index'])->name('company.list');
        Route::get('add', [CompanyController::class, 'add'])->name('company.add');
        Route::post('add', [CompanyController::class, 'addPost'])->name('company.add.post');
        Route::get('edit/{company}', [CompanyController::class, 'edit'])->name('company.edit');
        Route::post('edit/{company}', [CompanyController::class, 'editPost'])->name('company.edit.post');
        Route::get('delete/{company}', [CompanyController::class, 'delete'])->name('company.delete');
    });

    Route::group(['prefix' => 'amenities'], function () {
        Route::get('list', [AmenityController::class, 'index'])->name('amenity.list');
        Route::get('add', [AmenityController::class, 'add'])->name('amenity.add');
        Route::post('add', [AmenityController::class, 'addPost'])->name('amenity.add.post');
        Route::get('edit/{amenity}', [AmenityController::class, 'edit'])->name('amenity.edit');
        Route::post('edit/{amenity}', [AmenityController::class, 'editPost'])->name('amenity.edit.post');
        Route::get('delete/{amenity}', [AmenityController::class, 'delete'])->name('amenity.delete');
    });

    Route::group(['prefix' => 'articles'], function () {
        Route::get('list', [ArticleController::class, 'index'])->name('article.list');
        Route::get('add', [ArticleController::class, 'add'])->name('article.add');
        Route::post('add', [ArticleController::class, 'addPost'])->name('article.add.post');
        Route::get('edit/{article}', [ArticleController::class, 'edit'])->name('article.edit');
        Route::post('edit/{article}', [ArticleController::class, 'editPost'])->name('article.edit.post');
        Route::get('delete/{article}', [ArticleController::class, 'delete'])->name('article.delete');
    });
});

