<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    // Hapus 'origin' dan 'destination' dari sini karena di DB sudah gak ada!
    protected $fillable = [
        'user_id',
        'vehicle_type', 
        'price',
        'empty_seats',
        'description',
        'status'
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}