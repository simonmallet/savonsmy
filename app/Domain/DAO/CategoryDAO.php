<?php

namespace App\Domain\DAO;

use App\Models\Categorie;

class CategoryDAO
{
    public function getNextAvailableCategoryId(): int
    {
        return Categorie::max('id') + 1;
    }
}
