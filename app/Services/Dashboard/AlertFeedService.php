<?php

namespace App\Services\Dashboard;

use App\Models\DetectionAlert;
use Illuminate\Database\Eloquent\Collection;

class AlertFeedService
{
    public function getLatest(int $limit = 5): Collection
    {
        return DetectionAlert::query()
            ->with(['detection.vehicle', 'detection.policeUnit'])
            ->latest('created_at')
            ->take($limit)
            ->get();
    }
}
