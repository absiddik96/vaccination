<?php

namespace Database\Factories;

use App\Enums\VaccinationStatus;
use App\Models\Appointment;
use App\Models\User;
use App\Models\VaccineCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'vaccine_center_id' => VaccineCenter::factory(),
            'dose_number' => $this->faker->randomElement([1, 2]),
            'scheduled_date' => now()->addDays(rand(1, 30))->toDateString(),
            'status' => VaccinationStatus::VACCINATED->value,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
