<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detection extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_id',
        'vehicle_id',
        'track_id',
        'detected_plate_number',
        'plate_confidence',
        'detected_model',
        'model_confidence',
        'detected_type',
        'type_confidence',
        'detected_color',
        'color_confidence',
        'vehicle_image_path',
        'plate_image_path',
        'plate_match',
        'color_mismatch',
        'type_mismatch',
        'model_mismatch',
        'plate_mismatch',
        'risk_score',
        'severity',
        'violation_type',
        'message',
        'detected_at',
    ];

    protected $casts = [
        'plate_confidence' => 'float',
        'model_confidence' => 'float',
        'type_confidence' => 'float',
        'color_confidence' => 'float',
        'risk_score' => 'float',
        'plate_match' => 'boolean',
        'color_mismatch' => 'boolean',
        'type_mismatch' => 'boolean',
        'model_mismatch' => 'boolean',
        'plate_mismatch' => 'boolean',
        'detected_at' => 'datetime',
    ];

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
