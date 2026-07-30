<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'plate_number',
        'country_code',
        'color',
        'type',
        'model',
        'owner_name',
    ];

    public function detections()
    {
        return $this->hasMany(Detection::class);
    }

    // Full blacklist history for this vehicle
    public function blacklists()
    {
        return $this->hasMany(Blacklist::class);
    }

    // The single most recent blacklist record — represents current status
    public function latestBlacklist()
    {
        return $this->hasOne(Blacklist::class)->latestOfMany();
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('plate_number', 'like', "%{$term}%")
              ->orWhere('owner_name', 'like', "%{$term}%");
        });
    }

    public function scopeOfType(Builder $query, ?string $type): Builder
    {
        return $type ? $query->where('type', $type) : $query;
    }

    public function scopeAddedToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    // "Currently blacklisted" = latest record for this vehicle has wanted = true
    public function scopeCurrentlyWanted(Builder $query): Builder
    {
        return $query->whereHas('latestBlacklist', fn (Builder $q) => $q->wanted());
    }
}
