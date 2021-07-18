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

    public function delete(OrderDTO $order)
    {
        Order::where('id', $order->getOrderId())->delete();
    }

    public function fetchList(array $clientId, array $statusTypes = [], $maxResults = 0, string $orderByDateDirection = 'DESC')
    {
        $query = Order::whereIn('client_id', $clientId)->orderBy('created_at', $orderByDateDirection);

        if (count($statusTypes) > 0) {
            $query->whereIn('status', $statusTypes);
        }

        if ($maxResults > 0) {
            $query->limit($maxResults);
        }

        return $query->get();
    }

    public function fetchInfo(int $clientId, int $orderId): OrderDTO
    {
        $order = Order::where('client_id', $clientId)->where('id', $orderId)->first();

        if (!$order) {
            throw new ModelNotFoundException('Order ' . $orderId . ' was not found for current client');
        }

        return new OrderDTO($order->version_id, $order->client_id, $order->external_uid, $order->status, $order->sent_at, $orderId);
    }

    public function fetchInfoAdmin(int $orderId): OrderDTO
    {
        $order = Order::where('id', $orderId)->first();

        if (!$order) {
            throw new ModelNotFoundException('Order ' . $orderId . ' was not found');
        }

        return new OrderDTO($order->version_id, $order->client_id, $order->external_uid, $order->status, $order->sent_at, $orderId);
    }
}
