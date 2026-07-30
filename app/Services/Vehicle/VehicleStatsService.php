<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle;

class VehicleStatsService
{
    public function getTotalVehicles(): int
    {
        return Vehicle::count();
    }

    public function getBlacklistedVehiclesCount(): int
    {
        return Vehicle::currentlyWanted()->count();
    }

    public function getAddedTodayCount(): int
    {
        return Vehicle::addedToday()->count();
    }
}
