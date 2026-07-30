<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DetectionAlert extends Model
{
    protected $fillable = [
        'detection_id',
        'alert_type',
        'severity',
        'message',
        'seen',
    ];

    protected $casts = [
        'seen' => 'boolean',
    ];


    public function detection()
    {
        return $this->belongsTo(Detection::class);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeUnseen(Builder $query): Builder
    {
        return $query->where('seen', false);
    }

    public function scopeWanted(Builder $query): Builder
    {
        return $query->whereHas('vehicle.blacklists', fn (Builder $q) => $q->wanted());
    }
}
