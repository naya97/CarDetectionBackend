<?php

namespace App\Http\Resources\Video;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoDetectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'plate_number' => $this->detected_plate_number,
            'violation_type' => $this->violation_type,
            'severity' => $this->severity,
            'message' => $this->message,
        ];
    }
}
