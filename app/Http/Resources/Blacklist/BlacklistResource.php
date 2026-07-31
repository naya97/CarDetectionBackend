<?php

namespace App\Http\Resources\Blacklist;

use Illuminate\Http\Resources\Json\JsonResource;

class BlacklistResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'plate_number' => $this->vehicle?->plate_number,
            'owner_name' => $this->vehicle?->owner_name,
            'vehicle_type' => $this->vehicle?->type,
            'vehicle_color' => $this->vehicle?->color,
            'priority' => $this->priority,
            'status' => $this->status,
            'wanted' => $this->wanted,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
