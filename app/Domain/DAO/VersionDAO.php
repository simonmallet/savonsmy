<?php

namespace App\Domain\DAO;

use App\Models\Version;
use Carbon\Carbon;

class VersionDAO
{
    public function getCurrentVersionId(): int
    {
        return Version::max('id');
    }

    public function getCurrentVersionDate(): Carbon
    {
        return Carbon::parse(Version::max('created_at'));
    }

    public function bumpVersionNumber(): int
    {
        $version = new Version();

        $version->save();

        return $version->id;
    }
}
