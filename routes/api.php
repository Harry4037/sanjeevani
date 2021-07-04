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
    if (\Request::segment(1) == "api") {
        $myfile = fopen(__DIR__ . "/../storage/input_data.txt", "a") or die("Unable to open file!");
        fwrite($myfile, "----------------------------------------------------");
        fwrite($myfile, "\n" . json_encode(date("d-m-Y H:i:s")));
        fwrite($myfile, "\n" . json_encode(\Request::segment(2)));
        fwrite($myfile, "\n" . json_encode($_REQUEST));
        fwrite($myfile, "\n");
        fwrite($myfile, "----------------------------------------------------");
        fwrite($myfile, "\n");
        fwrite($myfile, "----------------------------------------------------");
        fclose($myfile);
    }


    Route::get('duty-status', 'StaffController@dutyStatus');

    Route::get('user-counts', 'UserController@userCounts');

    Route::get('get-checkin-detail', 'UserController@getCheckInDetail');

    //City State list
    Route::get('country-list', 'LocationController@countrylist');

    Route::post('state-city-list', 'UserController@stateCityList');
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

    //My Healthcare Program Detail
    Route::get('my-health-program', 'HealthcareProgramController@myHealthcareProgram');

    //My Healthcare Program Detail
    Route::get('my-upcoming-complete-program', 'HealthcareProgramController@myUpcomingCompleteProgram');

    //Meal listing
    Route::get('meal-listing', 'MealController@mealListing');

    //Invoice listing & Detail
    Route::get('invoice-list-detail', 'OrderController@invoiceListDetail');

    Route::get('terms-conditions', 'CmsController@termContidion');

    Route::get('about-us', 'CmsController@aboutUs');

    Route::get('contact-us', 'CmsController@contactUsDetail');

    Route::post('submit-contact-us', 'CmsController@contactUsSubmit');


    Route::post('referesh-token', 'AuthController@refereshToken');
    Route::post('forget-password', 'UserController@forgetPassword');

    Route::get('nearby-list-detail', 'NearbyController@nearbyListDetail');

    Route::post('send-message', 'ChatController@sendMessage');
    Route::get('message-list', 'ChatController@messageList');
    Route::get('chat-user-list', 'ChatController@chatUserList');

    Route::get('room-type-list', 'StaffController@resortList');

    Route::get('search-user', 'StaffController@searchUser');

    Route::get('get-bookings', 'StaffController@getUserBookings');

    Route::middleware('auth:api')->group(function () {
        Route::post('add-user', 'StaffController@addUser');
        Route::post('create-booking', 'StaffController@createBooking');

        //Healthcare package booking
        Route::post('healthcare-booking', 'HealthcareProgramController@booking');

        //Update push status (by staff)
        Route::post('update-push-status', 'StaffController@updateNotificaionStatus');

        Route::get('amenities-bookings-details', 'StaffController@amenitiesBooking');

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

        //Myjob mark as complete (staff member)
        Route::post('job-mark-notresolve', 'StaffController@markasNotResolve');

        //Book amenity
        Route::post('book-amenities', 'AmenityController@bookAmenities');

        //Book amenity
        Route::post('book-activities', 'ActivityController@bookAmenities');

        //Add Item cart
        Route::post('add-item-cart', 'CartController@addCartItem');

        //My Cart
        Route::get('my-cart', 'CartController@myCart');

        //My Cart
        Route::post('create-order', 'OrderController@submitOrder');

        Route::post('sos', 'CmsController@sos');

        //Update device token
        Route::post('update-device-token', 'UserController@updateDeviceToken');

        //Order accepted or rejected(staff member)
        Route::post('accept-reject-meal-order', 'StaffController@acceptRejectOrder');

        //Cancel HealthcarePackage
        Route::post('cancel-package', 'HealthcareProgramController@cancelHealthcareProgram');

        //service order & request listing of specific resort (Staff)
        Route::get('service-request-list', 'StaffController@serviceRequestListing');

        Route::post('check-in', 'UserController@checkIn');

        Route::get('logout', 'AuthController@logout');

        Route::post('update-profile', 'UserController@updateProfile');

        Route::post('change-password', 'UserController@changesPassword');

        //Reject service order & request (by user)
        Route::post('reject-service-request', 'ServiceController@rejectServiceRequest');
    });
});
