<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detection extends Model
{
    protected $fillable = [
        'vehicle_id',
        'police_unit_id',
        'detection_time',
        'location',
        'detected_model',
        'detected_color',
        'detected_type',
        'detected_plate_number',
        'confidence',
        'match_status',
        'vehicle_image_path',
        'plate_image_path',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function policeUnit()
    {
        return $this->belongsTo(PoliceUnit::class);
    }

    public function detectionAlerts()
    {
        return $this->hasMany(DetectionAlert::class);
    }
}
