<?php

namespace App\Enums;

enum VaccinationStatus: string
{
    case SCHEDULED = 'SCHEDULED';
    case VACCINATED = 'VACCINATED';
    case NOT_SCHEDULED = 'NOT_SCHEDULED';

    public function text(): string
    {
        return match ($this) {
            self::SCHEDULED => __('Scheduled'),
            self::VACCINATED => __('Vaccinated'),
            self::NOT_SCHEDULED => __('Not Scheduled'),
        };
    }
}
