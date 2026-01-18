<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // Ini yang bikin Laravel bisa nyambungin Chat ke Pesanan
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            // Ini yang kasih tau siapa yang ngirim chat
            $table->foreignId('sender_id')->constrained('users');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};