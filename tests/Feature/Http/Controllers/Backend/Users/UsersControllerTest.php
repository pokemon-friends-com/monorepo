<?php namespace Tests\Feature\Http\Controllers\Backend\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use obsession\Domain\Users\
{
    Users\User,
    Profiles\Profile
};

class UsersControllerTest extends TestCase
{

    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testIndex()
    {
        $administrator = $this->actingAsAdministrator();
        $user = factory(User::class)->create();
        $this
            ->assertAuthenticated()
            ->get('/backend/users')
            ->assertSuccessful()
            ->assertSee($administrator->uniqid)
            ->assertSee($user->uniqid);
    }

    public function testCreate()
    {
        $this->actingAsAdministrator();
        $this
            ->assertAuthenticated()
            ->get('/backend/users/create')
            ->assertSuccessful();
    }

    public function testShow()
    {
        $this->actingAsAdministrator();
        $user = factory(User::class)->create();
        $this
            ->assertAuthenticated()
            ->get('/backend/users/'.$user->id)
            ->assertSuccessful();
    }

    public function testEdit()
    {
        $this->actingAsAdministrator();
        $user = factory(User::class)->create();
        $this
            ->assertAuthenticated()
            ->get('/backend/users/'.$user->id.'/edit')
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
            ->delete('/backend/users/'.$user->id)
            ->assertStatus(302)
            ->assertRedirect('/backend/users');
        $this
            ->assertDatabaseHas('users', ['deleted_at' => null, 'uniqid' => $administrator->uniqid])
            ->assertSoftDeleted('users', ['uniqid' => $user->uniqid]);
    }
}
