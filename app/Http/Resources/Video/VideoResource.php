<?php

namespace App\Http\Resources\Video;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
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
            'updated_at' => $this->updated_at,
        ];
    }
}
