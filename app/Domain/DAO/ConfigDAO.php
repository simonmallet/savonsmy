<?php

namespace App\Domain\DAO;

use App\Models\UserConfig;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ConfigDAO
{
    public function getConfigInfo(string $configName, ?int $userId = null): ?string
    {
        return UserConfig::query()
            ->where('user_id', $userId ? $userId : Auth::user()->getAuthIdentifier())
            ->where('name', $configName)
            ->first()->value;
    }

    public function getConfigList(): Collection
    {
        return UserConfig::query()->where('user_id', Auth::user()->getAuthIdentifier())->get();
    }

    public function initConfig(int $userId): void
    {
        $configs = config('user_config');
        foreach ($configs as $configName => $configValue) {
            UserConfig::create([
                'user_id' => $userId,
                'name' => $configName,
                'value' => $configValue,
            ]);
        }
    }

    public function updateConfig(string $configName, string $configValue): void
    {
        $config = UserConfig::query()
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('name', $configName)->first();

        $config->value = $configValue;
        $config->save();
    }
}
