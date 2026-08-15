<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blacklist extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_id',
        'status',
        'priority',
        'wanted',
    ];

    protected $casts = [
        'wanted' => 'boolean',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function scopeWanted(Builder $query): Builder
    {
        return $query->where('wanted', true);
    }
}
