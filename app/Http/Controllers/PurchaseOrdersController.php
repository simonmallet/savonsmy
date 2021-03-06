<?php

namespace App\Http\Controllers;

use App\Constants\OrderStatus;
use App\Domain\BO\OrderBO;
use App\Domain\DAO\OrderDAO;
use App\Domain\DAO\OrderItemDAO;
use App\Domain\DAO\POFormDAO;
use App\Domain\DAO\VersionDAO;
use App\Domain\DTO\OrderDTO;
use App\Domain\DTO\OrderItemDTO;
use App\Domain\Helpers\ClientHelper;
use App\Domain\Helpers\OrderHelper;
use App\Mail\NewPurchaseOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PurchaseOrdersController extends Controller
{
    /** @var POFormDAO */
    private $poFormDAO;

    /** @var VersionDAO */
    private $versionDAO;

    /** @var OrderBO */
    private $orderBO;

    /** @var OrderDAO */
    private $orderDAO;

    /** @var OrderItemDAO */
    private $orderItemDAO;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(POFormDAO $poFormDAO, VersionDAO $versionDAO, OrderBO $orderBO, OrderDAO $orderDAO, OrderItemDAO $orderItemDAO)
    {
        $this->poFormDAO = $poFormDAO;
        $this->versionDAO = $versionDAO;
        $this->orderBO = $orderBO;
        $this->orderDAO = $orderDAO;
        $this->orderItemDAO = $orderItemDAO;
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('purchase_orders.index')->with('historicalPurchaseOrders', $this->orderBO->fetchLatestOrdersForClient(Auth::user()->client[0]));
    }

    public function view($orderId)
    {
        try {
            $order = $this->orderDAO->fetchInfo(ClientHelper::getClientId(), $orderId);
        } catch (\Exception $e) {
            Session::flash('message', "Oops! La commande #{$orderId} n'a pu être retrouvée");
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('purchase_orders.index');
        }

        $orderItems = $this->orderItemDAO->fetchList($orderId);

        $filteredCategories = $this->poFormDAO->getPOFormFromVersion($order->getVersionId())->filter(function ($category) use ($orderItems) {
            /** @var OrderItemDTO $orderItem */
            foreach ($orderItems as $orderItem) {
                foreach ($category->items as $categoryItem) {
                    if ($orderItem->getCategoryItemId() === $categoryItem->id) {
                        return true;
                    }
                }
            }
            return false;
        });

        return view('purchase_orders.view')
            ->with('page_title_arguments', ['orderId' => $orderId, 'createdAt' => $order->getSentAt()])
            ->with('categories', $filteredCategories)
            ->with('order_items', $orderItems)
            ->with('order_sub_total', OrderHelper::calculateOrderSubtotal($filteredCategories, $orderItems, Auth::user()->client[0]->discount_from_retail))
            ->with('user', ['discount_from_retail_price' => Auth::user()->client[0]->discount_from_retail]);
    }

    public function addIndex()
    {
        return view('purchase_orders.add')
            ->with('categories', $this->poFormDAO->getCurrentPOForm())
            ->with('page_title_arguments', ['currentVersionDate' => $this->versionDAO->getCurrentVersionDate()->format('Y-m-d')])
            ->with('user', ['discount_from_retail_price' => Auth::user()->client[0]->discount_from_retail]);
    }

    public function updateIndex($orderId)
    {
        try {
            $order = $this->orderDAO->fetchInfo(ClientHelper::getClientId(), $orderId);
        } catch (\Exception $e) {
            Session::flash('message', "Oops! La commande #{$orderId} n'a pu être retrouvée");
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('purchase_orders.index');
        }

        return view('purchase_orders.update')
            ->with('order_id', $orderId)
            ->with('page_title_arguments', ['orderId' => $orderId])
            ->with('categories', $this->poFormDAO->getPOFormFromVersion($order->getVersionId()))
            ->with('order_items', $this->orderItemDAO->fetchList($orderId))
            ->with('user', ['discount_from_retail_price' => Auth::user()->client[0]->discount_from_retail]);
    }

    public function addSubmit(Request $request)
    {
        $order = new OrderDTO($this->versionDAO->getCurrentVersionId(), ClientHelper::getClientId(), 'abc', OrderStatus::NOT_TREATED, Carbon::now());
        $orderCreated = $this->orderBO->create($order, $request->all());
        Mail::to(config('contact.purchase_orders.new'))->send(new NewPurchaseOrder($orderCreated));

        /** @todo: Faire une methode helper pour les messages */
        Session::flash('message', 'Bon de commande envoyé avec succès!');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('purchase_orders.index');
    }

    public function updateSubmit($orderId, Request $request)
    {
        try {
            $order = $this->orderDAO->fetchInfo(ClientHelper::getClientId(), $orderId);
        } catch (\Exception $e) {
            Session::flash('message', "Oops! La commande #{$orderId} n'a pu être retrouvée");
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('purchase_orders.index');
        }

        $this->orderBO->update($order, $request->all());

        /** @todo: Faire une methode helper pour les messages */
        Session::flash('message', 'Bon de commande mis à jour avec succès!');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('purchase_orders.index');
    }

    public function deleteSubmit($orderId)
    {
        try {
            $order = $this->orderDAO->fetchInfo(ClientHelper::getClientId(), $orderId);
        } catch (\Exception $e) {
            Session::flash('message', "Oops! La commande #{$orderId} n'a pu être retrouvée");
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('purchase_orders.index');
        }

        $this->orderBO->delete($order);

        /** @todo: Faire une methode helper pour les messages */
        Session::flash('message', 'Bon de commande supprimé avec succès!');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('purchase_orders.index');
    }
}
