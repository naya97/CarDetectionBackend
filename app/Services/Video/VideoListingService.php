<?php

namespace App\Services\Video;

use App\Models\Video;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class VideoListingService
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Video::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest('uploaded_at')->paginate($perPage);
    }
}
