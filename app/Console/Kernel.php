<?php

namespace App\Console;

use App\Console\Commands\GetDomainPrices;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $email = config('piggybank.email_to_send_to_on_failure');

        $schedule->command(GetDomainPrices::class)
            ->weeklyOn([2, 5]) // Twice weekly - 2 = Tuesday, 5 = Friday
            ->emailOutputOnFailure($email);
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
