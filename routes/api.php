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
    //City State list
    Route::get('state-city-list', 'UserController@stateCityList');
    //Sent OTP
    Route::post('send-otp', 'AuthController@signup');
    //Verify OTP
    Route::post('verify-otp', 'AuthController@login');
    //Home
    Route::get('home', 'HomeController@home');
    // Housekeeping & Service listing
    Route::get('services-list', 'ServiceController@serviceListing');
    //Raised service order & request listing
    Route::get('order-request-list', 'ServiceController@userServiceRequest');

    //service order & request listing of specific resort (Staff)
    Route::get('service-request-list', 'StaffController@serviceRequestListing');

    //Amenities listing of specific resort
    Route::get('amenities-list', 'AmenityController@amenitiesListing');

    //Amenities slots
    Route::get('amenities-time-slots', 'AmenityController@amenityTimeSlots');

    //Amenities listing of specific resort
    Route::get('activities-list', 'ActivityController@activitiesListing');

    //Amenities slots
    Route::get('activity-time-slots', 'ActivityController@activityTimeSlots');

    //Notification List
    Route::get('notification-list', 'NotificationController@notificationList');

    //Resort listing
    Route::get('resort-listing', 'ResortController@resortListing');
    //Resort detail
    Route::get('resort-detail', 'ResortController@resortDetail');
    
    //Offer listing detail
    Route::get('offer-listing', 'OfferController@offerListing');
    
    //Healthcare Program listing
    Route::get('health-program-listing', 'HealthcareProgramController@healthcareListing');
    
    //Meal listing
    Route::get('meal-listing', 'MealController@mealListing');
    
    Route::get('terms-conditions', 'CmsController@termContidion');
    
    Route::get('about-us', 'CmsController@aboutUs');
    
    Route::get('contact-us', 'CmsController@contactUsDetail');
    
    Route::post('submit-contact-us', 'CmsController@contactUsSubmit');
    
        
    Route::post('referesh-token', 'AuthController@refereshToken');
    Route::post('forget-password', 'UserController@forgetPassword');
    
    Route::get('nearby-list-detail', 'NearbyController@nearbyListDetail');




    Route::middleware('auth:api')->group(function () {
        //Raise service request (by user)
        Route::post('raise-service-request', 'ServiceController@raiseServiceRequest');

        //Approved service request (by user)
        Route::post('approve-service-request', 'ServiceController@approveServiceRequest');

        //Accept service order & request (by staff member)
        Route::post('service-request-accept', 'StaffController@requestAccept');

        //Myjobs (staff member)
        Route::get('myjobs', 'StaffController@myJobListing');

        //Myjob mark as complete (staff member)
        Route::post('job-mark-complete', 'StaffController@markasComplete');

        //Book amenity
        Route::post('book-amenities', 'AmenityController@bookAmenities');

        //Book amenity
        Route::post('book-activities', 'ActivityController@bookAmenities');
        
        Route::post('sos', 'CmsController@sos');

        Route::post('check-in', 'UserController@checkIn');
        Route::get('logout', 'AuthController@logout');
        Route::post('update-profile', 'UserController@updateProfile');
        Route::post('change-password', 'UserController@changesPassword');
    });
});
