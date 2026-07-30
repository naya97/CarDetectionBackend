<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Detection extends Model
{
    protected $fillable = [
        'vehicle_id',
        'police_unit_id',
        'detected_at',
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

    protected $casts = [
        'detected_at' => 'datetime',
        'confidence' => 'float',
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

    public function scopeDetectedOn(Builder $query, Carbon $date): Builder
    {
        return $query->whereDate('detected_at', $date);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->detectedOn(today());
    }

    public function scopeYesterday(Builder $query): Builder
    {
        return $query->detectedOn(today()->subDay());
    }

    public function scopeBetweenDates(Builder $query, Carbon $start, Carbon $end): Builder
    {
        return $query->whereBetween('detected_at', [$start, $end]);
    }

    public function scopeMatched(Builder $query): Builder
    {
        return $query->where('match_status', 'match');
    }

    public function scopeWanted(Builder $query): Builder
    {
        return $query->whereHas('vehicle.latestBlacklist', fn (Builder $q) => $q->wanted());
    }
}
