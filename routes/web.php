<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return view('welcome');
});

Route::namespace("Admin")->prefix('admin')->group(function() {
    Route::get('/', 'LoginController@showLoginForm')->name('admin.login');
    Route::get('/login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'LoginController@login')->name('admin.login');
    Route::get('/logout', 'LoginController@logout')->name('admin.logout');
    Route::post('password/email', 'ForgetController@sendResetLinkEmail')->name('admin.password.email');
//   Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');
});


Route::namespace("Admin")->prefix('admin')->middleware(['adminGuest'])->group(function() {
    /**
     * Dashboard & Profile routes
     */
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');

    /**
     * Users Management
     */
    Route::get('/users', 'UsersController@index')->name('admin.users.index');
    Route::get('/users-list', 'UsersController@usersList')->name('admin.users.list');
    Route::post('/user-status', 'UsersController@updateUserStatus')->name('admin.users.status');
    Route::match(['get', 'post'], '/user/add-user', 'UsersController@addUser')->name('admin.users.add');
    Route::get('/user/detail/{id}', 'UsersController@viewUser')->name('admin.users.detail');

    /**
     * Banner Management
     */
    Route::get('/banners', 'BannerController@index')->name('admin.banner.index');
    Route::get('/banners-list', 'BannerController@bannersList')->name('admin.banner.list');
    Route::match(['get', 'post'], '/banner-add', 'BannerController@bannerAdd')->name('admin.banner.add');
    Route::post('/banner-status', 'BannerController@updateBannerStatus')->name('admin.banner.status');

    /**
     * Service Management
     */
    Route::get('/services', 'ServiceController@index')->name('admin.service.index');
    Route::get('/services-list', 'ServiceController@servicesList')->name('admin.service.list');
    Route::match(['get', 'post'], '/service-add', 'ServiceController@serviceAdd')->name('admin.service.add');
    Route::post('/service-status', 'ServiceController@updateServiceStatus')->name('admin.service.status');
    /**
     * Resort Management
     */
    Route::prefix('resort')->group(function() {
        Route::get('/', 'ResortController@index')->name('admin.resort.index');
        Route::get('/resorts-list', 'ResortController@resortList')->name('admin.resort.list');
        Route::match(['get', 'post'], '/create', 'ResortController@create')->name('admin.resort.add');
        Route::post('/update-status', 'ResortController@updateStatus')->name('admin.resort.status-update');
        Route::post('/upload-images', 'ResortController@uploadImages')->name('admin.resort.upload-image');
        Route::post('/delete-images', 'ResortController@deleteImages')->name('admin.resort.delete-image');
        Route::get('/edit/{id}', 'ResortController@editResort')->name('admin.resort.edit');
    });
});
