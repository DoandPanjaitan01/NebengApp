<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            
            // Kolom wajib untuk logic di TripController
            $table->enum('vehicle_type', ['motor', 'mobil_l', 'mobil_xl'])->default('motor');
            $table->decimal('price', 12, 2)->default(0); 
            $table->integer('empty_seats')->default(1);
            
            $table->text('description')->nullable();
            $table->enum('status', ['open', 'full', 'completed', 'inactive'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};