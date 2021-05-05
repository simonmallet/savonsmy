<?php

namespace App\Domain\DAO;

use App\Models\Categorie;
use Illuminate\Support\Collection;

class POFormDAO
{
    /** @var VersionDAO */
    private $versionDAO;

    public function __construct(VersionDAO $versionDAO)
    {
        $this->versionDAO = $versionDAO;
    }

    public function getCurrentPOForm(): Collection
    {
        return Categorie::where('version_id', $this->versionDAO->getCurrentVersion())->orderBy('rank')->get();
    }
}
