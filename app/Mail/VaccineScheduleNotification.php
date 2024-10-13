<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VaccineScheduleNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $vaccinationDate;

    public function __construct($user, $vaccinationDate)
    {
        $this->user = $user;
        $this->vaccinationDate = $vaccinationDate;
    }

    public function build(): VaccineScheduleNotification
    {
        return $this->view('emails.vaccine_schedule')
            ->subject('COVID-19 Vaccination Schedule Notification')
            ->with([
                'name' => $this->user->name,
                'date' => $this->vaccinationDate,
            ]);
    }
}
