<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Trip;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Utama Lo
        User::factory()->create([
            'name' => 'Bang Doand',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Driver Dummy Anak Medan
        $driver1 = User::factory()->create(['name' => 'Ucok Driver', 'email' => 'ucok@example.com']);
        $driver2 = User::factory()->create(['name' => 'Butet Trans', 'email' => 'butet@example.com']);

        // Trip Rute Medan
        Trip::create([
            'user_id' => $driver2->id,
            'origin' => 'Medan (Amplas)',
            'destination' => 'Parapat (Danau Toba)',
            'departure_time' => now()->addDays(1),
            'empty_seats' => 6,
            'price' => 5000, // SESUAIKAN: Gunakan harga per KM, bukan harga total flat
            'status' => 'open',
            'description' => 'Innova Reborn, bagasi luas. Lewat jalan tol baru.'
        ]);

        Trip::create([
            'user_id' => $driver2->id,
            'origin' => 'Medan (Amplas)',
            'destination' => 'Parapat (Danau Toba)',
            'departure_time' => now()->addDays(1),
            'empty_seats' => 6,
            'price' => 85000,
            'status' => 'open',
            'description' => 'Innova Reborn, bagasi luas. Lewat jalan tol baru.'
        ]);
    }
}