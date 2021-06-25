<?php

namespace App\Domain\DAO;

use App\Domain\DTO\OrderDTO;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function fetchInfo(int $clientId, int $orderId): OrderDTO
    {
        $order = Order::where('client_id', $clientId)->where('id', $orderId)->first();

        if (!$order) {
            throw new ModelNotFoundException('Order ' . $orderId . ' was not found for current client');
        }

        return new OrderDTO($order->version_id, $order->client_id, $order->external_uid, $order->status, $order->sent_at, $orderId);
    }
}
