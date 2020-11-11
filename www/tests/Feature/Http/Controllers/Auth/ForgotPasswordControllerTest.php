<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Notifications\AnonymousNotifiable;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\{
    Notification
};
use pkmnfriends\Domain\Users\Users\{
    User,
    Notifications\ResetPassword
};

class ForgotPasswordControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testToVisitForgotPassword()
    {
        $this
            ->get('/password/reset')
            ->assertSuccessful()
            ->assertSeeText('Change your password')
            ->assertSee('Email')
            ->assertSeeText('Send');
    }

    public function testToSubmitForgotPasswordWithValidUserEmail()
    {
        $user = factory(User::class)->create();
        Notification::fake();
        $this
            ->from('/password/reset')
            ->post('/password/email', ['email' => $user->email])
            ->assertStatus(302)
            ->assertRedirect('/password/reset');
        $user->refresh();
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function testToSubmitForgotPasswordWithNotValidEmail()
    {
        $email = $this->faker->word(20);
        Notification::fake();
        $this
            ->from('/password/reset')
            ->post('/password/email', ['email' => $email])
            ->assertStatus(302)
            ->assertRedirect('/password/reset');
        Notification::assertNotSentTo(new AnonymousNotifiable(), ResetPassword::class);
    }

    public function testToSubmitForgotPasswordWithNotValidUserEmail()
    {
        $email = $this->faker->email;
        Notification::fake();
        $this
            ->from('/password/reset')
            ->post('/password/email', ['email' => $email])
            ->assertStatus(302)
            ->assertRedirect('/password/reset')
            ->assertSessionHasErrors(['email' => 'We can\'t find a user with that e-mail address.']);
        Notification::assertNotSentTo(new AnonymousNotifiable(), ResetPassword::class);
    }
}
