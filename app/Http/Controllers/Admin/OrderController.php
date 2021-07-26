<?php

namespace App\Http\Controllers\Admin;

use App\Domain\BO\OrderBO;
use App\Domain\DAO\ClientDAO;
use App\Domain\DAO\OrderDAO;
use App\Domain\DAO\OrderItemDAO;
use App\Domain\DAO\POFormDAO;
use App\Domain\DTO\OrderItemDTO;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    private OrderBO $orderBO;
    private OrderDAO $orderDAO;
    private ClientDAO $clientDAO;
    private POFormDAO $poFormDAO;
    private OrderItemDAO $orderItemDAO;

    public function __construct(OrderBO $orderBO, OrderDAO $orderDAO, ClientDAO $clientDAO, POFormDAO $poFormDAO, OrderItemDAO $orderItemDAO)
    {
        $this->orderBO = $orderBO;
        $this->orderDAO = $orderDAO;
        $this->clientDAO = $clientDAO;
        $this->poFormDAO = $poFormDAO;
        $this->orderItemDAO = $orderItemDAO;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($orderId)
    {
        try {
            $order = $this->orderDAO->fetchInfoAdmin($orderId);
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

        return view('admin.orders.view')
            ->with('page_title_arguments', ['orderId' => $orderId])
            ->with('categories', $filteredCategories)
            ->with('order_items', $orderItems)
            ->with('client', $this->clientDAO->fetchInfo($order->getClientId()));
    }
}
