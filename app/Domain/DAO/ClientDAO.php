<?php

namespace App\Domain\DAO;

use App\Models\Client;
use Illuminate\Support\Collection;

class ClientDAO
{
    public function fetchList(int $active = 1): Collection
    {
        return Client::where('active', $active)->get();
    }
}
