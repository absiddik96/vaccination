<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegistrationController::class, 'register'])->name('registration.register')->middleware('throttle:50,1');

Route::group(['middleware' => 'throttle:100,1'], function () {
    Route::get('/', [RegistrationController::class, 'showRegistrationForm'])->name('registration.show-form');
    Route::get('/success/{nid}', [RegistrationController::class, 'success'])->name('registration.success');

    Route::get('/status', [StatusController::class, 'statusCheck'])->name('status.check');
});

