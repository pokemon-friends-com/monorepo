<?php

namespace template\Console\Commands;

use template\Infrastructure\Contracts\Commands\CommandAbstract;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LaravelEchoEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return ['my-channel'];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}

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
