<?php

namespace Database\Seeders;

use App\Models\Detection;
use App\Models\PoliceUnit;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Vehicle::count() === 0 || PoliceUnit::count() === 0) {
            $this->command?->warn('Skipping DetectionSeeder: seed Vehicles and PoliceUnits first.');
            return;
        }

        // Spread over the last 30 days — enough history to exercise the
        // dashboard's ?days= param on the trend/color/type/match-rate charts
        Detection::factory()->count(8000)->create();
    }
}
