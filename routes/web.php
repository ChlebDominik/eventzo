<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;

/*
| Web routes
*/

Route::get('/', function () {
    return view('home');
})->name('home');

// Events (public index + show)
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Protected event routes (create/edit/delete) - MUST be before {event} routes
Route::middleware('auth')->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/dashboard', function () {
        return redirect()->route('events.index');
    })->name('dashboard');
});

// Must be last to avoid matching /events/create and /events/{event}/edit
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Auth (custom, no packages)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
