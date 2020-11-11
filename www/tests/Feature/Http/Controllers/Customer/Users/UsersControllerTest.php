<?php

namespace Tests\Feature\Http\Controllers\Customer\Users;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Laravel\Socialite\Contracts\Provider as SocialiteProvider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\One\User as SocialiteOAuthOneUser;
use pkmnfriends\Domain\Users\ProvidersTokens\ProviderToken;
use pkmnfriends\Domain\Users\Users\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Yaquawa\Laravel\EmailReset\Notifications\EmailResetNotification;

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testToVisitDashboardAsAnonymous()
    {
        $this
            ->get('/users/dashboard')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function testToVisitDashboardAsCustomer()
    {
        $this->actingAsCustomer();
        $this
            ->assertAuthenticated()
            ->get('/users/dashboard')
            ->assertStatus(200)
            ->assertSeeText('Dashboard');
    }

    public function testToVisitAnonymousDashboardAsCustomer()
    {
        $this->actingAsCustomer();
        $this
            ->assertAuthenticated()
            ->get('/')
            ->assertStatus(302)
            ->assertRedirect('/users/dashboard');
    }

    public function testToSubmitUpdatePassword()
    {
        $newPassword = $this->faker->password(8);
        $user = $this->actingAsCustomer();
        $this
            ->assertAuthenticated()
            ->from("/users/{$user->uniqid}/edit")
            ->put("/users/password/{$user->uniqid}", [
                'password_current' => $this->getDefaultPassword(),
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
            ])
            ->assertRedirect("/users/{$user->uniqid}/edit");
        $user->refresh();
        $this->assertFalse(Hash::check($this->getDefaultPassword(), $user->password));
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    public function testToSubmitUpdatePasswordWithEmptyForm()
    {
        $user = $this->actingAsCustomer();
        $this
            ->assertAuthenticated()
            ->followingRedirects()
            ->from("/users/{$user->uniqid}/edit")
            ->put("/users/password/{$user->uniqid}", [
                'password_current' => null,
                'password' => null,
                'password_confirmation' => null,
            ])
            ->assertSuccessful()
            ->assertSeeText('The current password field is required.')
            ->assertSeeText('The password field is required.');
        $user->refresh();
        $this->assertNotNull($user->password);
        $this->assertFalse(Hash::check(null, $user->password));
    }

    public function testToSubmitUpdatePasswordWithInvalidCurrentPassword()
    {
        $newPassword = $this->faker->password(8);
        $user = $this->actingAsCustomer();
        $this
            ->assertAuthenticated()
            ->followingRedirects()
            ->from("/users/{$user->uniqid}/edit")
            ->put("/users/password/{$user->uniqid}", [
                'password_current' => $this->faker->word,
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
            ])
            ->assertSuccessful()
            ->assertSeeText('The password entered is not your password.');
        $user->refresh();
        $this->assertNotNull($user->password);
        $this->assertFalse(Hash::check(null, $user->password));
    }

    public function testToSubmitUpdatePasswordWithPasswordMismatch()
    {
        $newPassword = $this->faker->password(8);
        $user = $this->actingAsCustomer();
        $this
            ->assertAuthenticated()
            ->followingRedirects()
            ->from("/users/{$user->uniqid}/edit")
            ->put("/users/password/{$user->uniqid}", [
                'password_current' => $this->getDefaultPassword(),
                'password' => $newPassword,
                'password_confirmation' => $this->faker->password(10),
            ])
            ->assertSuccessful()
            ->assertSeeText('The password confirmation does not match.');
        $user->refresh();
        $this->assertNotNull($user->password);
        $this->assertFalse(Hash::check(null, $user->password));
    }

    public function testToSubmitUpdatePasswordWithPasswordTooShort()
    {
        $newPassword = $this->faker->password(3, 7);
        $user = $this->actingAsCustomer();
        $this
            ->assertAuthenticated()
            ->followingRedirects()
            ->from("/users/{$user->uniqid}/edit")
            ->put("/users/password/{$user->uniqid}", [
                'password_current' => $this->getDefaultPassword(),
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
            ])
            ->assertSuccessful()
            ->assertSeeText('The password must be at least 8 characters.');
        $user->refresh();
        $this->assertFalse(Hash::check($newPassword, $user->password));
        $this->assertTrue(Hash::check($this->getDefaultPassword(), $user->password));
    }

    public function testToSubmitUpdateProfile()
    {
        $user = $this->actingAsCustomer();
        $this
            ->assertAuthenticated()
            ->from("/users/{$user->uniqid}/edit")
            ->put("/users/{$user->uniqid}", [
                'friend_code' => $user->profile->friend_code,
                'team_color' => $user->profile->team_color,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'civility' => $user->civility,
                'timezone' => $user->timezone,
                'locale' => $user->locale,
            ])
            ->assertRedirect("/users/{$user->uniqid}/edit");
    }

    public function testToSubmitUpdateEmail()
    {
        $this->markTestSkipped('error in vendor');

        $newEmail = $this->faker->email;
        $user = $this->actingAsCustomer();
        Notification::fake();
        $this
            ->assertAuthenticated()
            ->from("/users/{$user->uniqid}/edit")
            ->post("/users/email/{$user->uniqid}", [
                'email' => $newEmail,
            ])
            ->assertRedirect("/users/{$user->uniqid}/edit");
        $user->refresh();
        $this->assertDatabaseHas('email_resets', [
            'new_email' => $newEmail,
        ]);
        Notification::assertSentTo($user, EmailResetNotification::class);
    }
}
