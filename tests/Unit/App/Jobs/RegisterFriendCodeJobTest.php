<?php

namespace Tests\Unit\App\Jobs;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use template\App\Jobs\RegisterFriendCodeJob;
use template\Domain\Users\Profiles\Profile;
use template\Domain\Users\Profiles\ProfilesTeamsColors;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Domain\Users\Users\Repositories\UsersRegistrationsRepositoryEloquent;
use template\Domain\Users\Users\User;
use Tests\TestCase;

class RegisterFriendCodeJobTest extends TestCase
{
    use DatabaseMigrations;

    public function testToRegisterFriendCodeWhenNotExists()
    {
        $friendCode = $this->faker->numberBetween(100000000000, 999999999999);

        (new RegisterFriendCodeJob($friendCode, ProfilesTeamsColors::BLUE))
            ->handle(
                app()->make(UsersRegistrationsRepositoryEloquent::class),
                app()->make(ProfilesRepositoryEloquent::class)
            );

        $this->assertDatabaseHas('users_profiles', [
            'friend_code' => $friendCode,
            'team_color' => ProfilesTeamsColors::BLUE,
        ]);
        $this->assertDatabaseHas('users', [
            'email' => "{$friendCode}@pokemon-friends.com",
        ]);
    }

    public function testToRegisterFriendCodeWhenIsClaimable()
    {
        $friendCode = $this->faker->numberBetween(100000000000, 999999999999);
        $user = factory(User::class)->create([
            'email' => "{$friendCode}@pokemon-friends.com",
        ]);
        factory(Profile::class)->create([
            'user_id' => $user->id,
            'friend_code' => $friendCode,
            'team_color' => ProfilesTeamsColors::DEFAULT,
        ]);

        (new RegisterFriendCodeJob($friendCode, ProfilesTeamsColors::BLUE))
            ->handle(
                app()->make(UsersRegistrationsRepositoryEloquent::class),
                app()->make(ProfilesRepositoryEloquent::class)
            );

        $this->assertDatabaseHas('users_profiles', [
            'friend_code' => $friendCode,
            'team_color' => ProfilesTeamsColors::BLUE,
        ]);
    }

    public function testToRegisterFriendCodeWhenIsNotClaimable()
    {
        $friendCode = $this->faker->numberBetween(100000000000, 999999999999);
        $user = factory(User::class)->create();
        factory(Profile::class)->create([
            'user_id' => $user->id,
            'friend_code' => $friendCode,
            'team_color' => ProfilesTeamsColors::DEFAULT,
        ]);

        (new RegisterFriendCodeJob($friendCode, ProfilesTeamsColors::BLUE))
            ->handle(
                app()->make(UsersRegistrationsRepositoryEloquent::class),
                app()->make(ProfilesRepositoryEloquent::class)
            );

        $this->assertDatabaseHas('users_profiles', [
            'friend_code' => $friendCode,
            'team_color' => ProfilesTeamsColors::DEFAULT,
        ]);
    }

    public function testToRegisterFriendCodeWhenFriendCodeIsNotValid()
    {
        $friendCode = $this->faker->word;

        (new RegisterFriendCodeJob($friendCode))
            ->handle(
                app()->make(UsersRegistrationsRepositoryEloquent::class),
                app()->make(ProfilesRepositoryEloquent::class)
            );

        $this->assertDatabaseMissing('users_profiles', [
            'friend_code' => $friendCode
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => "{$friendCode}@pokemon-friends.com",
        ]);
    }
}
