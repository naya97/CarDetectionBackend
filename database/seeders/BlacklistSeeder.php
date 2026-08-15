<?php

namespace Database\Seeders;

use App\Models\Blacklist;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class BlacklistSeeder extends Seeder
{
    public function run(): void
    {
        // Get 30 random vehicles and add them to blacklist
        $vehicles = Vehicle::inRandomOrder()->take(30)->get();

        foreach ($vehicles as $vehicle) {
            Blacklist::factory()->create([
                'vehicle_id' => $vehicle->id,
            ]);
        }

        // Add 10 more definitely wanted
        Vehicle::inRandomOrder()->take(10)->get()->each(function ($vehicle) {
            Blacklist::factory()->wanted()->create([
                'vehicle_id' => $vehicle->id,
            ]);
        });
    }
}
