<?php

namespace Database\Seeders;

use App\Models\PoliceUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliceUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PoliceUnit::factory()->count(12)->active()->create();
        PoliceUnit::factory()->count(8)->inactive()->create();
    }
}
