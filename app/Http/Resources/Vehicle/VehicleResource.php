<?php

namespace App\Http\Resources\Vehicle;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'plate_number' => $this->plate_number,
            'country_code' => $this->country_code,
            'type' => $this->type,
            'model' => $this->model,
            'color' => $this->color,
            'owner_name' => $this->owner_name,
            'is_blacklisted' => (bool) $this->blacklist?->wanted,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
