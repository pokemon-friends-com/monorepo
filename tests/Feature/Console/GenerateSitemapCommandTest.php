<?php

namespace Tests\Feature\Console;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GenerateSitemapCommandTest extends TestCase
{
    use DatabaseMigrations;

    public function testSitemapGenerate()
    {
        $this
            ->artisan('sitemap:generate')
            ->expectsOutput('sitemap:generate : success!')
            ->assertExitCode(0);
    }
}
