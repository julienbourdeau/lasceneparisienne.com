<?php

use App\Http\Controllers\Api\PublicController;

Route::get('/events', [PublicController::class, 'events'])->name('events');
Route::get('/event/{uuid}', [PublicController::class, 'event'])->name('event');

Route::get('/venues', [PublicController::class, 'venues'])->name('venues');
Route::get('/venue/{uuid}', [PublicController::class, 'venue'])->name('venue');
