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
        \App\Console\Commands\AutocrudProcess::class,
        \App\Console\Commands\AutocrudPresenter::class,
        \App\Console\Commands\AutocrudRole::class,
        \App\Console\Commands\AutocrudSuperAdmin::class,
        \App\Console\Commands\AutocrudModule::class,
        \App\Console\Commands\AutocrudSubmodule::class,
        \App\Console\Commands\AutocrudMigrationUpdate::class,

        \App\Console\Commands\GenerateDefaultWallet::class,
        \App\Console\Commands\GenerateDummyWalletRecord::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
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
