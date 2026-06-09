<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/create', function () {
    return view('create-event');
});

Route::post('/events', [EventController::class, 'store'])->name('events.store');

Route::get('/e/{code}', [EventController::class, 'guestPage'])->name('events.guest');

Route::get('/e/{code}/album', [EventController::class, 'albumPage'])->name('events.album');

Route::post('/e/{code}/photos', [EventController::class, 'uploadPhoto'])->name('events.photos.upload');


