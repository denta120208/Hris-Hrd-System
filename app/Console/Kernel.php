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
        \App\Console\Commands\Inspire::class,
//        \App\Console\Commands\cronContract::class,
        \App\Console\Commands\cronCutiBesar::class,
        \App\Console\Commands\cronCutiTahunan::class,
        \App\Console\Commands\cronDeleteCuti::class,
        \App\Console\Commands\Notif_atasan_request::class,
        \App\Console\Commands\Notif_attendancenotvalid::class,
        \App\Console\Commands\cronAppCuti::class,
        \App\Console\Commands\cronDCB::class,
        \App\Console\Commands\cronDCT::class,
        \App\Console\Commands\cronAbsen::class,
        \App\Console\Commands\cronAbsenByDate::class,
        \App\Console\Commands\cronSyncLeaveByDate::class,
        \App\Console\Commands\cronIMPByDate::class,
        \App\Console\Commands\cronAbsenByDateMT::class,
        \App\Console\Commands\cronAbsenAutoSync::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('inspire')
//                 ->hourly();
//        $schedule->command('cronContract')->everyMinute();
        $schedule->command('cronCB')->everyMinute();
    }
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
