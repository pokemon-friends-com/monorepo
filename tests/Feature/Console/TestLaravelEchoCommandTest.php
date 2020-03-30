<?php

namespace Tests\Feature\Console;

use Illuminate\Support\Facades\Event;
use template\App\Events\LaravelEchoEvent;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestLaravelEchoCommandTest extends TestCase
{
    use DatabaseMigrations;

    public function testCrawlerPokemonGoFriendCodes()
    {
        Event::fake();
        $this
            ->artisan('test:laravel-echo')
            ->assertExitCode(0);
        Event::assertDispatched(LaravelEchoEvent::class);
    }
}
