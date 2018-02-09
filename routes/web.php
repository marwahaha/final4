<?php

Route::get('/', 'ApplicationController@index');

Auth::routes();


/**
 * WEB-UI ROUTES
 */
Route::get('/hotel', 'HotelController@index');
Route::get('/hotel-list', 'HotelController@all');
Route::resource('/order', 'OrderController');
Route::post('/remove-item/{id}', 'OrderController@removeItem');
Route::get('/complete-order/{reference}', 'OrderController@completeOrder');
Route::post('/order-complete', 'OrderController@validatePayment');
Route::get('/page/{slug}', 'PageController@show');
Route::get('/profile/{id}', 'UserController@show');
Route::put('/profile/{id}', 'UserController@profileUpdate');

// New Routes
Route::get('/event', 'EventController@index');
Route::get('/event/{slug}', 'EventController@show');
Route::get('/event/{id}/seat-selection', 'EventController@seatSelection');
Route::post('/set-zone', 'EventController@setZone');
/**
 * Cart Routes
 */
Route::get('/cart/{reference}', 'CartController@get');
Route::post('/cart', 'CartController@addItems');
Route::post('/calculate/{cart}', 'CartController@calculate');

/**
 * DASHBOARD ROUTES
 */
Route::group(['prefix' => 'dashboard', 'middleware' => 'admin'], function () {
    Route::get('/', 'ApplicationController@dashboard')->name('dashboard');
    Route::resource('/hotel', 'HotelController', ['except' => 'show']);
    Route::resource('/room', 'HotelRoomController', ['except' => 'show']);
    Route::resource('/rate', 'RateController');
    Route::resource('/zone', 'ZoneController');
    Route::resource('/page', 'PageController', ['except' => 'show']);
    Route::resource('/settings', 'SettingsController');
    Route::resource('/role', 'RoleController', ['except' => 'show']);
    Route::resource('/user', 'UserController', ['except' => 'show']);
    Route::resource('/sale', 'SaleController');
    Route::resource('/booking', 'BookingController');
    Route::resource('/event', 'EventController', ['except' => 'show']);
    // New API
    Route::get('/seatmap', 'SeatMapController@all');
    Route::get('/event/{id}', 'EventController@eventInfo');
    Route::get('/event/{id}/rate', 'EventController@rates');
    Route::post('/event/{id}/photo/{columnName}', 'EventController@addPhoto');
    Route::resource('/venue', 'VenueController');
    Route::resource('/seat-map','SeatMapController');
    Route::post('/confirmation-mail/{saleReference}', 'SaleController@sendConfirmationMail');
    Route::post('/zone-backup/{id}', 'ZoneController@getBackup');
    Route::post('/zone/add-seats/{id}', 'ZoneController@addSeats');
    Route::post('/zone/generate-seats/{id}', 'ZoneController@generateSeats');
    Route::post('/zone/refresh-zone/{id}', 'ZoneController@refreshZone');
    Route::get('/event', 'EventController@index');
    Route::get('/box-office', 'BoxOfficeController@index');
    Route::post('/booking/{reference}/add-hotel', 'BookingController@addHotel');
    Route::post('/booking/{reference}/convert', 'BookingController@convertBooking');
    Route::get('/analytics', 'AnalyticsController@index');
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

/**
 * API ROUTES
 */
Route::get('/zone/data/{id}', 'ZoneController@getData');
Route::post('/add-hotel/{id}', 'HotelController@addHotel');
Route::get('/get-venue', 'ApplicationController@getVenue');