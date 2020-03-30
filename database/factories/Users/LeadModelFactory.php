<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use template\Domain\Users\Leads\Lead;
use template\Domain\Users\Users\User;

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory
    ->define(Lead::class, function (Faker\Generator $faker) {
        return [
            'user_id' => null,
            'civility' => $faker->randomElement(User::CIVILITIES),
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
        ];
    });
