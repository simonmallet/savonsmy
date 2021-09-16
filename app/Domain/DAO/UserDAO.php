<?php

namespace App\Domain\DAO;

use App\Models\User;
use Illuminate\Support\Collection;

class UserDAO
{
    public function fetchList(): Collection
    {
        return User::all();
    }

    public function fetchInfo(int $userId): User
    {
        return User::where('id', $userId)->firstOrFail();
    }

    public function assignToClient(User $user, int $clientId): void
    {
        $user->client()->attach($clientId);
    }

    public function approve(User $user)
    {
        $user->partner_approved = 1;
        $user->assignRole(User::ROLE_PARTNER);
        $user->save();
    }

    public function suspend(User $user)
    {
        $user->partner_approved = 0;
        $user->removeRole(User::ROLE_PARTNER);
        $user->save();
    }
}
