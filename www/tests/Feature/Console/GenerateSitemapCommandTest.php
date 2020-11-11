<?php

namespace Tests\Feature\Console;

use Illuminate\Support\Facades\Storage;
use pkmnfriends\Domain\Users\Profiles\Profile;
use pkmnfriends\Domain\Users\Users\User;
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
        Storage::fake('object-storage');
        Storage::cloud()->assertMissing('sitemap.xml');
        $this
            ->artisan('sitemap:generate')
            ->expectsOutput('sitemap:generate : success!')
            ->assertExitCode(0);
        Storage::cloud()->assertExists('sitemap.xml');
    }

    public function testSitemapGenerateOnLocalEnvironment()
    {
        $this->markTestSkipped('need to be fixed');

        factory(User::class)
            ->times(30)
            ->create()
            ->each(function (User $user) {
                factory(Profile::class)->create(['user_id' => $user->id]);
            });
        Storage::fake('object-storage');
        Storage::cloud()->assertMissing('sitemap.xml');
        $this
            ->artisan('sitemap:generate', ['--env' => 'local'])
            ->expectsOutput('sitemap:generate : could not be launched on local environment!')
            ->assertExitCode(1);
        Storage::cloud()->assertMissing('sitemap.xml');
    }
}
