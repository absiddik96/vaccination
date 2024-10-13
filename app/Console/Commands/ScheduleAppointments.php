<?php

namespace App\Console\Commands;

use App\Enums\VaccinationStatus;
use App\Models\Appointment;
use App\Models\VaccineCenter;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ScheduleAppointments extends Command
{
    protected $signature   = 'appointments:schedule';
    protected $description = 'Schedule pending appointments';

    public function handle(): void
    {
        $this->info('Scheduling pending appointments...');
        try {
            $vaccineCenters = VaccineCenter::all()->keyBy('id');

            Appointment::query()
                ->where('status', VaccinationStatus::NOT_SCHEDULED->value)
                ->orderBy('created_at')
                ->chunkById(1000, function ($appointments) use ($vaccineCenters) {
                    foreach ($appointments as $appointment) {
                        try {
                            $vaccineCenter = $vaccineCenters->get($appointment->vaccine_center_id);

                            if ($vaccineCenter) {
                                $nextAvailableDate = $this->getNextAvailableDate($vaccineCenter);
                                $appointment->update([
                                    'scheduled_date' => $nextAvailableDate,
                                    'status' => VaccinationStatus::SCHEDULED->value
                                ]);
                            }
                        } catch (\Exception $e) {
                            Log::error('Failed to schedule appointment for ID ' . $appointment->id . ': ' . $e->getMessage());
                        }
                    }
                });
        } catch (\Exception $e) {
            Log::error('Error scheduling appointments: ' . $e->getMessage());
        }
    }

    private function getNextAvailableDate(VaccineCenter $vaccineCenter): string
    {
        $scheduleDate = Carbon::tomorrow();
        $cacheKey = 'last_schedule_' . $vaccineCenter->id;
        $cacheTTL = 3600;

        $lastSchedule = Cache::remember($cacheKey, $cacheTTL, function () use ($vaccineCenter, $scheduleDate) {
            $data = Appointment::query()
                ->where('vaccine_center_id', $vaccineCenter->id)
                ->whereDate('scheduled_date', '>=', $scheduleDate)
                ->select('scheduled_date')
                ->selectRaw('COUNT(id) as appointment_count')
                ->groupBy('scheduled_date')
                ->orderByDesc('scheduled_date')
                ->limit(1)
                ->first();

            return $data ? (object) $data->toArray() : null;
        });

        if ($lastSchedule) {
            $scheduleDate = Carbon::parse($lastSchedule->scheduled_date);

            if ($lastSchedule->appointment_count >= $vaccineCenter->daily_limit) {
                $scheduleDate->addDay();
            }
        }

        if ($scheduleDate->isFriday() || $scheduleDate->isSaturday()) {
            $scheduleDate = $scheduleDate->next(CarbonInterface::SUNDAY);
        }

        if ($lastSchedule && $lastSchedule->scheduled_date === $scheduleDate->toDateString()) {
            $lastSchedule->appointment_count++;
            Cache::put($cacheKey, $lastSchedule, $cacheTTL);
        } else {
            Cache::put($cacheKey, (object) [
                'scheduled_date' => $scheduleDate->toDateString(),
                'appointment_count' => 1
            ], $cacheTTL);
        }

        return $scheduleDate->toDateString();
    }
}
