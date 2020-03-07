<?php namespace Tests\Feature\Http\Controllers\Auth;

use template\Domain\Users\Profiles\Profile;
use template\Domain\Users\Users\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterControllerTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIfRegisterIsCorrectlyDisplayed()
    {
        $this
            ->get('/register')
            ->assertSuccessful();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegistration()
    {
        $this->markTestSkipped('https://github.com/obsession-city/www/issues/40');
        $user = factory(User::class)->states(User::ROLE_CUSTOMER)->make();
        $profile = factory(Profile::class)->make();

        $this
            ->post('/register', $user->toArray() + $profile->toArray() + [
                    'password' => $this->getDefaultPassword(),
                    'password_confirmation' => $this->getDefaultPassword()
                ]
            )
            ->assertStatus(302)
            ->assertRedirect('/dashboard');
    }
}
