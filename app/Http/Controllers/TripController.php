<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    /**
     * Menampilkan Dashboard berdasarkan Tipe Kendaraan.
     */
    public function index(Request $request)
    {
        // Ambil tipe dari request (motor/mobil_l/mobil_xl), default: motor
        $type = $request->query('type', 'motor');

        // Logic: Cari driver online yang sesuai tipe kendaraan
        // Gue pakai nama variabel $drivers agar sinkron dengan loop di view lo
        $drivers = Trip::with('driver')
            ->where('status', 'open')
            ->where('vehicle_type', $type) 
            ->where('empty_seats', '>', 0)
            ->where('user_id', '!=', Auth::id()) 
            ->latest()
            ->get();

        // Pastikan compact melempar variabel 'drivers'
        return view('dashboard', compact('drivers', 'type'));
    }

    /**
     * Logic Booking: Cek Saldo & Kurangi Kursi secara atomik.
     */
    public function book(Request $request)
    {
        $request->validate([
            'trip_id'           => 'required|exists:trips,id',
            'pickup_point'      => 'required|string|max:255',
            'destination_point' => 'required|string|max:255',
            'distance'          => 'required|numeric|min:0.1',
        ]);

        $trip = Trip::findOrFail($request->trip_id);
        $user = Auth::user();
        
        // Hitung total harga berdasarkan tarif per KM driver
        $totalPrice = $request->distance * $trip->price;

        // Proteksi Saldo: Jangan sampai minus
        if ($user->balance < $totalPrice) {
            return back()->with('error', 'Saldo NebengPay lo gak cukup! Sisa saldo: Rp ' . number_format($user->balance));
        }

        // DB Transaction: Memastikan data sinkron (Saldo dipotong DAN kursi dikurangi)
        try {
            DB::transaction(function () use ($request, $trip, $user, $totalPrice) {
                
                // 1. Kurangi sisa kursi
                $trip->decrement('empty_seats');
                
                // Update status otomatis jika kursi sudah 0
                if ($trip->empty_seats <= 0) {
                    $trip->update(['status' => 'full']);
                }

                // 2. Simpan Data Booking
                Booking::create([
                    'user_id'           => $user->id,
                    'trip_id'           => $trip->id,
                    'pickup_point'      => $request->pickup_point,
                    'destination_point' => $request->destination_point,
                    'distance'          => $request->distance,
                    'total_price'       => $totalPrice,
                    'payment_method'    => 'NebengPay',
                    'status'            => 'pending'
                ]);

                // 3. Potong Saldo User secara otomatis
                /** @var \App\Models\User $user */
                $user->decrement('balance', $totalPrice);
            });

            return redirect()->route('activities.index')->with('success', 'Pesanan sukses! Driver akan segera menjemput.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Tampilan Riwayat Aktivitas.
     */
    public function activities()
    {
        $bookings = Booking::with(['trip.driver'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
            
        return view('activities.index', compact('bookings'));
    }

    /**
     * Logic Driver Go-Online.
     */
    public function goOnline(Request $request)
    {
        $request->validate([
            'vehicle_type' => 'required|in:motor,mobil_l,mobil_xl',
            'price'        => 'required|numeric|min:1000',
        ]);

        // Mapping Kapasitas Kursi Otomatis
        $seats = match($request->vehicle_type) {
            'mobil_l'  => 4,
            'mobil_xl' => 6,
            default    => 1,
        };

        Trip::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'vehicle_type' => $request->vehicle_type,
                'price'        => $request->price,
                'empty_seats'  => $seats,
                'status'       => 'open',
            ]
        );

        return back()->with('success', 'Status lo sekarang ONLINE.');
    }
}