<?php

// @TODO ADD RATES ON THE LEFT SIDEBAR AND DRAW THE MAP
Route::get('/', 'ApplicationController@index');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

/**
 * WEB-UI ROUTES
 */
Route::get('/hotel', 'HotelController@all');
Route::get('/hotel/{name}', 'HotelController@show');
Route::resource('/order', 'OrderController');
Route::post('/order-complete', 'OrderController@validatePayment');

/**
 * DASHBOARD ROUTES
 */
Route::group(['prefix' => 'dashboard', 'middleware' => 'admin'], function () {
    Route::get('/', 'ApplicationController@dashboard')->name('dashboard');
    Route::resource('/hotel', 'HotelController', ['except' => 'show']);
    Route::resource('/room', 'HotelRoomController', ['except' => 'show']);
    Route::resource('/rate', 'RateController');
    Route::resource('/zone', 'ZoneController');
    Route::resource('/settings', 'SettingsController');
    Route::post('/zone/add-seats/{id}', 'ZoneController@addSeats');
    Route::post('/zone/generate-seats/{id}', 'ZoneController@generateSeats');
    Route::get('/event', 'EventController@index');
});

/**
 * API ROUTES
 */
Route::get('/zone/data/{id}', 'ZoneController@getData');
Route::get('/get-seats/{id}', 'SeatController@getSeats');
Route::post('/add-hotel/{id}', 'HotelController@addHotel');