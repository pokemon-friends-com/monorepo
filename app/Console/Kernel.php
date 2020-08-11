<?php

namespace pkmnfriends\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use pkmnfriends\Console\Commands\{
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
            ->command('crawler:pokemongofriendcodes', ['maximum-crawl' => 30])
            ->hourly()
            ->withoutOverlapping();
        $schedule
            ->command('sitemap:generate')
            ->everyThreeHours()
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
