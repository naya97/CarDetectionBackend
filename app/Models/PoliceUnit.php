<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliceUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_code',
        'vehicle_number',
        'location',
        'is_active',
        'last_active_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_active_at' => 'datetime',
    ];

    public function detections()
    {
        return $this->hasMany(Detection::class);
    }

    public function getLastActiveAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->toDateTimeString() : null;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
