<?php

Route::get('/', 'HomeController')->name('home');

Route::feeds();
Route::get('cal.ics', 'IcalController@feed')->name('ics');
Route::get('/{uuid}.ics', 'IcalController@event')->name('event.ics');
Route::view('/public-api', 'api')->name('page.api');

Route::get('/concerts', 'EventListController@index')->name('events');
Route::get('/concert/{slug}', 'EventController@show')->name('event');
Route::get('/archives/{period?}', 'ArchiveController@index')->name('archives');

Route::get('/salles-concerts', 'VenueListController@index')->name('venues');
Route::get('/salle-concert/{slug}', 'VenueController@show')->name('venue');


Route::middleware([\App\Http\Middleware\AuthorizeFacebookConnect::class])->group(function () {
    Route::get('fb/login', 'FacebookConnectController@login')->name('fb.login');
    Route::get('fb/callback', 'FacebookConnectController@callback')->name('fb.callback');
});


// Redirection retrocompat'
Route::permanentRedirect('/events', '/concerts');
Route::permanentRedirect('/event/{slug}', '/concert/{slug}');
Route::permanentRedirect('/venues', '/salles-concert');
Route::permanentRedirect('/venue/{slug}', '/salle-concert/{slug}');
