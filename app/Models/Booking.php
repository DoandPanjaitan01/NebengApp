<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// WAJIB IMPORT INI BIAR GAK ERROR 'Class HasMany not found'
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_id',
        'pickup_point',
        'destination_point',
        'distance',
        'total_price',
        'payment_method',
        'status'
    ];

    /**
     * Relasi ke Messages (Chat)
     * Pake 'booking_id' sebagai foreign key manual buat mastiin sinkron sama DB
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'booking_id');
    }

    /**
     * Relasi ke User (Penumpang)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Trip
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}