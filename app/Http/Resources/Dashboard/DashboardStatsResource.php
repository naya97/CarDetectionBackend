<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardStatsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'videos' => $this->resource['videos'],
            'detections_today' => $this->resource['detections_today'],
            'violations_today' => $this->resource['violations_today'],
            'wanted_vehicles' => $this->resource['wanted_vehicles'],
            'overview' => $this->resource['overview'],
        ];
    }
}
