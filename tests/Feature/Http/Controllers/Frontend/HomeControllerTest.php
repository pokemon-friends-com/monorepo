<?php namespace Tests\Feature\Http\Controllers\Frontend;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeControllerTest extends TestCase
{

    public function testIndex()
    {
        $this
            ->get('/')
            ->assertSuccessful();
    }
}
