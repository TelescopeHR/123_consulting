<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('course:reminder')->twiceDaily(9, 19)->timezone('America/North_Dakota/Center');
        $schedule->command('course:quarterly-reminder')->twiceDaily(9, 19)->timezone('America/North_Dakota/Center');
        $schedule->command('course:old-reminder')->twiceDaily(9, 19)->timezone('America/North_Dakota/Center');
        $schedule->command('weekly:report')->cron('1 0 * * 6');
        $schedule->command('weekly:report-help')->cron('1 0 * * 6');
        $schedule->command('weekly:completed-course-report')->cron('1 0 * * 6');
        $schedule->command('retrieve:stripe')->everyThreeMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
