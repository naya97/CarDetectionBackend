<?php

namespace App\Http\Resources\Video;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'uploaded_at' => $this->uploaded_at?->toDateTimeString(),
            'duration' => $this->duration,
            'status' => $this->status,
        ];
    }
}
