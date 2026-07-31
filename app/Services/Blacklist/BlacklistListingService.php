<?php

namespace App\Services\Blacklist;

use App\Models\Blacklist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BlacklistListingService
{
    public function paginate(int $perPage = 25): LengthAwarePaginator
    {
        return Blacklist::query()
            ->wanted()
            ->with('vehicle')
            ->latest('id')
            ->paginate($perPage);
    }
}
