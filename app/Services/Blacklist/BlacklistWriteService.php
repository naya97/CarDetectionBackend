<?php

namespace App\Services\Blacklist;

use App\Models\Blacklist;

class BlacklistWriteService
{
    public function create(array $data): Blacklist
    {
        $data['wanted'] ??= true;

        return Blacklist::create($data);
    }

    public function update(Blacklist $blacklist, array $data): Blacklist
    {
        $blacklist->update($data);

        return $blacklist;
    }

    public function remove(Blacklist $blacklist): Blacklist
    {
        $blacklist->update(['wanted' => false]);

        return $blacklist;
    }
}
