<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardStatsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'active_police_units' => $this->resource['active_police_units'],
            'scans_today' => $this->resource['scans_today'],
            'alerts' => $this->resource['alerts'],
            'wanted_vehicles' => $this->resource['wanted_vehicles'],
        ];
    }
}
