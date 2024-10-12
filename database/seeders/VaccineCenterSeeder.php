<?php

namespace Database\Seeders;

use App\Enums\CacheKey;
use App\Models\VaccineCenter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class VaccineCenterSeeder extends Seeder
{
    public function run(): Collection|Model
    {
        $vaccineCenters = VaccineCenter::factory()->count(25)->create();
        Cache::set(CacheKey::VACCINE_CENTERS->value, VaccineCenter::all());
        return $vaccineCenters;
    }
}
