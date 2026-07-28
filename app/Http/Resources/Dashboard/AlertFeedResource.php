<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class AlertFeedResource extends JsonResource
{
    public function toArray($request): array
    {
        $detection = $this->detection;

        return [
            'id' => $this->id,
            'alert_type' => $this->alert_type,
            'severity' => $this->severity,
            'message' => $this->message,
            'seen' => $this->seen,
            'created_at' => $this->created_at?->toDateTimeString(),
            'plate_number' => $detection?->detected_plate_number,
            'vehicle_type' => $detection?->detected_type,
            'vehicle_color' => $detection?->detected_color,
            'vehicle_image_path' => $detection?->vehicle_image_path,
            'police_unit_code' => $detection?->policeUnit?->unit_code,
        ];
    }
}
