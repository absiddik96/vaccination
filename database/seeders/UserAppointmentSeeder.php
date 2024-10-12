<?php

namespace Database\Seeders;

use App\Enums\VaccinationStatus;
use App\Models\Appointment;
use App\Models\User;
use App\Models\VaccineCenter;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserAppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(VaccineCenterSeeder::class);
        $vaccineCenters = VaccineCenter::query()->latest()->take(25)->get();

        foreach ($vaccineCenters as $vaccineCenter) {
            $users = [];
            $users = User::factory()->count(1000)->create();

            foreach ($users->chunk(100) as $batchUsers) {
                $appointments = [];

                foreach ($batchUsers as $key => $user)  {
                    $appointments[] = [
                        'user_id'           => $user->id,
                        'vaccine_center_id' => $vaccineCenter->id,
                        'dose_number'       => 1,
                        'scheduled_date'     => $this->nextScheduleDate($vaccineCenter->daily_limit, $key),
                        'status'            => VaccinationStatus::VACCINATED->value,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ];
                }

                Appointment::query()->insert($appointments);
                $batchUsers = [];
            }
        }
    }

    private function nextScheduleDate(int $dailyLimit, int $userKey): string
    {
        $addDays = (int) (($userKey + 1) / $dailyLimit);
        $scheduleDate = Carbon::parse('2024-07-01')->addDays($addDays);

        if ($scheduleDate->isFriday()) {
            $scheduleDate->addDays(2);
        } else if ($scheduleDate->isSaturday()) {
            $scheduleDate->addDay();
        }

        return $scheduleDate->toDateString();
    }
}
