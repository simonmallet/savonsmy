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
                        'id' => 1,
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
                        'id' => 2,
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
                        'id' => 3,
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
                        'id' => 4,
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
                        'id' => 5,
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
                        'id' => 6,
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

    public function addSubmit(Request $request)
    {
        return redirect()->route('purchase_orders.index');
    }
}
