<?php

namespace template\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use template\Console\Commands\{
    GenerateSitemapCommand,
    GetFileFromAwsCommand,
    PushFileToAwsCommand,
    RemoveFileOnAwsCommand,
    TestLaravelEchoCommand,
    CrawlPokemonGoFriendCodesCommand
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
        GenerateSitemapCommand::class,
        GetFileFromAwsCommand::class,
        PushFileToAwsCommand::class,
        RemoveFileOnAwsCommand::class,
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
            ->command('queue:work', [
                '--sleep' => 3,
                '--tries' => 3,
            ])
            ->everyMinute()
            ->withoutOverlapping();
        $schedule
            ->command('sitemap:generate')
            ->everyFiveMinutes()
            ->withoutOverlapping();
        $schedule
            ->command('crawler:pokemongofriendcodes')
            ->monthly()
            ->withoutOverlapping();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
