<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle;

class VehicleWriteService
{
    public function create(array $data): Vehicle
    {
        return Vehicle::create($data);
    }

    public function update(Vehicle $vehicle, array $data): Vehicle
    {
        $vehicle->update($data);
        return $vehicle->fresh();
    }

    public function remove(Vehicle $vehicle): void
    {
        $vehicle->delete();
    }
}
