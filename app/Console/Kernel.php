<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array<int, class-string>
     */
    protected $commands = [
        // Register your custom commands here
        \App\Console\Commands\SendDueTaskReminders::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // run daily at 08:00
    $schedule->command('tasks:send-due-reminders')->dailyAt('08:00')->withoutOverlapping();

        // Optional: clean up old jobs / logs
        // $schedule->command('queue:prune-failed')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Loads commands in the Console/Commands directory
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}