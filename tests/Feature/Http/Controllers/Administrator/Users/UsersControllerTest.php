<?php

namespace Tests\Feature\Http\Controllers\Administrator\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use template\Domain\Users\
{
    Users\User,
    Profiles\Profile
};

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testToVisitDashboardAsAdministrator()
    {
        $this->actingAsAdministrator();
        $this
            ->assertAuthenticated()
            ->get('/administrator/users/dashboard')
            ->assertSeeText('Dashboard')
            ->assertSuccessful();
    }

    public function testToVisitDashboardAsAnonymous()
    {
        $this
            ->get('/administrator/users/dashboard')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function testIndex()
    {
        $administrator = $this->actingAsAdministrator();
        $user = factory(User::class)->create();
        $this
            ->assertAuthenticated()
            ->get('/administrator/users')
            ->assertSuccessful()
            ->assertSee($administrator->uniqid)
            ->assertSee($user->uniqid);
    }

    public function testCreate()
    {
        $this->actingAsAdministrator();
        $this
            ->assertAuthenticated()
            ->get('/administrator/users/create')
            ->assertSuccessful();
    }

    public function testShow()
    {
        $this->actingAsAdministrator();
        $user = factory(User::class)->create();
        $this
            ->assertAuthenticated()
            ->get("/administrator/users/{$user->uniqid}")
            ->assertSuccessful();
    }

    public function testEdit()
    {
        $this->actingAsAdministrator();
        $user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $user->id]);
        $this
            ->assertAuthenticated()
            ->get("/administrator/users/{$user->uniqid}/edit")
            ->assertSuccessful();
    }

    public function testDestroy()
    {
        $administrator = $this->actingAsAdministrator();
        $user = factory(User::class)->create();
        $this
            ->assertDatabaseHas('users', ['deleted_at' => null, 'uniqid' => $administrator->uniqid])
            ->assertDatabaseHas('users', ['deleted_at' => null, 'uniqid' => $user->uniqid]);
        $this
            ->assertAuthenticated()
            ->delete("/administrator/users/{$user->uniqid}")
            ->assertStatus(302)
            ->assertRedirect('/administrator/users');
        $this
            ->assertDatabaseHas('users', ['deleted_at' => null, 'uniqid' => $administrator->uniqid])
            ->assertSoftDeleted('users', ['uniqid' => $user->uniqid]);
    }
}
