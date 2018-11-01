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
    Route::post('referesh-token', 'AuthController@refereshToken');
    Route::post('forget-password', 'UserController@forgetPassword');
    Route::get('services-list', 'ServiceController@serviceListing');
    Route::get('resort-detail', 'ResortController@resortDetail');
    Route::get('nearby-list-detail', 'NearbyController@nearbyListDetail');
    Route::get('home', 'HomeController@home');
    Route::get('service-request-list', 'ServiceController@serviceRequestListing');

    Route::middleware('auth:api')->group(function () {
        Route::get('logout', 'AuthController@logout');

        Route::post('check-in', 'UserController@checkIn');
        Route::post('update-profile', 'UserController@updateProfile');
        Route::post('change-password', 'UserController@changesPassword');
        Route::post('raise-service-request', 'ServiceController@raiseServiceRequest');
        Route::post('service-request-accept', 'ServiceController@requestAccept');
        Route::get('order-request-list', 'MyjobsController@userServiceRequest');
    });
});
