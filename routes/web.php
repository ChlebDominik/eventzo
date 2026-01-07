<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketPurchaseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CheckinController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Events - public list
Route::get('/events', [EventController::class, 'index'])->name('events.index');

Route::middleware('auth')->group(function () {

    // Organizer-only CRUD (DÔLEŽITÉ: create/edit sú pred /events/{event})
    Route::middleware('organizer')->group(function () {
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');

        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

        // Check-in
        Route::get('/events/{event}/checkin', [CheckinController::class, 'index'])->name('checkin.index');
        Route::post('/events/{event}/checkin', [CheckinController::class, 'check'])->name('checkin.check');
    });

    // Ticket purchase
    Route::post('/events/{event}/buy', [TicketPurchaseController::class, 'buy'])->name('tickets.buy');

    // Orders + Tickets (owner)
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
});

// Event detail - MUSÍ BYŤ AŽ NA KONCI (wildcard)
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Signed QR URL (public)
Route::get('/t/{ticket}', [TicketController::class, 'signed'])
    ->middleware('signed')
    ->name('tickets.signed');
