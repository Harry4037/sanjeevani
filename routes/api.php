<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::namespace("Api")->group(function () {
    Route::post('send-otp', 'AuthController@signup');
    Route::post('verify-otp', 'AuthController@login');
    Route::get('banners', 'UserController@banners');
    Route::middleware('auth:api')->group(function () {
        Route::get('logout', 'AuthController@logout');
        Route::post('check-in', 'UserController@checkIn');
        Route::post('update-profile', 'UserController@updateProfile');
    });
});
