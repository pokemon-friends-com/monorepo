<?php

namespace Tests\Feature\Http\Controllers\Customer\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testToVisitDashboardAsCustomer()
    {
        $user = $this->actingAsCustomer();
        $this
            ->assertAuthenticated()
            ->get('/users/dashboard')
            ->assertStatus(200);
    }

    public function testToVisitDashboardAsAnonymous()
    {
        $this
            ->get('/users/dashboard')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }
}
