<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\CategoryItem;
use App\Models\Version;
use Illuminate\Database\Seeder;

class CategoryItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryItems = CategoryItem::all();
        if (count($categoryItems) === 0) {
            CategoryItem::create([
                'version_id' => Version::first()->id,
                'category_id' => Categorie::first()->id,
                'name' => 'Test Melon A',
                'description' => 'Beau test de melon!',
                'sku' => '1452',
                'rank' => 1,
            ]);

            CategoryItem::create([
                'version_id' => Version::first()->id,
                'category_id' => Categorie::first()->id,
                'name' => 'Test Melon B',
                'description' => 'Beau test de melon 222!',
                'sku' => '1332',
                'rank' => 2,
            ]);

            CategoryItem::create([
                'version_id' => Version::first()->id,
                'category_id' => 2,
                'name' => 'Test Jus A',
                'description' => 'Ca cest du jus!',
                'sku' => '1001',
                'rank' => 1,
            ]);
        }
    }
}
