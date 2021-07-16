<?php

namespace App\Domain\BO;

use App\Constants\OrderStatus;
use App\Domain\DAO\ClientDAO;
use App\Domain\DAO\OrderDAO;
use App\Domain\DAO\OrderItemDAO;
use App\Domain\DTO\OrderDTO;
use App\Domain\DTO\OrderItemDTO;
use App\Models\Client;

class OrderBO
{
    private OrderDAO $orderDAO;
    private OrderItemDAO $orderItemDAO;
    private ClientDAO $clientDAO;

    public function __construct(OrderDAO $orderDAO, OrderItemDAO $orderItemDAO, ClientDAO $clientDAO)
    {
        $this->orderDAO = $orderDAO;
        $this->orderItemDAO = $orderItemDAO;
        $this->clientDAO = $clientDAO;
    }

    /**
     * @param OrderDTO $orderDTO
     * @param array $orderItemDTO
     */
    public function create(OrderDTO $orderDTO, array $orderItemDTO): void
    {
        $order = $this->orderDAO->create($orderDTO);

        $orderItems = [];
        foreach ($orderItemDTO as $categoryItemId => $quantity) {
            if (is_numeric($categoryItemId) && $quantity && $quantity > 0) {
                $orderItems[] = new OrderItemDTO($order->id, $categoryItemId, $quantity);
            }
        }

        $this->orderItemDAO->create($orderItems);
    }

    public function update(OrderDTO $order, array $orderItemDTO): void
    {
        foreach ($orderItemDTO as $categoryItemId => $quantity) {
            if (is_numeric($categoryItemId) && $quantity && $quantity > 0) {
                $this->orderItemDAO->update(new OrderItemDTO($order->getOrderId(), (int) $categoryItemId, $quantity));
            } else {
                $this->orderItemDAO->delete($order->getOrderId(), (int) $categoryItemId);
            }
        }
    }

    public function delete(OrderDTO $order)
    {
        $this->orderDAO->delete($order);
    }

    public function fetchLatestOrdersForClient(Client $client)
    {
        return $this->orderDAO->fetchList([$client->id]);
    }

    public function fetchLatestOrdersFromAllClients(int $limit = 0, $statusTypes = [OrderStatus::NOT_TREATED, OrderStatus::IN_PROGRESS])
    {
        return $this->orderDAO->fetchList($this->clientDAO->fetchList()->pluck('id')->toArray(), $statusTypes, $limit);
    }
}
