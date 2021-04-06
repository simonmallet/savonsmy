<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseOrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('purchase_orders.index');
    }

    public function addIndex()
    {
        $items = [
            [
                'price' => 6,
                'name' => 'Savon en barre',
                'variants' => [
                    [
                        'name' => 'Avoine & miel (léger exfoliant)',
                        'description' => 'blabla avoine et miel',
                        'notes' => '',
                        'availability' => true,
                        'flags' => [
                            'no_perfume_no_oils' => true,
                            'quality_essential_oils' => false,
                        ],
                    ]
                ],
            ],
        ];
        return view('purchase_orders.add')->with('items', $items);
    }
}
