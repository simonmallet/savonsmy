<?php

namespace App\Http\Controllers\Admin;

use App\Constants\OrderStatus;
use App\Domain\DAO\POFormDAO;
use App\Domain\DAO\VersionDAO;
use App\Http\Controllers\Controller;

class POFormUpdateController extends Controller
{
    /** @var POFormDAO */
    private $POFormDAO;

    /** @var VersionDAO */
    private $versionDAO;

    public function __construct(POFormDAO $POFormDAO, VersionDAO $versionDAO)
    {
        $this->POFormDAO = $POFormDAO;
        $this->versionDAO = $versionDAO;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.poform.index')
            ->with('categories', $this->POFormDAO->getCurrentPOForm())
            ->with('currentVersion', $this->versionDAO->getCurrentVersion());
    }
}
