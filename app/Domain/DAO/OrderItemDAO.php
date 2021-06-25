<?php

namespace App\Domain\DAO;

use App\Domain\DTO\OrderDTO;
use App\Domain\DTO\OrderItemDTO;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Collection;

class OrderItemDAO
{
    public function __construct()
    {

    }

    public function create(array $orderItemDTO)
    {
        /** @var OrderItemDTO $orderItem */
        foreach ($orderItemDTO as $orderItem) {
            OrderItem::create([
                'order_id' => $orderItem->getOrderId(),
                'category_item_id' => $orderItem->getCategoryItemId(),
                'quantity' => $orderItem->getQuantity(),
            ]);
        }
    }

    public function update(OrderItemDTO $orderItemDTO)
    {
        $orderItem = OrderItem::where('order_id', $orderItemDTO->getOrderId())->where('category_item_id', $orderItemDTO->getCategoryItemId())->first();
        if ($orderItem) {
            $orderItem->quantity = $orderItemDTO->getQuantity();
            $orderItem->save();
        } else {
            $this->create([$orderItemDTO]);
        }
    }

    public function delete(int $orderId, int $categoryItemId): void
    {
        OrderItem::where('order_id', $orderId)->where('category_item_id', $categoryItemId)->delete();
    }

    /**
     * @param int $orderId
     * @return Collection|OrderItemDTO[]
     */
    public function fetchList(int $orderId): Collection
    {
        return OrderItem::where('order_id', $orderId)->get()
            ->map(function (OrderItem $item) {
                return new OrderItemDTO($item->order_id, $item->category_item_id, $item->quantity);
            });
    }
}
