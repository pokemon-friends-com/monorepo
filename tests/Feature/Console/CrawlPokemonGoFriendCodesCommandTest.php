<?php

namespace Tests\Feature\Console;

use Illuminate\Support\Facades\Bus;
use pkmnfriends\App\Jobs\RegisterFriendCodeJob;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CrawlPokemonGoFriendCodesCommandTest extends TestCase
{
    use DatabaseMigrations;

    public function testCrawlerPokemonGoFriendCodes()
    {
        $this->markTestSkipped('Could not be executed in testing env');

        Bus::fake();
        $this
            ->artisan('crawler:pokemongofriendcodes', ['--maximum-crawl' => 5])
            ->assertExitCode(0);
        Bus::assertDispatched(RegisterFriendCodeJob::class);
    }
}
