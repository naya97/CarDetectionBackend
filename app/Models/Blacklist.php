<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    protected $fillable = [
        'vehicle_id',
        'status',
        'priority',
        'wanted',
    ];

    protected $casts = [
        'wanted' => 'boolean',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function scopeWanted(Builder $query): Builder
    {
        return $query->where('wanted', true);
    }
}
