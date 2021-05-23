<?php

namespace App\Domain\DAO;

use App\Domain\DTO\OrderDTO;
use App\Domain\DTO\OrderItemDTO;
use App\Models\Order;
use App\Models\OrderItem;

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
}
