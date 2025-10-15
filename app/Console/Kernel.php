<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
{
    $schedule->command('app:subscription-cron')
        ->dailyAt('00:10') // Runs every day at 12 AM
        ->before(function () {
            Log::info('Subscription cron job started at ' . now());
        })
        ->after(function () {
            Log::info('Subscription cron job finished at ' . now());
        });
}


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
