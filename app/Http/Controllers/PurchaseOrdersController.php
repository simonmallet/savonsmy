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
                    ],
                    [
                        'name' => 'Calendule & argousier',
                        'description' => 'des bonnes calendules...',
                        'notes' => '',
                        'availability' => true,
                        'flags' => [
                            'no_perfume_no_oils' => true,
                            'quality_essential_oils' => false,
                        ],
                    ],
                    [
                        'name' => 'Concombre & menthe (exfoliant)',
                        'description' => 'frais et dispo!!',
                        'notes' => 'De retour Septembre 2021',
                        'availability' => false,
                        'flags' => [
                            'no_perfume_no_oils' => false,
                            'quality_essential_oils' => false,
                        ],
                    ],
                ],
            ],
            [
                'price' => 15,
                'name' => 'Beurre fouetté hydratan',
                'variants' => [
                    [
                        'name' => 'Inodore',
                        'description' => 'Ouin c ca',
                        'notes' => '',
                        'availability' => true,
                        'flags' => [
                            'no_perfume_no_oils' => true,
                            'quality_essential_oils' => false,
                        ],
                    ],
                    [
                        'name' => 'Lavande',
                        'description' => 'un gout...',
                        'notes' => '',
                        'availability' => true,
                        'flags' => [
                            'no_perfume_no_oils' => false,
                            'quality_essential_oils' => true,
                        ],
                    ],
                    [
                        'name' => 'Coco-lime',
                        'description' => 'nice',
                        'notes' => '',
                        'availability' => true,
                        'flags' => [
                            'no_perfume_no_oils' => false,
                            'quality_essential_oils' => false,
                        ],
                    ],
                ],
            ],
        ];
        return view('purchase_orders.add')->with('items', $items);
    }
}
