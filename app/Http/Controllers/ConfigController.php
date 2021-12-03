<?php

namespace App\Http\Controllers;

use App\Domain\Config\OperationStatus;
use App\Domain\DAO\ConfigDAO;
use App\Domain\Helpers\ClientHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConfigController extends Controller
{
    /** @var ConfigDAO */
    private $configDAO;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ConfigDAO $configDAO)
    {
        $this->configDAO = $configDAO;
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('config.index')->with('configs', $this->configDAO->getConfigList());
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $configName => $configValue) {
            $this->configDAO->updateConfig($configName, $configValue);
        }
        return response()->json(['status' => OperationStatus::STATUS_OK]);
    }
}
