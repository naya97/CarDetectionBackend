<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoliceUnit extends Model
{
    protected $fillable = [
        'unit_code',
        'vehicle_number',
        'location',
        'is_active',
        'last_active_at',
    ];

    public function detections()
    {
        return $this->hasMany(Detection::class);
    }

    public function getLastActiveAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->toDateTimeString() : null;
    }
}
