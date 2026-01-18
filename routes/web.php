<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// --- Public Landing Page ---
Route::get('/', function () { 
    return view('welcome'); 
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- Dashboard & Discovery ---
    Route::get('/dashboard', [TripController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/search', [TripController::class, 'searchDriver'])->name('trips.search');

    // --- Booking Process (User/Passenger Side) ---
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');

    // --- Aktivitas User (Passenger Side) ---
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');

    // RUTE BARU: Untuk proses pembatalan booking
    Route::patch('/activities/{booking}/cancel', [ActivityController::class, 'cancel'])->name('bookings.cancel');

    // --- FITUR CHAT ---
    // Route Khusus Nav Bar (Redirect ke chat aktif)
    Route::get('/chat', [BookingController::class, 'chat'])->name('bookings.chat.blank'); 
    // Route Chat dengan ID
    Route::get('/bookings/{id}/chat', [BookingController::class, 'chat'])->name('bookings.chat');
    Route::post('/bookings/{id}/send-message', [BookingController::class, 'sendMessage'])->name('bookings.sendMessage');

    // --- Riwayat & Aktivitas ---
    //Route::get('/activities', [BookingController::class, 'index'])->name('bookings.index');

    // --- Trip Management (Driver Side) ---
    Route::get('/my-trips', [TripController::class, 'myTrips'])->name('trips.my-trips');
    Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
    Route::post('/bookings/{id}/accept', [TripController::class, 'acceptBooking'])->name('bookings.accept');
    Route::post('/bookings/{id}/reject', [TripController::class, 'rejectBooking'])->name('bookings.reject');
    Route::post('/bookings/{id}/complete', [TripController::class, 'completeBooking'])->name('bookings.complete');

    // --- Profile Management ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';