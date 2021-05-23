<?php

namespace App\Domain\Helpers;

use Illuminate\Support\Facades\Auth;

class ClientHelper
{
    public static function getClientId()
    {
        return Auth::user()->client[0]->id;
    }
}
