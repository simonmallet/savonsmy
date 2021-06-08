<?php

namespace App\Domain\BO;

use App\Domain\DAO\OrderDAO;
use App\Domain\DAO\OrderItemDAO;
use App\Domain\DTO\OrderDTO;
use App\Domain\DTO\OrderItemDTO;
use App\Models\Client;
use App\Models\User;

class OrderBO
{
    private OrderDAO $orderDAO;
    private OrderItemDAO $orderItemDAO;

    public function __construct(OrderDAO $orderDAO, OrderItemDAO $orderItemDAO)
    {
        $this->orderDAO = $orderDAO;
        $this->orderItemDAO = $orderItemDAO;
    }

    /**
     * @param OrderDTO $orderDTO
     * @param array $orderItemDTO
     */
    public function create(OrderDTO $orderDTO, array $orderItemDTO)
    {
        $order = $this->orderDAO->create($orderDTO);

        $orderItems = [];
        foreach ($orderItemDTO as $categoryItemId => $quantity) {
            if (is_numeric($categoryItemId) && $quantity && $quantity > 0) {
                $orderItems[] = new OrderItemDTO($order->id, $categoryItemId, $quantity ?? 0);
            }
        }

        $this->orderItemDAO->create($orderItems);
    }

    public function fetchLatestOrdersForClient(Client $client)
    {
        return $this->orderDAO->fetchList($client->id);
    }
}
