<?php

use Illuminate\Database\Seeder;
use template\Domain\Users\Profiles\Profile;
use template\Domain\Users\Users\User;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)
            ->states(User::ROLE_ADMINISTRATOR)
            ->create([
                'email' => 'admin@pokemon-friends.com',
                'locale' => 'en',
            ])
            ->each(function ($user) {
                factory(Profile::class)->create([
                    'user_id' => $user->id,
                    'friend_code' => '500161205617',
                    'team_color' => \template\Domain\Users\Profiles\ProfilesTeamsColors::BLUE,
                    'sponsored' => \Carbon\Carbon::now()->format('Y-m-d'),
                ]);
            });

        factory(User::class)
            ->states(User::ROLE_CUSTOMER)
            ->create([
                'email' => 'customer@pokemon-friends.com',
                'locale' => 'en',
                'uniqid' => '5ed905c33039a',
            ])
            ->each(function ($user) {
                factory(Profile::class)->create([
                    'user_id' => $user->id,
                    'friend_code' => '500161205617',
                    'team_color' => \template\Domain\Users\Profiles\ProfilesTeamsColors::RED,
                    'sponsored' => \Carbon\Carbon::now()->format('Y-m-d'),
                ]);
            });

        factory(User::class, 200)
            ->states(User::ROLE_CUSTOMER)
            ->create()
            ->each(function ($user) {
                factory(Profile::class)->create(['user_id' => $user->id]);
            });
    }
}
