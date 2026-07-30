<?php

namespace App\Http\Resources\Vehicle;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleStatsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'total_vehicles' => $this->resource['total_vehicles'],
            'blacklisted_vehicles' => $this->resource['blacklisted_vehicles'],
            'added_today' => $this->resource['added_today'],
        ];
    }
}
