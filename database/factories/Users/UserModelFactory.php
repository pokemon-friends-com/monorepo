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

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use template\Domain\Users\Users\User;

$factory
    ->define(User::class, function (Faker\Generator $faker) {
        static $password;

        return [
            'uniqid' => uniqid(),
            'locale' => $faker->randomElement(User::LOCALES),
            'timezone' => $faker->randomElement(timezones()),
            'role' => $faker->randomElement(User::ROLES),
            'civility' => $faker->randomElement(User::CIVILITIES),
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'password' => $password ?: $password = bcrypt('secret1234'),
            'remember_token' => str_random(10),
        ];
    })
    ->state(User::class, 'deleted', [
        'deleted_at' => now(),
    ])
    ->state(User::class, 'password_null', [
        'password' => null,
    ])
    ->state(User::class, 'uniqid_null', [
        'uniqid' => null,
    ])
    ->state(User::class, User::ROLE_ADMINISTRATOR, [
        'role' => User::ROLE_ADMINISTRATOR,
    ])
    ->state(User::class, User::ROLE_CUSTOMER, [
        'role' => User::ROLE_CUSTOMER,
    ])
    ->state(User::class, User::ROLE_ACCOUNTANT, [
        'role' => User::ROLE_ACCOUNTANT,
    ])
    ->state(User::class, User::DEFAULT_LOCALE, [
        'locale' => User::DEFAULT_LOCALE,
    ])
    ->state(User::class, User::DEFAULT_TZ, [
        'timezone' => User::DEFAULT_TZ,
    ]);
