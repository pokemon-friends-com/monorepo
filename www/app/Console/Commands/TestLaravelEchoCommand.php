<?php

namespace pkmnfriends\Console\Commands;

use pkmnfriends\Infrastructure\Contracts\Commands\CommandAbstract;
use pkmnfriends\App\Events\LaravelEchoEvent;

class TestLaravelEchoCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'test:laravel-echo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test laravel echo.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        event(new LaravelEchoEvent('hello world'));

        return 0;
    }
}
