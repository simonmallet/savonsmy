<?php

namespace App\Domain\DTO;

use Carbon\Carbon;

class OrderItemDTO
{
    private int $orderId;
    private int $categoryItemId;
    private int $quantity;

    public function __construct(int $orderId, int $categoryItemId, int $quantity)
    {
        $this->orderId = $orderId;
        $this->categoryItemId = $categoryItemId;
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @return int
     */
    public function getCategoryItemId(): int
    {
        return $this->categoryItemId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
