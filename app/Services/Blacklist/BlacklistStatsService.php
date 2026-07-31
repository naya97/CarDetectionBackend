<?php

namespace App\Services\Blacklist;

use App\Models\Blacklist;

class BlacklistStatsService
{
    public function getTotalCount(): int
    {
        return Blacklist::wanted()->count();
    }
}
