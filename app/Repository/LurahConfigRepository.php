<?php

namespace App\Repository;

use App\Models\LurahConfig;
use Illuminate\Support\Facades\Storage;

class LurahConfigRepository
{
    public function get(): ?LurahConfig
    {
        return LurahConfig::first();
    }

    public function create(array $data): LurahConfig
    {
        return LurahConfig::create($data);
    }

    public function update(array $data): LurahConfig
    {
        $config = LurahConfig::first();
        $config->update($data);
        return $config->fresh();
    }
}