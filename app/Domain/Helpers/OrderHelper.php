<?php

namespace App\Domain\Helpers;

class OrderHelper
{
    public static function calculateOrderSubtotal($filteredCategories, $orderItems, int $customerDiscountPercentage): float
    {
        $subTotal = 0;
        foreach ($filteredCategories as $category) {
            foreach ($orderItems as $item) {
                $categoryItem = $category->items->filter(function ($categoryItem) use ($item) {
                    return $categoryItem->id === $item->getCategoryItemId();
                })->first();
                if ($categoryItem) {
                    $subTotal += FormattingHelper::formatPrice($category['price'] * (100 - $customerDiscountPercentage) / 100) * $item->getQuantity();
                }
            }
        }
        return $subTotal;
    }
}
