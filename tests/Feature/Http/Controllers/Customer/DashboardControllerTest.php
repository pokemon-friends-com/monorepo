<?php namespace Tests\Feature\Http\Controllers\Customer;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function testToVisitDashboardAsCustomer()
    {
        $this->actingAsCustomer();
        $this
            ->assertAuthenticated()
            ->get('/dashboard')
            ->assertStatus(503);
    }

    public function testToVisitDashboardAsAnonymous()
    {
        $this
            ->get('/dashboard')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }
}
