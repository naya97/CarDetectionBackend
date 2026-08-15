<?php

namespace Database\Factories;

use App\Models\Blacklist;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlacklistFactory extends Factory
{
    protected $model = Blacklist::class;

    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),
            'status' => fake()->randomElement(['active', 'pending', 'review', 'blocked']),
            'priority' => fake()->randomElement(['high', 'medium', 'low']),
            'wanted' => fake()->boolean(85), // 85% wanted
        ];
    }

    public function wanted(): static
    {
        return $this->state(fn() => [
            'wanted' => true,
            'priority' => fake()->randomElement(['high', 'medium']),
        ]);
    }

    public function notWanted(): static
    {
        return $this->state(fn() => [
            'wanted' => false,
            'priority' => 'low',
        ]);
    }
}
