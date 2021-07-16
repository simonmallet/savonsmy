<?php

namespace App\Http\Controllers\Admin;

use App\Constants\OrderStatus;
use App\Domain\BO\OrderBO;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    private OrderBO $orderBO;

    public function __construct(OrderBO $orderBO)
    {
        $this->orderBO = $orderBO;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Partner User',
                'client_name' => 'Jean Coutu Beauharnois',
                'email_verified' => true,
                'partner_approved' => true,
                'last_logon' => '2021-04-17 00:00:00',
            ],
            [
                'id' => 2,
                'name' => 'Jocelyne Huard',
                'client_name' => 'Revendeur N-B',
                'email_verified' => true,
                'partner_approved' => false,
                'last_logon' => '2021-04-16 00:00:00',
            ],
            [
                'id' => 3,
                'name' => 'Yvette Samson',
                'client_name' => 'Jean Coutu Chateauguay',
                'email_verified' => false,
                'partner_approved' => false,
                'last_logon' => '2021-04-15 00:00:00',
            ],
        ];

        return view('admin.dashboard')->with('users', $users)->with('purchaseOrders', $this->orderBO->fetchLatestOrdersFromAllClients());
    }
}
