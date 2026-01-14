<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Relasi ke User (Penumpang)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Trip (PENTING buat ambil data driver)
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}