<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class VehicleListingService
{
    public function paginate(array $filters, int $perPage = 25): LengthAwarePaginator
    {
        return Vehicle::query()
            ->with('blacklists')
            ->search($filters['search'] ?? null)
            ->ofType($filters['type'] ?? null)
            ->latest('id')
            ->paginate($perPage);
    }

    public function getAvailableTypes(): array
    {
        return Vehicle::query()
            ->whereNotNull('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type')
            ->all();
    }
}
