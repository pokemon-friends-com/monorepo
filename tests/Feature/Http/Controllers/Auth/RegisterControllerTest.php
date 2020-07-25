<?php

namespace Tests\Feature\Http\Controllers\Auth;

use pkmnfriends\Domain\Users\Profiles\Profile;
use pkmnfriends\Domain\Users\Users\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testToVisitRegister()
    {
        $this
            ->get('/register')
            ->assertSuccessful()
            ->assertSeeText('Registration Form')
            ->assertSee('Friend code')
            ->assertSee('Email')
            ->assertSee('Password')
            ->assertSee('Confirm password')
            ->assertSeeText('Register');
    }

    public function testToSubmitRegister()
    {
        $email = $this->faker->email;
        $profile = factory(Profile::class)->make();
        $this
            ->from('/register')
            ->post('/register', $profile->toArray() + [
                    'email' => $email,
                    'password' => $this->getDefaultPassword(),
                    'password_confirmation' => $this->getDefaultPassword()
                ])
            ->assertStatus(302)
            ->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }

    public function testToSubmitRegisterWithInvalidEmail()
    {
        $email = $this->faker->word;
        $profile = factory(Profile::class)->make();
        $this
            ->followingRedirects()
            ->from('/register')
            ->post('/register', $profile->toArray() + [
                    'email' => $email,
                    'password' => $this->getDefaultPassword(),
                    'password_confirmation' => $this->getDefaultPassword()
                ])
            ->assertSuccessful()
            ->assertSeeText('The email must be a valid email address.');
        $this->assertDatabaseMissing('users', [
            'email' => $email,
        ]);
    }

    public function testToSubmitRegisterAndClaimProfile()
    {
        $email = $this->faker->email;
        $friend_code = $this->faker->numberBetween(100000000000, 999999999999);
        $userClaimable = factory(User::class)->states(User::ROLE_CUSTOMER)->create([
            'email' => $friend_code . '@pokemon-friends.com',
        ]);
        factory(Profile::class)->create([
            'user_id' => $userClaimable->id,
            'friend_code' => $friend_code
        ]);
        $this
            ->from('/register')
            ->post('/register', [
                'friend_code' => $friend_code,
                'email' => $email,
                'password' => $this->getDefaultPassword(),
                'password_confirmation' => $this->getDefaultPassword()
            ])
            ->assertStatus(302)
            ->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'id' => $userClaimable->id,
            'email' => $email,
        ]);
        $this->assertDatabaseHas('users_profiles', [
            'user_id' => $userClaimable->id,
            'friend_code' => $friend_code,
        ]);
    }
}
