<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        $table->foreignId('trip_id')->constrained()->onDelete('cascade'); 
        $table->string('pickup_point');      // Untuk "Titik Jemput (Kosan)"
        $table->string('destination_point'); // Untuk "Titik Antar (Kampus)"
        $table->integer('distance');         // Untuk KM dari slider
        $table->integer('total_price');      // Untuk hasil KM * Harga
        $table->string('status')->default('pending'); 
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
