<?php namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResetPasswordControllerTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIfResetPasswordIsCorrectlyDisplayed()
    {
        $token = 'e657835054f429b75d6627b9b433fbe18a7a69fa35683b0f15b125c6cb412881';

        $this
            ->get('/password/reset/'.$token)
            ->assertStatus(200);
    }
}
