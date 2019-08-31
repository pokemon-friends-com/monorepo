<?php namespace Tests\Feature\Http\Controllers\Backend;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function testIfIndexDashboardIsCorrectlyDisplayed()
    {
        $this->actingAsAdministrator();

        $this
            ->assertAuthenticated()
            ->get('/backend/dashboard')
            ->assertStatus(200);
    }
}
