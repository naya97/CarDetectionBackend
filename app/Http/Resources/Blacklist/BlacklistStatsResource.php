<?php

namespace App\Http\Resources\Blacklist;

use Illuminate\Http\Resources\Json\JsonResource;

class BlacklistStatsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'total' => $this->resource['total'],
        ];
    }
}
