<?php

namespace App\Console;

use App\Console\Commands\GenerarRegistrosMensuales;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\GenerarRegistrosMensuales::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        //$schedule->command('GenerarRegistrosMensuales::class')->monthlyOn(1, '00:00');
        $schedule->command('app:generar-registros-mensuales')->dailyAt('12:00');//->mountly();s
        $schedule->command('backup:run')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
