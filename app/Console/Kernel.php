<?php

namespace template\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use template\Console\Commands\{
    GenerateSitemapCommand,
    TestLaravelEchoCommand,
    CrawlPokemonGoFriendCodesCommand,
    VersionCommand,
    DailySponsorshipCommand
};

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CrawlPokemonGoFriendCodesCommand::class,
        DailySponsorshipCommand::class,
        GenerateSitemapCommand::class,
        TestLaravelEchoCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->command('sitemap:generate')
            ->everyFiveMinutes()
            ->withoutOverlapping();
        $schedule
            ->command('pkmn:daily-sponsor')
            ->daily()
            ->withoutOverlapping();
        $schedule
            ->command('cashier:run')
            ->daily()
            ->withoutOverlapping();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        if (!$this->app->environment('production')) {
            $this->registerCommand(new VersionCommand());
        }

        require base_path('routes/console.php');
    }
}
