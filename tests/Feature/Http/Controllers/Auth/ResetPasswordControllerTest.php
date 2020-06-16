<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\{
    Hash,
    Password
};
use template\Domain\Users\Users\User;

class ResetPasswordControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testToVisitPasswordReset()
    {
        $user = factory(User::class)->create();
        $token = Password::broker()->createToken($user);
        $this
            ->get("/password/reset/{$token}")
            ->assertSuccessful()
            ->assertSeeText('Change your password')
            ->assertSee('Email')
            ->assertSee('Password')
            ->assertSee('Confirm password');
    }

    public function testToSubmitPasswordReset()
    {
        $newPassword = $this->faker->password(8);
        $user = factory(User::class)->state(User::ROLE_CUSTOMER)->create();
        $token = Password::broker()->createToken($user);
        $this
            ->from("/password/reset/{$token}")
            ->post('password/reset', [
                'token' => $token,
                'email' => $user->email,
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
            ])
            ->assertRedirect('/');
        $user->refresh();
        $this->assertFalse(Hash::check($this->getDefaultPassword(), $user->password));
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    public function testToSubmitPasswordResetWithInvalidEmail()
    {
        $newPassword = $this->faker->password(8);
        $user = factory(User::class)->state(User::ROLE_CUSTOMER)->create();
        $token = Password::broker()->createToken($user);
        $this
            ->followingRedirects()
            ->from("/password/reset/{$token}")
            ->post('password/reset', [
                'token' => $token,
                'email' => $this->faker->word,
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
            ])
            ->assertSuccessful()
            ->assertSee('The email must be a valid email address.');
        $user->refresh();
        $this->assertFalse(Hash::check($newPassword, $user->password));
        $this->assertTrue(Hash::check($this->getDefaultPassword(), $user->password));
    }

    public function testToSubmitPasswordResetWithEmailNotFound()
    {
        $newPassword = $this->faker->password(8);
        $user = factory(User::class)->state(User::ROLE_CUSTOMER)->create();
        $token = Password::broker()->createToken($user);
        $this
            ->followingRedirects()
            ->from("/password/reset/{$token}")
            ->post('password/reset', [
                'token' => $token,
                'email' => $this->faker->unique()->safeEmail,
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
            ])
            ->assertSuccessful()
            ->assertSee('We can\'t find a user with that e-mail address.');
        $user->refresh();
        $this->assertFalse(Hash::check($newPassword, $user->password));
        $this->assertTrue(Hash::check($this->getDefaultPassword(), $user->password));
    }

    public function testToSubmitPasswordResetWithPasswordMismatch()
    {
        $newPassword = $this->faker->password(8);
        $user = factory(User::class)->state(User::ROLE_CUSTOMER)->create();
        $token = Password::broker()->createToken($user);
        $this
            ->followingRedirects()
            ->from("/password/reset/{$token}")
            ->post('password/reset', [
                'token' => $token,
                'email' => $user->email,
                'password' => $newPassword,
                'password_confirmation' => $this->faker->password(10),
            ])
            ->assertSuccessful()
            ->assertSee('The password confirmation does not match.');
        $user->refresh();
        $this->assertFalse(Hash::check($newPassword, $user->password));
        $this->assertTrue(Hash::check($this->getDefaultPassword(), $user->password));
    }

    public function testToSubmitPasswordResetWithPasswordTooShort()
    {
        $newPassword = $this->faker->password(3, 7);
        $user = factory(User::class)->state(User::ROLE_CUSTOMER)->create();
        $token = Password::broker()->createToken($user);
        $this
            ->followingRedirects()
            ->from("/password/reset/{$token}")
            ->post('password/reset', [
                'token' => $token,
                'email' => $user->email,
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
            ])
            ->assertSuccessful()
            ->assertSeeText('The password must be at least 8 characters.');
        $user->refresh();
        $this->assertFalse(Hash::check($newPassword, $user->password));
        $this->assertTrue(Hash::check($this->getDefaultPassword(), $user->password));
    }
}
