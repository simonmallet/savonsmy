<?php

namespace App\Domain\DAO;

use App\Domain\DTO\OrderDTO;
use App\Domain\DTO\OrderItemDTO;
use App\Models\Order;
use App\Models\OrderItem;

class OrderDAO
{
    public function __construct()
    {

    }

    public function create(OrderDTO $orderDTO): Order
    {
        return Order::create([
            'version_id' => $orderDTO->getVersionId(),
            'client_id' => $orderDTO->getClientId(),
            'external_uid' => $orderDTO->getExternalUid(),
            'status' => $orderDTO->getStatus(),
            'sent_at' => $orderDTO->getSentAt(),
        ]);
    }

    public function fetchList(int $clientId, $orderByDateDirection = 'DESC')
    {
        return Order::where('client_id', $clientId)->orderBy('created_at', $orderByDateDirection)->get();
    }
}
