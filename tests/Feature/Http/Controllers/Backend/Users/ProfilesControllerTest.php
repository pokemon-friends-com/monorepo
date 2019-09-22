<?php namespace Tests\Feature\Http\Controllers\Backend\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfilesControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function testIndex()
    {
        $this->actingAsAdministrator();
        $this
            ->assertAuthenticated()
            ->get('/backend/users/profile')
            ->assertSuccessful();
    }
}
