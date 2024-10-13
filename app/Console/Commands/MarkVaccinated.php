<?php

namespace App\Console\Commands;

use App\Enums\VaccinationStatus;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class MarkVaccinated extends Command
{
    protected $signature = 'mark:vaccinated';
    protected $description = 'Mark all appointments scheduled for today as vaccinated';

    public function handle(): void
    {
        $today = Carbon::today()->toDateString();

        try {
            $updatedCount = Appointment::query()
                ->where('scheduled_date', $today)
                ->where('status', VaccinationStatus::SCHEDULED->value)
                ->update([
                    'status' => VaccinationStatus::VACCINATED->value,
                ]);

            if ($updatedCount > 0) {
                $this->info("Marked $updatedCount appointments as vaccinated for today.");
            } else {
                $this->info("No appointments found for today to mark as vaccinated.");
            }

        } catch (QueryException $e) {
            $this->error("Failed to update appointments: " . $e->getMessage());
            Log::error("Error updating appointments: " . $e->getMessage());
        } catch (\Exception $e) {
            $this->error("An unexpected error occurred: " . $e->getMessage());
            Log::error("Unexpected error: " . $e->getMessage());
        }
    }
}
