<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::get('/', function () { return view('welcome'); });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [TripController::class, 'index'])->name('dashboard');

    // Pastiin name-nya persis 'trips.search'
    Route::post('/dashboard/search', [TripController::class, 'searchDriver'])->name('trips.search');
    // Tambahkan rute ini di dalam group middleware auth
    Route::get('/activities', [TripController::class, 'activities'])->name('activities.index');
    
    // Pastikan rute booking lo juga punya nama yang konsisten
    Route::post('/trips/{id}/book', [TripController::class, 'book'])->name('trips.book');
    
    // Trip Management
    Route::get('/my-trips', [TripController::class, 'myTrips'])->name('trips.my-trips');
    Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
    Route::post('/trips/{id}/book', [TripController::class, 'book'])->name('trips.book');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking Status Updates (Driver Actions)
    // Halaman peta pemesanan
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/bookings/{id}/accept', [TripController::class, 'acceptBooking'])->name('bookings.accept');
    Route::post('/bookings/{id}/reject', [TripController::class, 'rejectBooking'])->name('bookings.reject');
    Route::post('/bookings/{id}/complete', [TripController::class, 'completeBooking'])->name('bookings.complete');
});

require __DIR__.'/auth.php';