<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientsCount = Client::all();
        if (count($clientsCount) === 0) {
            Client::create([
                'name' => 'Partner Client',
                'email' => 'smallet@gmail.com',
            ]);
        }
    }
}
