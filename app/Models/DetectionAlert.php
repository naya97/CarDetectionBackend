<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetectionAlert extends Model
{
    protected $fillable = [
        'alert_type',
        'severity',
        'message',
        'seen',
    ];

    public function detection()
    {
        return $this->belongsTo(Detection::class);
    }
}
