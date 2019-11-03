<?php

Route::view('/', 'home');

Route::get('fb/login', 'FacebookConnectController@login')->name('fb.login');
Route::get('fb/callback', 'FacebookConnectController@callback')->name('fb.callback');

if (App::environment('local')) {
    Route::get('/debug', function () {
        return \App\Event::get(['id_facebook'])->pluck('id_facebook');
    });
}
