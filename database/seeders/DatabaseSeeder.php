<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,        // 1 admin + 5 users
            VehicleSeeder::class,     // 200 vehicles
            BlacklistSeeder::class,   // 40 blacklist entries
            VideoSeeder::class,       // 20 videos (3 processing, 2 failed, 15 completed)
            DetectionSeeder::class,   // ~200+ detections for completed videos
        ]);
    }
}
