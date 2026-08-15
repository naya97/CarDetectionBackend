<?php

namespace App\Services\Video;

use App\Models\Video;

class VideoSummaryService
{
    public function getSummary(Video $video): array
    {
        return [
            'id' => $video->id,
            'name' => $video->name,
            'status' => $video->status,
            'original_video_path' => $video->original_video_path,
            'uploaded_at' => $video->uploaded_at,
            'duration' => $video->duration,
            'size' => $video->size,
            'total_vehicles' => $video->total_vehicles,
            'total_violations' => $video->total_violations,
            'high_violations' => $video->high_violations,
            'medium_violations' => $video->medium_violations,
            'low_violations' => $video->low_violations,
            'processed_video_url' => app(VideoResultService::class)->getProcessedVideoUrl($video),
            'updated_at' => $video->updated_at,
        ];
    }
}
