<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // MENAMPILKAN RIWAYAT
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    // INI YANG TADI ILANG DI SCREENSHOT LU (image_50bd11.png)
    public function create()
    {
        return view('bookings.create'); 
    }

    // PROSES SIMPAN & POTONG SALDO
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pickup_name'    => 'required|string',
            'dest_name'      => 'required|string',
            'vehicle_type'   => 'required|string',
            'payment_method' => 'required|string',
            'total_price'    => 'required|numeric',
            'distance'       => 'required|numeric',
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                // Pakai find biar fungsi decrement-nya kebaca editor
                $user = User::find(Auth::id()); 
                $totalPrice = (float) $validated['total_price'];

                if ($validated['payment_method'] === 'nebengpay') {
                    if ($user->balance < $totalPrice) {
                        throw new \Exception("Saldo tidak cukup!");
                    }
                    // POTONG SALDO
                    $user->decrement('balance', $totalPrice);
                }

                $booking = Booking::create([
                    'user_id'           => $user->id,
                    'pickup_point'      => $validated['pickup_name'],
                    'destination_point' => $validated['dest_name'],
                    'distance'          => $validated['distance'],
                    'total_price'       => $totalPrice,
                    'payment_method'    => $validated['payment_method'],
                    'status'            => 'searching', 
                ]);

                return response()->json(['success' => true, 'booking_id' => $booking->id]);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    // UNTUK HALAMAN CHAT & DETAIL (image_50b18f.png)
    public function show($id)
    {
        // Ambil data booking berdasarkan ID
        $booking = Booking::with('messages')->findOrFail($id);
        
        // LOGIKA DINAMIS: Cek tipe kendaraan yang dipilih user saat booking
        if ($booking->vehicle_type === 'motor') {
            $driverData = [
                'name'          => 'Agus Racing',
                'plate'         => 'BK 9999 ZZ',
                'rating'        => '4.8',
                'photo'         => 'https://ui-avatars.com/api/?background=00b894&color=fff&name=Agus',
                'vehicle_name'  => 'Honda Vario 160',
                'vehicle_color' => 'Merah Doff',
                'total_trip'    => '850',
                'icon'          => 'fa-motorcycle' // Icon untuk UI
            ];
        } else {
            // Default ke Mobil kalau bukan motor
            $driverData = [
                'name'          => 'Budi Santoso',
                'plate'         => 'BK 1234 ABC',
                'rating'        => '4.9',
                'photo'         => 'https://ui-avatars.com/api/?background=00b894&color=fff&name=Budi',
                'vehicle_name'  => 'Toyota Avanza',
                'vehicle_color' => 'Hitam Metalik',
                'total_trip'    => '1,240',
                'icon'          => 'fa-car' // Icon untuk UI
            ];
        }

        return view('bookings.show', compact('booking', 'driverData'));
    }

    // KIRIM CHAT
    public function sendMessage(Request $request, $id)
    {
        $request->validate(['message' => 'required|string']);

        try {
            $chat = Message::create([
                'booking_id' => $id,
                'sender_id'  => Auth::id(),
                'message'    => $request->message
            ]);

            // Kirim response JSON untuk AJAX
            return response()->json([
                'success' => true,
                'message' => $chat->message,
                'time'    => $chat->created_at->format('H:i')
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}