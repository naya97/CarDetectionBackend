<?php

namespace Database\Seeders;

use App\Models\Detection;
use App\Models\Video;
use Illuminate\Database\Seeder;

class DetectionSeeder extends Seeder
{
    public function run(): void
    {
        // Only create detections for completed videos
        $completedVideos = Video::where('status', 'completed')->get();

        if ($completedVideos->isEmpty()) {
            $this->command?->warn('No completed videos found. Run VideoSeeder first.');
            return;
        }

        foreach ($completedVideos as $video) {
            // Create detections matching the video's total_vehicles
            $count = $video->total_vehicles ?: fake()->numberBetween(5, 30);

            Detection::factory()->count($count)->create([
                'video_id' => $video->id,
            ]);
        }

        // Recalculate actual violation counts from detections
        foreach ($completedVideos as $video) {
            $detections = Detection::where('video_id', $video->id)->get();

            $totalVehicles = $detections->count();
            $totalViolations = $detections->whereNotNull('violation_type')->count();
            $highViolations = $detections->where('severity', 'عالي')->count();
            $mediumViolations = $detections->where('severity', 'متوسط')->count();
            $lowViolations = $detections->where('severity', 'منخفض')->count();

            $video->update([
                'total_vehicles' => $totalVehicles,
                'total_violations' => $totalViolations,
                'high_violations' => $highViolations,
                'medium_violations' => $mediumViolations,
                'low_violations' => $lowViolations,
            ]);
        }
    }
}
