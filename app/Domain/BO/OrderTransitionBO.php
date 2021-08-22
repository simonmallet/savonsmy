<?php

namespace App\Domain\BO;

use App\Constants\OrderStatus;
use App\Domain\DAO\OrderDAO;
use App\Domain\DTO\OrderDTO;

class OrderTransitionBO
{
    private OrderDAO $orderDAO;

    public function __construct(OrderDAO $orderDAO)
    {
        $this->orderDAO = $orderDAO;
    }

    public function getAvailableTransitions(string $currentStatus): array
    {
        $this->isValidStatus($currentStatus);

        return OrderStatus::TRANSITIONS[$currentStatus];
    }

    public function updateOrderStatus(OrderDTO $orderDTO, string $newStatus)
    {
        $this->isValidStatus($newStatus);

        $this->orderDAO->updateStatus($orderDTO, $newStatus);
    }

    private function isValidStatus(string $status)
    {
        if (!in_array($status, OrderStatus::STATUSES)) {
            throw new \InvalidArgumentException($status . ' is not a valid status');
        }
        return true;
    }
}
