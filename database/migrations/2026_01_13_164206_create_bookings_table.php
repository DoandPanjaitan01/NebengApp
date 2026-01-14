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
        // Awalnya kosong, baru terisi pas driver klik 'Ambil'
        $table->foreignId('trip_id')->nullable()->constrained()->onDelete('set null');
        
        $table->string('pickup_point');
        $table->string('destination_point');
        $table->decimal('distance', 8, 2);
        $table->decimal('total_price', 12, 2);
        
        $table->enum('vehicle_type', ['motor', 'mobil_l', 'mobil_xl']);
        $table->enum('payment_method', ['cash', 'nebengpay']);
        $table->enum('status', ['searching', 'accepted', 'completed', 'cancelled'])->default('searching');
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
