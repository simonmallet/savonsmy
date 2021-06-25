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
        return Categorie::where('version_id', $this->versionDAO->getCurrentVersionId())->orderBy('rank')->get();
    }

    public function getPOFormFromVersion(int $version): Collection
    {
        return Categorie::where('version_id', $version)->orderBy('rank')->get();
    }
}
