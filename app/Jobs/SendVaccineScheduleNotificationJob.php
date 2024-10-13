<?php

namespace App\Jobs;

use App\Mail\VaccineScheduleNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVaccineScheduleNotificationJob implements ShouldQueue
{
    use Queueable;

    public function __construct(protected $appointment) {}

    public function handle(): void
    {
        Mail::to($this->appointment->user->email)
            ->send(new VaccineScheduleNotification(
                $this->appointment->user,
                $this->appointment->scheduled_date
            ));
    }
}

