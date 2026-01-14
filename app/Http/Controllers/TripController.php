<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [
            'balance' => number_format($user->balance, 0, ',', '.'),
            'status_member' => 'ELITE MEMBER', 
            'location' => 'Medan, Indonesia'
        ];

        // Daftar driver untuk ditampilkan di awal dashboard
        $nearbyRides = [
            ['driver' => 'Mas Driver', 'rate' => '5.000', 'type' => 'motor', 'status' => 'VERIFIED'],
            ['driver' => 'Mbak Driver', 'rate' => '7.500', 'type' => 'mobil', 'status' => 'VERIFIED'],
            ['driver' => 'Bang Jago', 'rate' => '4.000', 'type' => 'motor', 'status' => 'VERIFIED'],
            ['driver' => 'Sopir Kece', 'rate' => '8.000', 'type' => 'mobil', 'status' => 'VERIFIED'],
        ];

        return view('dashboard', compact('user', 'stats', 'nearbyRides'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup_name' => 'required',
            'dest_name' => 'required',
            'distance' => 'required|numeric',
            'vehicle_type' => 'required',
            'payment_method' => 'required'
        ]);

        // Logic simpan dan cari driver
        Booking::create([
            'user_id' => Auth::id(),
            'pickup_point' => $request->pickup_name,
            'destination_point' => $request->dest_name,
            'distance' => $request->distance,
            'vehicle_type' => $request->vehicle_type,
            'payment_method' => $request->payment_method,
            'status' => 'searching',
            'total_price' => $request->distance * ($request->vehicle_type == 'motor' ? 3000 : 6000)
        ]);

        return redirect()->back()->with('success', 'Sedang mencari driver terdekat...');
    }
}