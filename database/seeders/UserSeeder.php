<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@alpr.com',
            'role' => 'admin',
        ]);

        // Create some random users
        User::factory()->count(5)->create();
    }
}
