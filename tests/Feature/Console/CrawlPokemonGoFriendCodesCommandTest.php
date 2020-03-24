<?php

namespace Tests\Feature\Console;

use Illuminate\Support\Facades\Bus;
use template\App\Jobs\RegisterFriendCodeJob;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CrawlPokemonGoFriendCodesCommandTest extends TestCase
{
    use DatabaseMigrations;

    public function testCrawlerPokemonGoFriendCodes()
    {
        Bus::fake();
        $this
            ->artisan('crawler:pokemongofriendcodes', ['--maximum-crawl' => 1])
            ->assertExitCode(0);
        Bus::assertDispatched(RegisterFriendCodeJob::class);
    }
}
