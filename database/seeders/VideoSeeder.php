<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        // Create videos in different statuses
        // Processing videos
        Video::factory()->count(3)->processing()->create();

        // Failed videos
        Video::factory()->count(2)->failed()->create();

        // Completed videos with realistic data
        $completedVideos = Video::factory()->count(15)->completed()->create();

        // Update counters for completed videos to match detections we'll create
        foreach ($completedVideos as $video) {
            $video->update([
                'total_vehicles' => fake()->numberBetween(8, 40),
                'total_violations' => fake()->numberBetween(0, 12),
                'high_violations' => fake()->numberBetween(0, 4),
                'medium_violations' => fake()->numberBetween(0, 6),
                'low_violations' => fake()->numberBetween(0, 4),
            ]);
        }
    }
}
