<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blacklist\StoreBlacklistRequest;
use App\Http\Requests\Blacklist\UpdateBlacklistRequest;
use App\Http\Resources\Blacklist\BlacklistResource;
use App\Http\Resources\Blacklist\BlacklistStatsResource;
use App\Models\Blacklist;
use App\Services\Blacklist\BlacklistListingService;
use App\Services\Blacklist\BlacklistStatsService;
use App\Services\Blacklist\BlacklistWriteService;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    public function __construct(
        private readonly BlacklistStatsService $statsService,
        private readonly BlacklistListingService $listingService,
        private readonly BlacklistWriteService $writeService,
    ) {
    }

    public function stats()
    {
        return new BlacklistStatsResource([
            'total' => $this->statsService->getTotalCount(),
        ]);
    }

    public function index(Request $request)
    {
        $entries = $this->listingService->paginate((int) $request->query('per_page', 25));

        return BlacklistResource::collection($entries);
    }

    public function store(StoreBlacklistRequest $request)
    {
        $blacklist = $this->writeService->create($request->validated());

        return new BlacklistResource($blacklist->load('vehicle'));
    }

    public function update(UpdateBlacklistRequest $request, Blacklist $blacklist)
    {
        $blacklist = $this->writeService->update($blacklist, $request->validated());

        return new BlacklistResource($blacklist->load('vehicle'));
    }

    public function destroy(Blacklist $blacklist)
    {
        $this->writeService->remove($blacklist);

        return response()->json(null, 204);
    }
}
