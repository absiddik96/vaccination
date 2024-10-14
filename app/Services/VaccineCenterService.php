<?php

namespace App\Services;

use App\Enums\CacheKey;
use App\Models\VaccineCenter;
use Illuminate\Support\Facades\Cache;

readonly class VaccineCenterService
{
    public function centers()
    {
        return Cache::remember(CacheKey::VACCINE_CENTERS->value, null, function () {
            return VaccineCenter::all();
        });
    }

    public function centerById($centerId) {
        return $this->centers()->where('id', $centerId)->first();
    }
}