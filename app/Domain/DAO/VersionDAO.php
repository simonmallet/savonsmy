<?php

namespace App\Domain\DAO;

use App\Models\Version;

class VersionDAO
{
    public function getCurrentVersion(): int
    {
        return Version::max('id');
    }

    public function bumpVersionNumber(): int
    {
        $version = new Version();

        $version->save();

        return $version->id;
    }
}
