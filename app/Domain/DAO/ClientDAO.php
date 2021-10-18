<?php

namespace App\Domain\DAO;

use App\Models\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $client = Client::where('id', $clientId)->first();

        if (!$client) {
            throw new ModelNotFoundException('Client ' . $clientId . ' was not found');
        }

        return $client;
    }
}
