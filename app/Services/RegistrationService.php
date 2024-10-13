<?php

namespace App\Services;

use App\Enums\VaccinationStatus;
use App\Http\Requests\Registration\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

readonly class RegistrationService
{
    public function __construct(
        protected VaccineCenterService $vaccineCenterService,
    ) {}

    public function registerUser(RegisterRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = User::query()->create([
                'name'  => $request->input('name'),
                'nid'   => $request->input('nid'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ]);

            $vaccineCenter = $this->vaccineCenterService->centerById($request->input('vaccine_center'));

            $user->appointment()->create([
                'user_id'           => $user->id,
                'vaccine_center_id' => $vaccineCenter->id,
                'dose_number'       => 1,
                'status'            => VaccinationStatus::NOT_SCHEDULED->value,
            ]);

            return $user;
        });
    }

    public function success($nid) {
        return User::query()
            ->where('nid', $nid)
            ->with('appointment')
            ->first();
    }
}