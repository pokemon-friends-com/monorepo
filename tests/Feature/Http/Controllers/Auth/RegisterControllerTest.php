<?php namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterControllerTest extends TestCase
{

    use WithoutMiddleware;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIfRegisterIsCorrectlyDisplayed()
    {
        $this
            ->get('/')
            ->assertStatus(200);
    }
}
