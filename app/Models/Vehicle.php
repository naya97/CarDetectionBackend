<?php

namespace App\Models;

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

    public function blacklist()
    {
        return $this->hasMany(Blacklist::class);
    }

    public function detections()
    {
        return $this->hasMany(Detection::class);
    }
}
