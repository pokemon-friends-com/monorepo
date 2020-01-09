<?php

namespace Tests\Feature\Http\Controllers\Anonymous;

use Tests\OAuthTestCaseTrait;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AboutControllerTest extends TestCase
{
    use OAuthTestCaseTrait;
    use DatabaseMigrations;

    public function testTerms()
    {
        $this
            ->get('/terms-of-services')
            ->assertSuccessful();
    }
}
