<?php

namespace App\Http\Controllers;

use App\Constants\OrderStatus;
use App\Domain\DAO\POFormDAO;
use App\Domain\DAO\VersionDAO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PurchaseOrdersController extends Controller
{
    /** @var POFormDAO */
    private $poFormDAO;

    /** @var VersionDAO */
    private $versionDAO;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(POFormDAO $poFormDAO, VersionDAO $versionDAO)
    {
        $this->poFormDAO = $poFormDAO;
        $this->versionDAO = $versionDAO;
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $historicalPurchaseOrders = [
            [
                'id' => '3928172',
                'amount_items' => 6,
                'status' => OrderStatus::NOT_TREATED,
                'created_at' => '2021-04-17 03:00',
                'updated_at' => '2021-04-17 03:00',
            ],
            [
                'id' => '2910002',
                'amount_items' => 14,
                'status' => OrderStatus::IN_PROGRESS,
                'created_at' => '2021-04-14 08:23',
                'updated_at' => '2021-04-15 16:01',
            ],
            [
                'id' => '8291827',
                'amount_items' => 3,
                'status' => OrderStatus::COMPLETED,
                'created_at' => '2021-04-11 12:46',
                'updated_at' => '2021-04-12 17:15',
            ],
        ];
        return view('purchase_orders.index')->with('historicalPurchaseOrders', $historicalPurchaseOrders);
    }

    public function addIndex()
    {
        return view('purchase_orders.add')
            ->with('categories', $this->poFormDAO->getCurrentPOForm())
            ->with('currentVersionDate', $this->versionDAO->getCurrentVersionDate()->format('Y-m-d'))
            ->with('user', ['name' => 'Simon Mallet', 'discount_from_retail_price' => 30]);
    }

    public function addSubmit(Request $request)
    {
        //error_log(print_r($request->all(), true));

        /** @todo: Faire une methode helper pour les messages */
        Session::flash('message', 'Bon de commande envoyé avec succès!');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('purchase_orders.index');
    }
}
