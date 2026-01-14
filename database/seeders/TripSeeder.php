<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada driver untuk nempel ke Trip
        $driver = User::updateOrCreate(
            ['email' => 'driver@nebeng.test'],
            [
                'name' => 'Bang Jago Driver',
                'password' => Hash::make('password'), // password default
            ]
        );

        // Data dummy tebengan
        $data = [
            [
                'user_id' => $driver->id,
                'origin' => 'Gerbang Utama Kampus',
                'destination' => 'Stasiun Universitas Indonesia',
                'departure_time' => now()->addHours(2),
                'empty_seats' => 4,
                'price' => 12000,
                'description' => 'Mobil nyaman, full AC.',
                'status' => 'open',
            ],
            [
                'user_id' => $driver->id,
                'origin' => 'Fakultas Ilmu Komputer',
                'destination' => 'Kosan Margonda Gang Sadar',
                'departure_time' => now()->addHours(5),
                'empty_seats' => 1,
                'price' => 8000,
                'description' => 'Naik motor, helm aman.',
                'status' => 'open',
            ],
            [
                'user_id' => $driver->id,
                'origin' => 'Perpustakaan Pusat',
                'destination' => 'Terminal Depok',
                'departure_time' => now()->addDays(1),
                'empty_seats' => 2,
                'price' => 15000,
                'description' => 'Berangkat pagi sekali.',
                'status' => 'open',
            ],
        ];

        foreach ($data as $item) {
            Trip::create($item);
        }
    }
}