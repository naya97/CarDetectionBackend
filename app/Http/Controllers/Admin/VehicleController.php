<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use App\Http\Resources\Vehicle\VehicleResource;
use App\Http\Resources\Vehicle\VehicleStatsResource;
use App\Models\Vehicle;
use App\Services\Vehicle\VehicleListingService;
use App\Services\Vehicle\VehicleStatsService;
use App\Services\Vehicle\VehicleWriteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct(
        private readonly VehicleStatsService $statsService,
        private readonly VehicleListingService $listingService,
        private readonly VehicleWriteService $writeService,
    ) {}

    // ─── STATS ───
    public function stats()
    {
        return new VehicleStatsResource([
            'total_vehicles' => $this->statsService->getTotalVehicles(),
            'blacklisted_vehicles' => $this->statsService->getBlacklistedVehiclesCount(),
            'added_today' => $this->statsService->getAddedTodayCount(),
        ]);
    }

    // ─── LIST / INDEX ───
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

    // ─── SHOW ───
    public function show(Vehicle $vehicle): JsonResponse
    {
        $vehicle->load(['blacklists', 'detections']);

        return response()->json([
            'vehicle' => new VehicleResource($vehicle),
        ]);
    }

    // ─── CREATE ───
    public function store(StoreVehicleRequest $request): JsonResponse
    {
        $vehicle = $this->writeService->create($request->validated());

        return response()->json([
            'message' => 'Vehicle created successfully.',
            'vehicle' => new VehicleResource($vehicle),
        ], 201);
    }

    // ─── UPDATE ───
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle): JsonResponse
    {
        $vehicle = $this->writeService->update($vehicle, $request->validated());

        return response()->json([
            'message' => 'Vehicle updated successfully.',
            'vehicle' => new VehicleResource($vehicle),
        ]);
    }

    // ─── DELETE ───
    public function destroy(Vehicle $vehicle): JsonResponse
    {
        $this->writeService->remove($vehicle);

        return response()->json([
            'message' => 'Vehicle deleted successfully.',
        ]);
    }
}
