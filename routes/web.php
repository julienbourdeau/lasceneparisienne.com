<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventListController;
use App\Http\Controllers\FacebookConnectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IcalController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\VenueListController;

Route::get('/', HomeController::class)->name('home');

Route::feeds();
Route::get('cal.ics', [IcalController::class, 'feed'])->name('ics');
Route::get('/{uuid}.ics', [IcalController::class, 'event'])->name('event.ics');

Route::get('/public-api', ApiController::class)->name('page.api');

Route::get('/concerts', [EventListController::class, 'index'])->name('events');
Route::get('/concert/{slug}', [EventController::class, 'show'])->name('event');
Route::get('/archives/{period?}', [ArchiveController::class, 'index'])->name('archives');

Route::get('/salles-concerts', [VenueListController::class, 'index'])->name('venues');
Route::get('/salle-concert/{slug}', [VenueController::class, 'show'])->name('venue');


Route::middleware([\App\Http\Middleware\AuthorizeFacebookConnect::class])->group(function () {
    Route::get('fb/login', [FacebookConnectController::class, 'login'])->name('fb.login');
    Route::get('fb/callback', [FacebookConnectController::class, 'callback'])->name('fb.callback');
});


// Redirection retrocompat'
Route::permanentRedirect('/events', '/concerts');
Route::permanentRedirect('/event/{slug}', '/concert/{slug}');
Route::permanentRedirect('/venues', '/salles-concert');
Route::permanentRedirect('/venue/{slug}', '/salle-concert/{slug}');
