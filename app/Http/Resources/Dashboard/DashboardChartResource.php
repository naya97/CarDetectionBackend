<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardChartResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'scans_trend' => $this->resource['scans_trend'],
            'color_distribution' => $this->resource['color_distribution'],
            'type_distribution' => $this->resource['type_distribution'],
            'match_rate' => $this->resource['match_rate'],
        ];
    }
}
