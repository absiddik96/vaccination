<?php

namespace App\Http\Controllers;

use App\Http\Requests\Registration\RegisterRequest;
use App\Services\RegistrationService;
use App\Services\VaccineCenterService;

class RegistrationController extends Controller
{
    public function __construct(
        protected readonly RegistrationService  $registrationService,
        protected readonly VaccineCenterService $vaccineCenterService
    ) {}

    public function showRegistrationForm()
    {
        return view('registration.register')->with([
            'vaccineCenters' => $this->vaccineCenterService->centers()
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->registrationService->registerUser($request);

        return redirect()->route('registration.success', $user->nid);
    }

    public function success($nid)
    {
        $userWithAppointment = $this->registrationService->success($nid);

        if (!$userWithAppointment) {
            return redirect()->route('registration.show-form');
        }

        return view('registration.success')->with([
            'user' => $userWithAppointment
        ]);
    }
}
