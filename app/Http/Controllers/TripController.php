<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    /**
     * Menampilkan Dashboard Utama
     * Mengambil data asli dari DB untuk ditampilkan di UI.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Data statistik untuk bagian header dashboard
        $stats = [
            'balance' => number_format($user->balance, 0, ',', '.'),
            'status_member' => 'ELITE MEMBER', 
            'location' => 'Medan, Indonesia'
        ];

        // Ambil data driver asli yang sedang aktif
        $nearbyRides = Trip::where('status', 'active')
                            ->where('user_id', '!=', $user->id)
                            ->with('user')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('dashboard', compact('user', 'stats', 'nearbyRides'));
    }

    /**
     * Menampilkan form buat driver (Tombol "+")
     * SOLUSI: Menghilangkan error Call to undefined method.
     */
    public function create()
    {
        return view('trips.create');
    }

    /**
     * Simpan data tumpangan baru dari Driver
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_name' => 'required|string|max:255',
            'vehicle_type' => 'required|in:motor,mobil_l,mobil_xl',
            'price_per_km' => 'required|numeric|min:1000',
        ]);

        Trip::create([
            'user_id'      => Auth::id(),
            'vehicle_name' => $validated['vehicle_name'],
            'vehicle_type' => $validated['vehicle_type'],
            'price_per_km' => $validated['price_per_km'],
            'status'       => 'active',
        ]);

        return redirect()->route('dashboard')->with('success', 'Jasa lo sudah aktif!');
    }
}