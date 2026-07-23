<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    protected $fillable = [
        'vehicle_id',
        'status',
        'priority',
        'wanted',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
