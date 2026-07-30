<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Vehicle\VehicleResource;
use App\Http\Resources\Vehicle\VehicleStatsResource;
use App\Services\Vehicle\VehicleListingService;
use App\Services\Vehicle\VehicleStatsService;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct(
        private readonly VehicleStatsService $statsService,
        private readonly VehicleListingService $listingService,
    ) {
    }

    public function stats()
    {
        return new VehicleStatsResource([
            'total_vehicles' => $this->statsService->getTotalVehicles(),
            'blacklisted_vehicles' => $this->statsService->getBlacklistedVehiclesCount(),
            'added_today' => $this->statsService->getAddedTodayCount(),
        ]);
    }

    public function index(Request $request)
    {
        $vehicles = $this->listingService->paginate(
            filters: $request->only(['search', 'type']),
            perPage: (int) $request->query('per_page', 25)
        );

        return VehicleResource::collection($vehicles);
    }

    public function filterOptions()
    {
        return response()->json([
            'types' => $this->listingService->getAvailableTypes(),
        ]);
    }
}
