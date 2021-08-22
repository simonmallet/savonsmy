<?php

namespace App\Http\Controllers\Admin;

use App\Domain\BO\OrderBO;
use App\Domain\BO\OrderTransitionBO;
use App\Domain\DAO\ClientDAO;
use App\Domain\DAO\OrderDAO;
use App\Domain\DAO\OrderItemDAO;
use App\Domain\DAO\POFormDAO;
use App\Domain\DTO\OrderItemDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    private OrderBO $orderBO;
    private OrderDAO $orderDAO;
    private ClientDAO $clientDAO;
    private POFormDAO $poFormDAO;
    private OrderItemDAO $orderItemDAO;
    private OrderTransitionBO $orderTransitionBO;

    public function __construct(OrderBO $orderBO, OrderDAO $orderDAO, ClientDAO $clientDAO, POFormDAO $poFormDAO, OrderItemDAO $orderItemDAO, OrderTransitionBO $orderTransitionBO)
    {
        $this->orderBO = $orderBO;
        $this->orderDAO = $orderDAO;
        $this->clientDAO = $clientDAO;
        $this->poFormDAO = $poFormDAO;
        $this->orderItemDAO = $orderItemDAO;
        $this->orderTransitionBO = $orderTransitionBO;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($orderId)
    {
        $order = $this->getOrder($orderId);

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexStatus($orderId)
    {
        $order = $this->getOrder($orderId);

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

        return view('admin.orders.status')
            ->with('orderId', $orderId)
            ->with('page_title_arguments', ['orderId' => $orderId])
            ->with('status', $order->getStatus())
            ->with('available_transitions', $this->orderTransitionBO->getAvailableTransitions($order->getStatus()))
            ->with('categories', $filteredCategories)
            ->with('order_items', $orderItems)
            ->with('client', $this->clientDAO->fetchInfo($order->getClientId()));
    }

    public function statusSubmit(Request $request, int $orderId)
    {
        $order = $this->getOrder($orderId);

        try {
            $this->orderTransitionBO->updateOrderStatus($order, $request->input('update_status'));
        } catch (\Exception $e) {
            Session::flash('message', "Une erreur est survenue: " . $e->getMessage());

            return redirect()->route('admin.dashboard');
        }

        /** @todo: Faire une methode helper pour les messages */
        Session::flash('status', 'Commande mise à jour avec succès!');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('admin.dashboard');
    }

    private function getOrder(int $orderId)
    {
        try {
            return $this->orderDAO->fetchInfoAdmin($orderId);
        } catch (\Exception $e) {
            Session::flash('status', "Oops! La commande #{$orderId} n'a pu être retrouvée");
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('admin.dashboard');
        }
    }
}
