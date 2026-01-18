<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;

class BookingStatus extends Component
{
    public $bookingId;
    // Tambahin property buat nampung data driver dummy
    public $driverData = null;

    public function mount($bookingId)
    {
        $this->bookingId = $bookingId;
        
        // Siapin data dummy biar siap dipake pas status berubah
        $this->driverData = [
            'name' => 'Budi Sudarsono',
            'rating' => '4.9',
            'vehicle' => 'Honda Vario 160',
            'plate' => 'BK 5582 ALM',
            'phone' => '08123456789',
            'avatar' => 'https://ui-avatars.com/api/?name=Budi+Sudarsono&background=10b981&color=fff'
        ];
    }

    /**
     * Logic simulasi pencarian
     */
    public function checkDummyMatch($booking)
    {
        if ($booking->status === 'searching') {
            // Simulasi: Jika sudah lewat 5 detik, otomatis "accepted"
            if ($booking->created_at->diffInSeconds(now()) > 5) {
                $booking->update(['status' => 'accepted']);
                
                // Emit event atau log bisa di sini jika perlu
                $this->dispatch('driver-found'); 
            }
        }
    }

    public function render()
    {
        // Eager load trip dan user (antisipasi kalau nanti udah ada sistem driver beneran)
        $booking = Booking::with(['trip.user'])
            ->where('id', $this->bookingId)
            ->first();

        if ($booking) {
            $this->checkDummyMatch($booking);
        }

        return view('livewire.booking-status', [
            'booking' => $booking
        ]);
    }
}