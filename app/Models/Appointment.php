<?php

namespace App\Models;

use App\Enums\VaccinationStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vaccine_center_id',
        'dose_number',
        'scheduled_date',
        'status',
    ];

    protected $casts = [
        'status' => VaccinationStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vaccineCenter(): BelongsTo
    {
        return $this->belongsTo(VaccineCenter::class);
    }

    protected function isVaccinated(): Attribute
    {
        return Attribute::make(
            fn() => $this->status === VaccinationStatus::VACCINATED
        );
    }

    protected function isScheduled(): Attribute
    {
        return Attribute::make(
            fn() => $this->status === VaccinationStatus::SCHEDULED
        );
    }
}
