<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardChartResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'detections_trend' => $this->resource['detections_trend'],
            'violations_trend' => $this->resource['violations_trend'],
            'color_distribution' => $this->resource['color_distribution'],
            'type_distribution' => $this->resource['type_distribution'],
            'match_rate' => $this->resource['match_rate'],
            'severity_distribution' => $this->resource['severity_distribution'],
        ];
    }
}
