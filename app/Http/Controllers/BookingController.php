<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Menampilkan halaman peta pemesanan
     * Path: resources/views/bookings/create.blade.php
     */
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Pastikan file view sudah dipindah ke folder 'bookings'
        return view('bookings.create', compact('user'));
    }

    /**
     * Proses simpan pesanan & potong saldo (Fokus Penumpang)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'distance'       => 'required|numeric',
            'pickup_name'    => 'required|string',
            'dest_name'      => 'required|string',
            'vehicle_type'   => 'required',
            'payment_method' => 'required|in:nebengpay,cash',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cari driver aktif yang bukan user itu sendiri
        $trip = Trip::where('vehicle_type', $validated['vehicle_type'])
                    ->where('status', 'active')
                    ->where('user_id', '!=', $user->id)
                    ->first();

        if (!$trip) {
            return back()->with('error', 'Lagi nggak ada driver nih, bro!');
        }

        $totalPrice = ceil($validated['distance'] * 3000);

        // Validasi Saldo
        if ($validated['payment_method'] === 'nebengpay' && $user->balance < $totalPrice) {
            return back()->with('error', 'Saldo NebengPay lo nggak cukup!');
        }

        try {
            DB::transaction(function () use ($user, $trip, $validated, $totalPrice) {
                // 1. Buat data booking
                Booking::create([
                    'user_id'           => $user->id,
                    'trip_id'           => $trip->id,
                    'pickup_point'      => $validated['pickup_name'],
                    'destination_point' => $validated['dest_name'],
                    'distance'          => $validated['distance'],
                    'total_price'       => $totalPrice,
                    'payment_method'    => $validated['payment_method'],
                    'status'            => 'pending'
                ]);

                // 2. Potong saldo otomatis
                if ($validated['payment_method'] === 'nebengpay') {
                    $user->decrement('balance', $totalPrice);
                }
            });

            return redirect()->route('dashboard')->with('success', 'Pesanan berhasil dikirim!');

        } catch (\Exception $e) {
            return back()->with('error', 'Sistem error: ' . $e->getMessage());
        }
    }
}