<?php

namespace App\Console\Commands;

use App\Enums\VaccinationStatus;
use App\Models\Appointment;
use Illuminate\Console\Command;
use App\Jobs\SendVaccineScheduleNotificationJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendScheduledVaccineEmails extends Command
{
    protected $signature   = 'send:scheduled-emails';
    protected $description = 'Send vaccine schedule emails to users scheduled for vaccination the next day';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        Appointment::query()
            ->where('scheduled_date', $tomorrow)
            ->where('status', VaccinationStatus::SCHEDULED->value)
            ->with('user:id,name,email')
            ->chunkById(1000, function ($appointments) {
                foreach ($appointments as $key => $appointment) {
                    try {
                        dispatch(new SendVaccineScheduleNotificationJob($appointment))
                            ->delay(now()->addSeconds(4 * $key));
                    } catch (\Exception $e) {
                        Log::error('Failed to schedule appointment for ID ' . $appointment->id . ': ' . $e->getMessage());
                    }
                }
            });

        $this->info('Scheduled emails for users with vaccinations tomorrow have been dispatched.');
    }
}

