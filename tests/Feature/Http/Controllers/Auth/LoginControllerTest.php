<?php namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\{
    Login as LoginEvent,
    Logout as LogoutEvent
};
use template\Domain\Users\{
    Users\User,
    Users\Events\UserRefreshSessionEvent
};

class LoginControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function testIfLoginIsCorrectlyDisplayed()
    {
        $this
            ->get('/login')
            ->assertSuccessful();
    }

    /**
     * Submit request to login with a valid administrator User credentials.
     *
     * @return void
     */
    public function testIfLoginCanBeSubmittedWithValidAdministratorUserCredentials()
    {
        $user = factory(User::class)->states(User::ROLE_ADMINISTRATOR)->create();
        Event::fake();
        $this
            ->post('/login', [
                'email' => $user->email,
                'password' => $this->getDefaultPasswordBcrypted(),
            ])
            ->assertStatus(302)
            ->assertRedirect('/');
//        Event::assertDispatched(UserRefreshSessionEvent::class, function ($event) use ($user) {
//            return $event->user->id === $user->id;
//        });
//        Event::assertDispatched(LoginEvent::class, function ($event) use ($user) {
//            return $event->user->id === $user->id;
//        });
    }

    public function testIfLoginCanBeSubmittedWithValidCustomerUserCredentials()
    {
        $user = factory(User::class)->states(User::ROLE_CUSTOMER)->create();
        Event::fake();
        $this
            ->post('/login', [
                'email' => $user->email,
                'password' => $this->getDefaultPasswordBcrypted(),
            ])
            ->assertStatus(302)
            ->assertRedirect('/');
//        Event::assertDispatched(LoginEvent::class, function ($event) use ($user) {
//            return $event->user->id === $user->id;
//        });
//        Event::assertDispatched(UserRefreshSessionEvent::class, function ($event) use ($user) {
//            return $event->user->id === $user->id;
//        });
    }

    public function testIfLoginCanBeSubmittedWithValidAccountantUserCredentials()
    {
        $user = factory(User::class)->states(User::ROLE_ACCOUNTANT)->create();
        Event::fake();
        $this
            ->post('/login', [
                'email' => $user->email,
                'password' => $this->getDefaultPasswordBcrypted(),
            ])
            ->assertStatus(302)
            ->assertRedirect('/');
//        Event::assertDispatched(LoginEvent::class, function ($event) use ($user) {
//            return $event->user->id === $user->id;
//        });
//        Event::assertDispatched(UserRefreshSessionEvent::class, function ($event) use ($user) {
//            return $event->user->id === $user->id;
//        });
    }
}
