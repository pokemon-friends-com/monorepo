<?php namespace Tests\Feature\Http\Controllers\Frontend;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AboutControllerTest extends TestCase
{

    public function testTerms()
    {
        $this
            ->get('/terms-of-services')
            ->assertStatus(200);
    }
}
