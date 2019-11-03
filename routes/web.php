<?php

Route::get('/', 'HomeController')->name('home');

Route::get('/events', 'EventListController@index')->name('events');
Route::get('/event/{slug}', 'EventController@show')->name('event');

Route::get('/venues', 'VenueListController@index')->name('venues');
Route::get('/venue/{slug}', 'VenueController@show')->name('venue');


Route::middleware([\App\Http\Middleware\AuthorizeFacebookConnect::class])->group(function () {
    Route::get('fb/login', 'FacebookConnectController@login')->name('fb.login');
    Route::get('fb/callback', 'FacebookConnectController@callback')->name('fb.callback');
});
