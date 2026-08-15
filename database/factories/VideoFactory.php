<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition(): array
    {
        $status = fake()->randomElement(['processing', 'completed', 'failed']);
        $id = fake()->unique()->numberBetween(1, 9999);

        return [
            'name' => fake()->randomElement(['traffic', 'highway', 'street', 'intersection']) . '_' . fake()->numberBetween(1, 999) . '.mp4',
            'original_video_path' => "originals/{$id}/original.mp4",
            'processed_video_path' => $status === 'completed' ? "processed/{$id}/processed.mp4" : null,
            'uploaded_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'duration' => fake()->randomFloat(2, 30, 600),
            'size' => fake()->numberBetween(10 * 1024 * 1024, 500 * 1024 * 1024),
            'status' => $status,
            'total_vehicles' => $status === 'completed' ? fake()->numberBetween(5, 50) : 0,
            'total_violations' => $status === 'completed' ? fake()->numberBetween(0, 15) : 0,
            'high_violations' => $status === 'completed' ? fake()->numberBetween(0, 5) : 0,
            'medium_violations' => $status === 'completed' ? fake()->numberBetween(0, 8) : 0,
            'low_violations' => $status === 'completed' ? fake()->numberBetween(0, 5) : 0,
        ];
    }

    public function processing(): static
    {
        return $this->state(fn() => [
            'status' => 'processing',
            'processed_video_path' => null,
            'total_vehicles' => 0,
            'total_violations' => 0,
            'high_violations' => 0,
            'medium_violations' => 0,
            'low_violations' => 0,
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn() => [
            'status' => 'completed',
            'processed_video_path' => fn(array $attributes) => "processed/" . fake()->numberBetween(1, 9999) . "/processed.mp4",
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn() => [
            'status' => 'failed',
            'processed_video_path' => null,
        ]);
    }
}
