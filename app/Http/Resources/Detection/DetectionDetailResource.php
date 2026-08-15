<?php

namespace App\Http\Resources\Detection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetectionDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vehicle_image_url' => $this->vehicle_image_path
                ? app(\App\Services\Video\VideoResultService::class)->getVehicleImageUrl($this->vehicle_image_path)
                : null,
            'comparison' => [
                'plate' => [
                    'ai' => $this->detected_plate_number,
                    'confidence' => $this->plate_confidence,
                    'actual' => $this->vehicle?->plate_number,
                    'mismatch' => $this->plate_mismatch,
                ],
                'model' => [
                    'ai' => $this->detected_model,
                    'confidence' => $this->model_confidence,
                    'actual' => $this->vehicle?->model,
                    'mismatch' => $this->model_mismatch,
                ],
                'type' => [
                    'ai' => $this->detected_type,
                    'confidence' => $this->type_confidence,
                    'actual' => $this->vehicle?->type,
                    'mismatch' => $this->type_mismatch,
                ],
                'color' => [
                    'ai' => $this->detected_color,
                    'confidence' => $this->color_confidence,
                    'actual' => $this->vehicle?->color,
                    'mismatch' => $this->color_mismatch,
                ],
            ],
            'risk_score' => $this->risk_score,
            'severity' => $this->severity,
            'violation_type' => $this->violation_type,
            'message' => $this->message,
        ];
    }
}
