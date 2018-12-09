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
    Route::post('password/reset', 'ResetPasswordController@resetPassword')->name('password.reset');
});


Route::namespace("Admin")->prefix('admin')->middleware(['adminGuest'])->group(function() {
    Route::get('/city-list/{id}', 'CommonController@getCityList')->name('admin.city.list');
    /**
     * Dashboard & Profile routes
     */
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');

    /**
     * Room Management
     */
    Route::prefix('room-type')->group(function() {
        Route::get('/', 'RoomtypeController@index')->name('admin.room.index');
        Route::get('/rooms-list', 'RoomtypeController@roomList')->name('admin.room.list');
        Route::match(['get', 'post'], '/create', 'RoomtypeController@create')->name('admin.room.add');
        Route::post('/update-status', 'RoomtypeController@updateStatus')->name('admin.room.status-update');
        Route::post('/upload-images', 'RoomtypeController@uploadImages')->name('admin.room.upload-image');
        Route::post('/delete-images', 'RoomtypeController@deleteImages')->name('admin.room.delete-image');
        Route::post('/delete-room-images', 'RoomtypeController@deleteRoomImage')->name('admin.room.delete-room-image');
        Route::match(['get', 'post'], '/edit/{id}', 'RoomtypeController@editRoom')->name('admin.room.edit');
        Route::post('/delete', 'RoomtypeController@deleteRoom')->name('admin.room.delete');
    });

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
        Route::post('/delete-resort-images', 'ResortController@deleteResortImage')->name('admin.resort.delete-resort-image');
        Route::match(['get', 'post'], '/edit/{id}', 'ResortController@editResort')->name('admin.resort.edit');
        Route::get('/resort-rooms/{resort}/{type}', 'ResortController@getResortRooms')->name('admin.resort.rooms');
        Route::post('/delete-room', 'ResortController@deleteRoom')->name('admin.resort.delete-room');
        Route::post('/delete', 'ResortController@deleteResort')->name('admin.resort.delete');
    });

    /**
     * Resort Nearby Management
     */
    Route::prefix('nearby')->group(function() {
        Route::get('/', 'NearbyController@index')->name('admin.nearby.index');
        Route::get('/nearby-list', 'NearbyController@nearbyList')->name('admin.nearby.list');
        Route::match(['get', 'post'], '/create', 'NearbyController@create')->name('admin.nearby.add');
        Route::post('/update-status', 'NearbyController@updateStatus')->name('admin.nearby.status-update');
        Route::post('/upload-images', 'NearbyController@uploadImages')->name('admin.nearby.upload-image');
        Route::post('/delete-images', 'NearbyController@deleteImages')->name('admin.nearby.delete-image');
        Route::match(['get', 'post'], '/edit/{id}', 'NearbyController@editNearby')->name('admin.nearby.edit');
        Route::post('/delete-nearby-images', 'NearbyController@deleteNearbyImage')->name('admin.nearby.delete-nearby-image');
        Route::post('/delete', 'NearbyController@deleteNearby')->name('admin.nearby.delete');
    });

    /**
     * Users Management
     */
    Route::get('/users', 'UsersController@index')->name('admin.users.index');
    Route::get('/users-list', 'UsersController@usersList')->name('admin.users.list');
    Route::post('/user-status', 'UsersController@updateUserStatus')->name('admin.users.status');
    Route::match(['get', 'post'], '/user/add-user', 'UsersController@addUser')->name('admin.users.add');
    Route::get('/user/detail/{id}', 'UsersController@viewUser')->name('admin.users.detail');
    Route::match(['get', 'post'], '/user/edit/{id}', 'UsersController@editUser')->name('admin.users.edit');
    /**
     * Staff Management
     */
    Route::prefix('staff')->group(function() {

        Route::get('/', 'StaffController@index')->name('admin.staff.index');
        Route::get('/staff-list', 'StaffController@usersList')->name('admin.staff.list');
        Route::post('/staff-status', 'StaffController@updateUserStatus')->name('admin.staff.status');
        Route::match(['get', 'post'], '/add-staff', 'StaffController@addUser')->name('admin.staff.add');
        Route::get('/staff-detail/{id}', 'StaffController@viewUser')->name('admin.staff.detail');
        Route::match(['get', 'post'], '/edit/{id}', 'StaffController@editUser')->name('admin.staff.edit');
    });
    /**
     * Banner Management
     */
    Route::get('/banners', 'BannerController@index')->name('admin.banner.index');
    Route::get('/banners-list', 'BannerController@bannersList')->name('admin.banner.list');
    Route::match(['get', 'post'], '/banner-add', 'BannerController@bannerAdd')->name('admin.banner.add');
    Route::post('/banner-status', 'BannerController@updateBannerStatus')->name('admin.banner.status');
    Route::match(['get', 'post'], '/baner-edit/{id}', 'BannerController@editBanner')->name('admin.banner.edit');
    Route::post('banner/delete', 'BannerController@deleteBanner')->name('admin.banner.delete');

    /**
     * Service Management
     */
    Route::get('/services', 'ServiceController@index')->name('admin.service.index');
    Route::get('/services-list', 'ServiceController@servicesList')->name('admin.service.list');
    Route::match(['get', 'post'], '/service-add', 'ServiceController@serviceAdd')->name('admin.service.add');
    Route::post('/service-status', 'ServiceController@updateServiceStatus')->name('admin.service.status');
    Route::match(['get', 'post'], '/service/edit/{id}', 'ServiceController@edit')->name('admin.service.edit');
    Route::post('services/delete', 'ServiceController@deleteService')->name('admin.service.delete');

    /**
     * Jobs Management
     */
    Route::prefix('order-request')->group(function() {
        Route::get('/', 'OrderRequestController@index')->name('admin.order-request.index');
        Route::get('/order-request-list', 'OrderRequestController@orderRequestList')->name('admin.order-request.list');
    });

    /**
     * Amenity Management
     */
    Route::prefix('amenity')->group(function() {
        Route::get('/', 'AmenityController@index')->name('admin.amenity.index');
        Route::get('/amenities-list', 'AmenityController@amenityList')->name('admin.amenity.list');
        Route::match(['get', 'post'], '/create', 'AmenityController@create')->name('admin.amenity.add');
        Route::post('/update-status', 'AmenityController@updateStatus')->name('admin.amenity.status-update');
        Route::post('/upload-images', 'AmenityController@uploadImages')->name('admin.amenity.upload-image');
        Route::post('/delete-images', 'AmenityController@deleteImages')->name('admin.amenity.delete-image');
        Route::match(['get', 'post'], '/edit/{id}', 'AmenityController@editAmenity')->name('admin.amenity.edit');
        Route::post('/delete-amenity-images', 'AmenityController@deleteAmenityImage')->name('admin.amenity.delete-amenity-image');
        Route::post('/delete-time-slot', 'AmenityController@deleteTimeSlot')->name('admin.amenity.delete-timeslot');
        Route::post('/delete', 'AmenityController@deleteAmenity')->name('admin.amenity.delete');
    });
    /**
     * Activity Management
     */
    Route::prefix('activity')->group(function() {
        Route::get('/', 'ActivityController@index')->name('admin.activity.index');
        Route::get('/activities-list', 'ActivityController@activityList')->name('admin.activity.list');
        Route::match(['get', 'post'], '/create', 'ActivityController@create')->name('admin.activity.add');
        Route::post('/update-status', 'ActivityController@updateStatus')->name('admin.activity.status-update');
        Route::post('/upload-images', 'ActivityController@uploadImages')->name('admin.activity.upload-image');
        Route::post('/delete-images', 'ActivityController@deleteImages')->name('admin.activity.delete-image');
        Route::match(['get', 'post'], '/edit/{id}', 'ActivityController@editActivity')->name('admin.activity.edit');
        Route::post('/delete-activity-images', 'ActivityController@deleteActivityImage')->name('admin.activity.delete-activity-image');
        Route::post('/delete-time-slot', 'ActivityController@deleteTimeSlot')->name('admin.activity.delete-timeslot');
        Route::post('/delete', 'ActivityController@deleteActivity')->name('admin.activity.delete');
    });
    /**
     * Offer Management
     */
    Route::prefix('offer')->group(function() {
        Route::get('/', 'OfferController@index')->name('admin.offer.index');
        Route::get('/offer-list', 'OfferController@offerList')->name('admin.offer.list');
        Route::match(['get', 'post'], '/create', 'OfferController@create')->name('admin.offer.add');
        Route::post('/update-status', 'OfferController@updateStatus')->name('admin.offer.status-update');
        Route::post('/upload-images', 'OfferController@uploadImages')->name('admin.offer.upload-image');
        Route::post('/delete-images', 'OfferController@deleteImages')->name('admin.offer.delete-image');
        Route::match(['get', 'post'], '/edit/{id}', 'OfferController@editOffer')->name('admin.offer.edit');
        Route::post('/delete-offer-images', 'OfferController@deleteOfferImage')->name('admin.offer.delete-offer-image');
        Route::post('/delete', 'OfferController@deleteOffer')->name('admin.offer.delete');
    });

    /**
     * Healthcare Program Management
     */
    Route::prefix('healthcare')->group(function() {
        Route::get('/', 'HealthcareProgramController@index')->name('admin.healthcare.index');
        Route::get('/healthcare-list', 'HealthcareProgramController@healthcareList')->name('admin.healthcare.list');
        Route::match(['get', 'post'], '/create', 'HealthcareProgramController@create')->name('admin.healthcare.add');
        Route::post('/update-status', 'HealthcareProgramController@updateStatus')->name('admin.healthcare.status-update');
        Route::post('/upload-images', 'HealthcareProgramController@uploadImages')->name('admin.healthcare.upload-image');
        Route::post('/delete-images', 'HealthcareProgramController@deleteImages')->name('admin.healthcare.delete-image');
        Route::match(['get', 'post'], '/edit/{id}', 'HealthcareProgramController@editHealthcare')->name('admin.healthcare.edit');
        Route::post('/delete-healthcare-images', 'HealthcareProgramController@deleteHealthcareImage')->name('admin.healthcare.delete-activity-image');
        Route::post('/delete', 'HealthcareProgramController@deletehealthcare')->name('admin.healthcare.delete');
    });

    /**
     * CMS Management
     */
    Route::prefix('cms')->group(function() {
        Route::get('/', 'CmsController@index')->name('admin.cms.index');
        Route::get('/cms-list', 'CmsController@cmsList')->name('admin.cms.list');
        Route::match(['get', 'post'], '/edit/{id}', 'CmsController@editCms')->name('admin.cms.edit');
    });

    /**
     * CMS Management
     */
    Route::prefix('sos')->group(function() {
        Route::get('/', 'SOSController@index')->name('admin.sos.index');
        Route::get('/sos-list', 'SOSController@sosList')->name('admin.sos.list');
        Route::match(['get', 'post'], '/view/{id}', 'SOSController@viewSOS')->name('admin.sos.view');
    });

    /**
     * Meal Category Management
     */
    Route::prefix('meal-category')->group(function() {
        Route::get('/', 'MealcategoryController@index')->name('admin.meal-category.index');
        Route::get('/list', 'MealcategoryController@categoryList')->name('admin.meal-category.list');
        Route::match(['get', 'post'], '/create', 'MealcategoryController@create')->name('admin.meal-category.add');
        Route::post('/update-status', 'MealcategoryController@updateStatus')->name('admin.meal-category.status-update');
        Route::match(['get', 'post'], '/edit/{id}', 'MealcategoryController@editMealcategory')->name('admin.meal-category.edit');
        Route::post('/delete', 'MealcategoryController@deleteMealcategory')->name('admin.meal-category.delete');
    });

    /**
     * Meal Management
     */
    Route::prefix('meal')->group(function() {
        Route::get('/', 'MealController@index')->name('admin.meal.index');
        Route::get('/list', 'MealController@mealList')->name('admin.meal.list');
        Route::match(['get', 'post'], '/create', 'MealController@create')->name('admin.meal.add');
        Route::post('/update-status', 'MealController@updateStatus')->name('admin.meal.status-update');
        Route::match(['get', 'post'], '/edit/{id}', 'MealController@editMeal')->name('admin.meal.edit');
        Route::post('/delete', 'MealController@deleteMeal')->name('admin.meal.delete');
    });
    /**
     * Meal Package Management
     */
    Route::prefix('meal-package')->group(function() {
        Route::get('/', 'MealpackageController@index')->name('admin.meal-package.index');
        Route::get('/list', 'MealpackageController@mealpackageList')->name('admin.meal-package.list');
        Route::match(['get', 'post'], '/create', 'MealpackageController@create')->name('admin.meal-package.add');
        Route::post('/update-status', 'MealpackageController@updateStatus')->name('admin.meal-package.status-update');
        Route::match(['get', 'post'], '/edit/{id}', 'MealpackageController@editMealpackage')->name('admin.meal-package.edit');
        Route::post('/delete', 'MealpackageController@deleteMealpackage')->name('admin.meal-package.delete');
        Route::post('/meal-items', 'MealpackageController@getResortMeal')->name('admin.meal-package.resort-item');
    });

    /**
     * Order Management
     */
    Route::prefix('order')->group(function() {
        Route::get('/', 'OrderController@index')->name('admin.order.index');
        Route::get('/list', 'OrderController@OrderList')->name('admin.order.list');
//        Route::match(['get', 'post'], '/create', 'MealpackageController@create')->name('admin.meal-package.add');
//        Route::post('/update-status', 'MealpackageController@updateStatus')->name('admin.meal-package.status-update');
//        Route::match(['get', 'post'], '/edit/{id}', 'MealpackageController@editMealpackage')->name('admin.meal-package.edit');
//        Route::post('/delete', 'MealpackageController@deleteMealpackage')->name('admin.meal-package.delete');
//        Route::post('/meal-items', 'MealpackageController@getResortMeal')->name('admin.meal-package.resort-item');
    });
    /**
     * Notification Management
     */
    Route::prefix('notification')->group(function() {
        Route::get('/', 'NotificationController@index')->name('admin.notification.index');
    });
});
