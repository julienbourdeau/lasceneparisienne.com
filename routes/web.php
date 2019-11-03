<?php

Route::view('/', 'home');

// TODO: Add auth!!
Route::get('fb/login', 'FacebookConnectController@login')->name('fb.login');
Route::get('fb/callback', 'FacebookConnectController@callback')->name('fb.callback');

Route::get('/events', 'EventListController@index')->name('events');
Route::get('/event/{slug}', 'EventController@show')->name('event');

if (App::environment('local')) {
    Route::get('/debug', function () {
        return \App\Event::get(['id_facebook'])->pluck('id_facebook');
    });
}
