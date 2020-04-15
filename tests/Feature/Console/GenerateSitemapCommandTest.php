<?php

namespace Tests\Feature\Console;

use template\Domain\Users\Profiles\Profile;
use template\Domain\Users\Users\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GenerateSitemapCommandTest extends TestCase
{
    use DatabaseMigrations;

    public function testSitemapGenerate()
    {
        factory(User::class)
            ->times(30)
            ->create()
            ->each(function (User $user) {
                factory(Profile::class)->create(['user_id' => $user->id]);
            });
        $this
            ->artisan('sitemap:generate')
            ->expectsOutput('sitemap:generate : success!')
            ->assertExitCode(0);
    }
}
