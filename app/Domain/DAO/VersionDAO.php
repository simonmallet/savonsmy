<?php

namespace App\Domain\DAO;

use App\Models\Version;

class VersionDAO
{
    public function getCurrentVersion()
    {
        return Version::max('id');
    }
}
