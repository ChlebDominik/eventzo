<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('home');
})->name('home');

Auth::routes();

Route::get('/moje-eventy', [EventController::class, 'index'])
    ->middleware('auth')
    ->name('events.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
