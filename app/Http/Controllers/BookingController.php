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
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
                            ->with(['trip.user'])
                            ->latest()
                            ->get();

        return view('bookings.activities', compact('bookings'));
    }

    public function create()
    {
        return view('bookings.create'); 
    }

    // --- PROSES SIMPAN & POTONG SALDO (DIJAGA TETAP ASLI) ---
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
                $user = User::find(Auth::id()); 
                $totalPrice = (float) $validated['total_price'];

                if ($validated['payment_method'] === 'nebengpay') {
                    if ($user->balance < $totalPrice) {
                        throw new \Exception("Saldo tidak cukup!");
                    }
                    $user->decrement('balance', $totalPrice);
                }

                $booking = Booking::create([
                    'user_id'           => $user->id,
                    'pickup_point'      => $validated['pickup_name'],
                    'destination_point' => $validated['dest_name'],
                    'distance'          => $validated['distance'],
                    'total_price'       => $totalPrice,
                    'payment_method'    => $validated['payment_method'],
                    'vehicle_type'      => $validated['vehicle_type'],
                    'status'            => 'searching', 
                ]);

                return response()->json(['success' => true, 'booking_id' => $booking->id]);
            });
        } catch (\Exception $e) {
            Log::error("Booking Store Error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
        $booking = Booking::with(['messages', 'trip.user'])->where('user_id', Auth::id())->findOrFail($id);
        $driverData = $this->getDriverData($booking->vehicle_type);
        return view('bookings.show', compact('booking', 'driverData'));
    }

    // --- MODIFIKASI CHAT: Mendukung klik dari Navbar (Tanpa ID) ---
    public function chat($id = null)
    {
        // Jika diklik dari Navbar (ID Kosong)
        if (!$id) {
            $activeBooking = Booking::where('user_id', Auth::id())
                ->whereIn('status', ['searching', 'pending', 'confirmed', 'on_process'])
                ->latest()
                ->first();

            if (!$activeBooking) {
                return redirect()->route('bookings.index')->with('error', 'Belum ada chat aktif.');
            }
            return redirect()->route('bookings.chat', ['id' => $activeBooking->id]);
        }

        $booking = Booking::with(['messages', 'trip.user'])->where('user_id', Auth::id())->findOrFail($id);
        $driverData = $this->getDriverData($booking->vehicle_type);

        return view('bookings.chat', compact('booking', 'driverData'));
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate(['message' => 'required|string']);

        try {
            $chat = Message::create([
                'booking_id' => $id,
                'sender_id'  => Auth::id(),
                'message'    => $request->message
            ]);

            return response()->json([
                'success' => true,
                'message' => $chat->message,
                'time'    => $chat->created_at->format('H:i')
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // --- HELPER TETAP UTUH ---
    private function getDriverData($vehicleType)
    {
        if ($vehicleType === 'motor') {
            return [
                'name'          => 'Agus Racing',
                'plate'         => 'BK 9999 ZZ',
                'rating'        => '4.8',
                'photo'         => 'AG',
                'photo_url'     => 'https://ui-avatars.com/api/?background=00b894&color=fff&name=Agus',
                'vehicle_name'  => 'Honda Vario 160',
                'vehicle_color' => 'Merah Doff',
                'total_trip'    => '850',
                'icon'          => 'fa-motorcycle'
            ];
        }

        return [
            'name'          => 'Budi Santoso',
            'plate'         => 'BK 1234 ABC',
            'rating'        => '4.9',
            'photo'         => 'BS',
            'photo_url'     => 'https://ui-avatars.com/api/?background=00b894&color=fff&name=Budi',
            'vehicle_name'  => 'Toyota Avanza',
            'vehicle_color' => 'Hitam Metalik',
            'total_trip'    => '1,240',
            'icon'          => 'fa-car'
        ];
    }
}