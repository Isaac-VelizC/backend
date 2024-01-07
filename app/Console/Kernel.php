<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
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
