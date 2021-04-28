<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Version;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoriesCount = Categorie::all();
        if (count($categoriesCount) === 0) {
            Categorie::create([
                'version_id' => Version::first()->id,
                'name' => 'Test Savon A',
                'price' => 6.49,
                'rank' => 1,
            ]);

            Categorie::create([
                'version_id' => Version::first()->id,
                'name' => 'Test Savon B',
                'price' => 8.99,
                'rank' => 2,
            ]);
        }
    }
}
