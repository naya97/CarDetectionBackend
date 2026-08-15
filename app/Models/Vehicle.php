<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'country_code',
        'color',
        'type',
        'model',
        'owner_name',
    ];

    public function detections(): HasMany
    {
        return $this->hasMany(Detection::class);
    }

    public function blacklists(): HasMany
    {
        return $this->hasMany(Blacklist::class);
    }

    public function latestBlacklist(): HasOne
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

    public function scopeCurrentlyWanted(Builder $query): Builder
    {
        return $query->whereHas('latestBlacklist', fn(Builder $q) => $q->wanted());
    }
}
