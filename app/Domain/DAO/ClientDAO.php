<?php

namespace App\Domain\DAO;

use App\Models\Client;
use Illuminate\Support\Collection;

class ClientDAO
{
    public function fetchList(?int $active = null): Collection
    {
        $query = Client::query();

        if (!is_null($active)) {
            $query->where('active', $active);
        }

        return $query->get();
    }

    public function fetchInfo(int $clientId): Client
    {
        return Client::where('id', $clientId)->first();
    }
}
