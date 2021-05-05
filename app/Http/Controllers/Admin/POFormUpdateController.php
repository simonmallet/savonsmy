<?php

namespace App\Http\Controllers\Admin;

use App\Domain\BO\POFormBO;
use App\Domain\DAO\CategoryDAO;
use App\Domain\DAO\CategoryItemDAO;
use App\Domain\DAO\POFormDAO;
use App\Domain\DAO\VersionDAO;
use App\Http\Controllers\Controller;
use App\Http\Requests\POFormUpdateRequest;
use Illuminate\Http\Request;

class POFormUpdateController extends Controller
{
    /** @var POFormDAO */
    private $POFormDAO;

    /** @var VersionDAO */
    private $versionDAO;

    /** @var CategoryDAO */
    private $categoryDAO;

    /** @var CategoryItemDAO */
    private $categoryItemDAO;

    /** @var POFormBO */
    private $poFormBO;

    public function __construct(POFormDAO $POFormDAO, VersionDAO $versionDAO, CategoryDAO $categoryDAO, CategoryItemDAO $categoryItemDAO, POFormBO $poFormBO)
    {
        $this->POFormDAO = $POFormDAO;
        $this->versionDAO = $versionDAO;
        $this->categoryDAO = $categoryDAO;
        $this->categoryItemDAO = $categoryItemDAO;
        $this->poFormBO = $poFormBO;
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
            ->with('currentVersion', $this->versionDAO->getCurrentVersion())
            ->with('nextAvailableCategoryId', $this->categoryDAO->getNextAvailableCategoryId())
            ->with('nextAvailableCategoryItemId', $this->categoryItemDAO->getNextAvailableCategoryItemId());
    }

    /** @todo: faire les validateurs */
    public function submit(POFormUpdateRequest $request)
    {
        $this->poFormBO->updatePOForm($request->all());

        return view('admin.poform.index')
            ->with('categories', $this->POFormDAO->getCurrentPOForm())
            ->with('currentVersion', $this->versionDAO->getCurrentVersion())
            ->with('nextAvailableCategoryId', $this->categoryDAO->getNextAvailableCategoryId())
            ->with('nextAvailableCategoryItemId', $this->categoryItemDAO->getNextAvailableCategoryItemId());
    }
}
