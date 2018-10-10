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
//    Route::post('password/email', 'ForgetController@sendResetLinkEmail')->name('admin.password.email');
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
    Route::get('/users-list','UsersController@usersList')->name('admin.users.list');
});
