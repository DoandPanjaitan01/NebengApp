<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar aktivitas
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Samakan return view dengan struktur folder lo (pake . atau /)
        // Di screenshot lo foldernya 'bookings', filenya 'activities.blade.php'
        $activeBookings = Booking::with(['trip.user'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['searching', 'accepted'])
            ->latest()
            ->get();

        $historyBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->latest()
            ->limit(10)
            ->get();

        return view('bookings.activities', compact('activeBookings', 'historyBookings'));
    }

    public function create()
    {
        return view('bookings.create', ['user' => Auth::user()]);
    }

    /**
     * Proses simpan pesanan
     */
    public function store(Request $request)
    {
        // DEBUG: Aktifkan baris di bawah ini kalau lu mau cek data apa yang masuk ke server
        // dd($request->all()); 

        $validated = $request->validate([
            'distance'       => 'required|numeric',
            'pickup_name'    => 'required|string',
            'dest_name'      => 'required|string',
            'vehicle_type'   => 'required',
            'payment_method' => 'required|in:nebengpay,cash',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cari driver aktif
        $trip = Trip::where('vehicle_type', $validated['vehicle_type'])
                    ->where('status', 'active')
                    ->where('user_id', '!=', $user->id)
                    ->first();

        // KRITIK: Kalau driver gak ada, jangan cuma balik, kasih feedback yang jelas
        if (!$trip) {
            return redirect()->route('dashboard')->with('error', 'Maaf bro, driver tipe ' . $validated['vehicle_type'] . ' lagi kosong.');
        }

        $totalPrice = ceil($validated['distance'] * 3000);

        if ($validated['payment_method'] === 'nebengpay' && $user->balance < $totalPrice) {
            return back()->with('error', 'Saldo NebengPay lo kurang Rp' . number_format($totalPrice - $user->balance));
        }

        try {
            DB::transaction(function () use ($user, $trip, $validated, $totalPrice) {
                Booking::create([
                    'user_id'           => $user->id,
                    'trip_id'           => $trip->id,
                    'pickup_point'      => $validated['pickup_name'],
                    'destination_point' => $validated['dest_name'],
                    'distance'          => $validated['distance'],
                    'total_price'       => $totalPrice,
                    'payment_method'    => $validated['payment_method'],
                    'status'            => 'searching' 
                ]);

                if ($validated['payment_method'] === 'nebengpay') {
                    $user->decrement('balance', $totalPrice);
                }
            });

            // Pastikan route 'bookings.index' sudah terdaftar di web.php
            return redirect()->route('bookings.index')->with('success', 'Mencari driver...');

        } catch (\Exception $e) {
            Log::error('Booking Error: ' . $e->getMessage());
            return back()->with('error', 'Waduh, ada masalah teknis. Coba lagi ya.');
        }
    }
}