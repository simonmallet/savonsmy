<?php

namespace App\Domain\DAO;

use App\Domain\DTO\CategoryItemDTO;
use App\Models\CategoryItem;

class CategoryItemDAO
{
    public function getNextAvailableCategoryItemId(): int
    {
        return CategoryItem::max('id') + 1;
    }

    public function create(CategoryItemDTO $categoryItemDTO): CategoryItem
    {
        $categoryItem = new CategoryItem([
            'version_id' => $categoryItemDTO->getVersion(),
            'category_id' => $categoryItemDTO->getCategoryId(),
            'name' => $categoryItemDTO->getName(),
            'description' => $categoryItemDTO->getDescription(),
            'price' => $categoryItemDTO->getPrice(),
            'sku' => $categoryItemDTO->getSku(),
            'enabled' => $categoryItemDTO->isEnabled(),
            'rank' => $categoryItemDTO->getRank(),
        ]);
        $categoryItem->save();

        return $categoryItem;
    }

    public function fetchInfo(int $categoryItemId): CategoryItem
    {
        return CategoryItem::query()->where('id', $categoryItemId)->first();
    }
}
