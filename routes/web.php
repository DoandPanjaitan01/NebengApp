<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

Route::middleware(['auth', 'verified'])->group(function () {
    // --- Dashboard & Discovery ---
    Route::get('/dashboard', [TripController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/search', [TripController::class, 'searchDriver'])->name('trips.search');

    // --- Booking Process (User/Passenger Side) ---
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');

    // JANGAN PAKE CLOSURE (function($id)) DI ROUTE KALAU MAU RAPI, LEMPAR KE CONTROLLER!
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/send-message', [BookingController::class, 'sendMessage'])->name('bookings.sendMessage');
    
    // // INI HALAMAN STATUS UTAMA: Mengarah ke View yang berisi Livewire
    // Route::get('/bookings/{id}', function($id) {
    //     $booking = \App\Models\Booking::findOrFail($id);
    //     return view('bookings.show', compact('booking'));
    // })->name('bookings.show');

    // PASTIKAN CUMA PAKAI YANG INI (Baris 20-21 di image_5113fe.png)
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/send-message', [BookingController::class, 'sendMessage'])->name('bookings.sendMessage');

    Route::post('/bookings/{id}/chat', [BookingController::class, 'sendMessage'])->name('bookings.chat');

    // Riwayat & Aktivitas
    Route::get('/activities', [BookingController::class, 'index'])->name('bookings.index');

    // --- Trip Management (Driver Side) ---
    Route::get('/my-trips', [TripController::class, 'myTrips'])->name('trips.my-trips');
    Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
    
    // Driver Actions pada Booking
    Route::post('/bookings/{id}/accept', [TripController::class, 'acceptBooking'])->name('bookings.accept');
    Route::post('/bookings/{id}/reject', [TripController::class, 'rejectBooking'])->name('bookings.reject');
    Route::post('/bookings/{id}/complete', [TripController::class, 'completeBooking'])->name('bookings.complete');

    // --- Profile Management ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';