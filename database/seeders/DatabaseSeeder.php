<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DistrictsTableSeeder::class,
            TransportSeeder::class,
            // Roles, users, companies, buses, trips and bookings.
            DemoDataSeeder::class,
        ]);
    }
}
