<?php

namespace App\Http\Controllers;

use App\Constants\OrderStatus;

class AdminDashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $historicalPurchaseOrders = [
            [
                'id' => '3928172',
                'client_name' => 'Jean Coutu Beauharnois',
                'amount_items' => 6,
                'status' => OrderStatus::NOT_TREATED,
                'created_at' => '2021-04-17 03:00',
                'updated_at' => '2021-04-17 03:00',
            ],
            [
                'id' => '2910002',
                'client_name' => 'Jean Coutu Beauharnois',
                'amount_items' => 14,
                'status' => OrderStatus::IN_PROGRESS,
                'created_at' => '2021-04-14 08:23',
                'updated_at' => '2021-04-15 16:01',
            ],
            [
                'id' => '8291827',
                'client_name' => 'Jean Coutu Beauharnois',
                'amount_items' => 3,
                'status' => OrderStatus::COMPLETED,
                'created_at' => '2021-04-11 12:46',
                'updated_at' => '2021-04-12 17:15',
            ],
        ];

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
        return view('admin.dashboard')->with('users', $users)->with('historicalPurchaseOrders', $historicalPurchaseOrders);
    }
}
