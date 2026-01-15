<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;

class BookingStatus extends Component
{
    public $bookingId;

    public function mount($bookingId)
    {
        $this->bookingId = $bookingId;
    }

    /**
     * Fungsi ini bakal dijalanin tiap polling (wire:poll)
     * Kita tambahin simulasi biar driver ketemu otomatis setelah 5 detik
     */
    public function checkDummyMatch($status)
    {
        if ($status === 'searching') {
            $booking = Booking::find($this->bookingId);
            
            // Simulasi: Jika sudah lewat 5 detik sejak booking dibuat, otomatis "Accepted"
            if ($booking && $booking->created_at->diffInSeconds(now()) > 5) {
                $booking->update(['status' => 'accepted']);
                // Di sini nanti lo bisa kaitkan ke Trip ID dummy kalau perlu
            }
        }
    }

    public function render()
    {
        $booking = Booking::with(['trip.user'])
            ->where('id', $this->bookingId)
            ->first();

        if ($booking) {
            $this->checkDummyMatch($booking->status);
        }

        // PERBAIKAN: Gue arahin ke folder livewire, bukan components
        return view('livewire.booking-status', [
            'booking' => $booking
        ]);
    }
}