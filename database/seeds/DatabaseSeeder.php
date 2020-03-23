<?php

use Illuminate\Database\Seeder;
use template\Domain\Users\Profiles\Profile;
use template\Domain\Users\Users\User;
use template\Domain\Users\Leads\Lead;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 50)
            ->states(User::ROLE_CUSTOMER)
            ->create()
            ->each(function ($user) {
                factory(Profile::class)->create(['user_id' => $user->id]);
                if (0 === \Faker\Factory::create()->numberBetween(0, 9) % 2) {
                    factory(Lead::class)->create(['user_id' => $user->id]);
                }
            });
        factory(Lead::class, 10)->create();
    }
}
