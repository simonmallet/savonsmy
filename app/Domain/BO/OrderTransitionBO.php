<?php

namespace App\Domain\BO;

use App\Constants\OrderStatus;
use App\Domain\DAO\ClientDAO;
use App\Domain\DAO\OrderDAO;
use App\Domain\DTO\OrderDTO;
use App\Mail\NewPurchaseOrder;
use App\Mail\OrderStatusChange;
use Illuminate\Support\Facades\Mail;

class OrderTransitionBO
{
    private OrderDAO $orderDAO;
    private ClientDAO $clientDAO;

    public function __construct(OrderDAO $orderDAO, ClientDAO $clientDAO)
    {
        $this->orderDAO = $orderDAO;
        $this->clientDAO = $clientDAO;
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

        foreach ($this->clientDAO->fetchInfo($orderDTO->getClientId())->users as $user) {
            Mail::to($user->email)->send(new OrderStatusChange($orderDTO, $user->name, $newStatus));
        }
    }

    private function isValidStatus(string $status)
    {
        if (!in_array($status, OrderStatus::STATUSES)) {
            throw new \InvalidArgumentException($status . ' is not a valid status');
        }
        return true;
    }
}
