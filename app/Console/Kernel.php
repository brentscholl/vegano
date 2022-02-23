<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('vegano:order-this-weeks-boxes')->weeklyOn(4, '0:00'); // Every thursday at 12:00am | Order the boxes for next sunday
        $schedule->command('vegano:open-next-weeks-boxes')->weeklyOn(4, '0:00'); // Every thursday at 12:00am | Create the boxes for 5 weeks from now
        $schedule->command('vegano:set-skipped-users')->weeklyOn(3, '0:00'); // Every wednesday at 12:00am | Swap the users subscription if they skipped next sundays box before they get charged tomorrow
        $schedule->command('vegano:remind-users-about-box')->weeklyOn(2, '9:00'); // Every tuesday at 9:00am | Remind users their box will be ordered tomorrow
        $schedule->command('vegano:check-user-subscription-date')->weeklyOn(5, '0:00'); // Every Friday at 12:00am | Swap free subscriptions for paid if time is up
        $schedule->command('sitemap:generate')->monthly(0, '0:00'); // Every Sunday at 12:00am | Update the sitemap
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
