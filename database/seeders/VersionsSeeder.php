<?php

namespace Database\Seeders;

use App\Models\Version;
use Illuminate\Database\Seeder;

class VersionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $versionCount = Version::all();
        if (count($versionCount) === 0) {
            Version::create([]);
        }
    }
}
