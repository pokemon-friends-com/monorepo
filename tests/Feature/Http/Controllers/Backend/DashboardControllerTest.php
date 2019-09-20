<?php namespace Tests\Feature\Http\Controllers\Backend;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function testToVisitDashboardAsAdministrator()
    {
        $this->actingAsAdministrator();
        $this
            ->assertAuthenticated()
            ->get('/backend/dashboard')
            ->assertStatus(200);
    }

    public function testToVisitDashboardAsAnonymous()
    {
        $this
            ->get('/backend/dashboard')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }
}
