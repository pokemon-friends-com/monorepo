<?php namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\{
    Notification
};
use template\Domain\Users\{
    Users\User,
    Users\Notifications\ResetPassword
};

class ForgotPasswordControllerTest extends TestCase
{

	use DatabaseMigrations;

	public function testIfForgotPasswordIsCorrectlyDisplayed()
	{
        $this
            ->get('/password/reset')
            ->assertSuccessful()
            ->assertSee('Change your password')
            ->assertSee('Email')
            ->assertSee('Send');
	}

	public function testIfForgotPasswordCanBeSubmittedWithValidUserEmail()
	{
        $user = factory(User::class)->create();
        Notification::fake();
		$this
			->post('/password/email', ['email' => $user->email])
			->assertStatus(302)
			->assertRedirect('/');
		$user->refresh();
		Notification::assertSentTo($user, ResetPassword::class);
	}

	public function testIfForgotPasswordCanBeSubmittedWithNotValidEmail()
	{
        $email = $this->faker->word(20);
        Notification::fake();
        $this
			->post('/password/email', ['email' => $email])
			->assertStatus(302)
			->assertRedirect('/');
		Notification::assertNotSentTo([], ResetPassword::class);
	}

	public function testIfForgotPasswordCanBeSubmittedWithNotValidUserEmail()
	{
        $email = $this->faker->email;
		Notification::fake();
		$this
			->post('/password/email', ['email' => $email])
			->assertStatus(302)
			->assertRedirect('/')
			->assertSessionHasErrors(['email' => trans('passwords.user')]);
		Notification::assertNotSentTo([], ResetPassword::class);
	}
}
