<?php

namespace template\Console\Commands;

use template\Infrastructure\Contracts\Commands\CommandAbstract;
use template\App\Events\LaravelEchoEvent;

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
