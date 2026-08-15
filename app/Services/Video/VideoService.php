<?php

namespace App\Services\Video;

use App\Jobs\StartAiProcessingJob;
use App\Models\Video;

class VideoService
{
    public function createAndStartProcessing(string $originalPath, string $name, ?float $duration, int $size): Video
    {
        $video = Video::create([
            'name' => $name,
            'original_video_path' => $originalPath,
            'uploaded_at' => now(),
            'duration' => $duration,
            'size' => $size,
            'status' => 'processing',
        ]);

        dispatch(new StartAiProcessingJob($video));

        return $video;
    }

    public function updateStatus(Video $video, string $status): Video
    {
        $video->update(['status' => $status]);
        return $video;
    }

    public function updateCounters(Video $video, array $counters): Video
    {
        $video->update([
            'total_vehicles' => $counters['total_vehicles'] ?? 0,
            'total_violations' => $counters['total_violations'] ?? 0,
            'high_violations' => $counters['high_violations'] ?? 0,
            'medium_violations' => $counters['medium_violations'] ?? 0,
            'low_violations' => $counters['low_violations'] ?? 0,
        ]);

        return $video;
    }
}
