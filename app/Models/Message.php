<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // Tambahkan ini supaya bisa simpan data!
    protected $fillable = ['booking_id', 'sender_id', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}