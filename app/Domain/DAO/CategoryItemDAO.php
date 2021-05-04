<?php

namespace App\Domain\DAO;

use App\Models\CategoryItem;

class CategoryItemDAO
{
    public function getNextAvailableCategoryItemId(): int
    {
        return CategoryItem::max('id') + 1;
    }
}
