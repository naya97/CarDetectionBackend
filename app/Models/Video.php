<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'original_video_path',
        'processed_video_path',
        'uploaded_at',
        'duration',
        'size',
        'status',
        'total_vehicles',
        'total_violations',
        'high_violations',
        'medium_violations',
        'low_violations',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'duration' => 'decimal:2',
    ];

    public function detections(): HasMany
    {
        return $this->hasMany(Detection::class);
    }
}
