<?php

namespace Tests\Feature\Console;

use Illuminate\Support\Facades\Storage;
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
        Storage::fake('asset-cdn');
        Storage::disk('asset-cdn')->assertMissing('sitemap.xml');
        $this
            ->artisan('sitemap:generate')
            ->expectsOutput('sitemap:generate : success!')
            ->assertExitCode(0);
        Storage::disk('asset-cdn')->assertExists('sitemap.xml');
    }
}
