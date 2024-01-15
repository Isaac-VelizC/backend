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
        $schedule->command(GenerarRegistrosMensuales::class)->monthlyOn(1, '00:00');
        //$schedule->command('app:generar-registros-mensuales')->dailyAt('10:45');

        //$schedule->command('inspire')->hourly();
        /*$schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');

        $schedule
            ->command('backup:run')->daily()->at('01:00')
            ->onFailure(function () {
                'Fallos al realiza la copia de seguridad';
            })
            ->onSuccess(function () {
                'Copia de seguridad Correcta';
            });*/
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
