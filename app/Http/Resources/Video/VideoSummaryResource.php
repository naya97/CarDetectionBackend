<?php

namespace App\Http\Resources\Video;

use App\Services\Video\VideoResultService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoSummaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'uploaded_at' => $this->uploaded_at,
            'duration' => $this->duration,
            'size' => $this->size,
            'total_vehicles' => $this->total_vehicles,
            'total_violations' => $this->total_violations,
            'high_violations' => $this->high_violations,
            'medium_violations' => $this->medium_violations,
            'low_violations' => $this->low_violations,
            'processed_video_url' => app(VideoResultService::class)->getProcessedVideoUrl($this->resource),
            'updated_at' => $this->updated_at,
        ];
    }
}
