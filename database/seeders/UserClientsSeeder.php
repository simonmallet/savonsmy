<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserClient;
use Illuminate\Database\Seeder;

class UserClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userClientsCount = UserClient::all();
        if (count($userClientsCount) === 0) {
            UserClient::create([
                'user_id' => User::where('email', 'partner@mysite.com')->first()->id,
                'client_id' => 1,
            ]);
        }
    }
}
