<?php

use App\Console\Commands\MarkVaccinated;
use App\Console\Commands\ScheduleAppointments;
use App\Console\Commands\SendScheduledVaccineEmails;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule) {
        // NOTE: everyMinute just for testing; change to hourly for production
        $schedule->command(ScheduleAppointments::class)->everyMinute();
        $schedule->command(SendScheduledVaccineEmails::class)->dailyAt('21:00');
        $schedule->command(MarkVaccinated::class)->dailyAt('20:00');
    })
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
