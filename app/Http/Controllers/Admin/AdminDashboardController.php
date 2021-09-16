<?php

namespace App\Http\Controllers\Admin;

use App\Domain\BO\OrderBO;
use App\Domain\DAO\UserDAO;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    private OrderBO $orderBO;
    private UserDAO $userDAO;

    public function __construct(OrderBO $orderBO, UserDAO $userDAO)
    {
        $this->orderBO = $orderBO;
        $this->userDAO = $userDAO;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard')->with('users', $this->userDAO->fetchList()->sortBy('name'))->with('purchaseOrders', $this->orderBO->fetchLatestOrdersFromAllClients());
    }
}
