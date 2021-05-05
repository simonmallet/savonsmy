<?php

namespace App\Domain\DAO;

use App\Domain\DTO\CategoryDTO;
use App\Models\Categorie;

class CategoryDAO
{
    public function getNextAvailableCategoryId(): int
    {
        return Categorie::max('id') + 1;
    }

    public function create(CategoryDTO $categoryDTO): Categorie
    {
        $category = new Categorie([
            'version_id' => $categoryDTO->getVersion(),
            'name' => $categoryDTO->getName(),
            'price' => $categoryDTO->getPrice(),
            'enabled' => $categoryDTO->isEnabled(),
            'rank' => $categoryDTO->getRank(),
        ]);
        $category->save();

        return $category;
    }
}
