<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $activeBookings = Booking::where('user_id', $userId)
            ->whereIn('status', ['searching', 'pickup', 'on_way'])
            ->with(['driver', 'trip'])
            ->latest()
            ->get();

        $historyBookings = Booking::where('user_id', $userId)
            ->whereIn('status', ['completed', 'cancelled'])
            ->latest()
            ->get();

        return view('bookings.activities', compact('activeBookings', 'historyBookings'));
    }

    // FUNGSI BARU: Untuk membatalkan pesanan
    public function cancel(Booking $booking)
    {
        // Keamanan: Cek apakah ini booking milik user yang login
        if ($booking->user_id !== Auth::id()) {
            return back()->with('error', 'Akses ilegal!');
        }

        // Cek apakah statusnya memang masih bisa dibatalkan (searching)
        if ($booking->status === 'searching') {
            $booking->update(['status' => 'cancelled']);
            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return back()->with('error', 'Pesanan sudah diproses driver, tidak bisa batal.');
    }
}