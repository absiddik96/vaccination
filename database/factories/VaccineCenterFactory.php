<?php

namespace Database\Factories;

use App\Models\VaccineCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

class VaccineCenterFactory extends Factory
{
    protected $model = VaccineCenter::class;

    public function definition(): array
    {
        return [
            'name'        => $this->faker->sentence(3),
            'daily_limit' => $this->faker->randomElement([100, 150, 200]),
        ];
    }
}
