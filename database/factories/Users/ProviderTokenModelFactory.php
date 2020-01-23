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

use template\Domain\Users\ProvidersTokens\ProviderToken;

$factory
    ->define(template\Domain\Users\ProvidersTokens\ProviderToken::class, function (Faker\Generator $faker) {
        return [
            'user_id' => 0,
            'provider' => $faker->randomElement(ProviderToken::PROVIDERS),
            'provider_id' => $faker->randomDigitNotNull,
            'provider_token' => str_random(10),
        ];
    })
    ->state(ProviderToken::class, ProviderToken::GOOGLE, [
        'provider' => ProviderToken::GOOGLE,
    ])
    ->state(ProviderToken::class, ProviderToken::LINKEDIN, [
        'provider' => ProviderToken::LINKEDIN,
    ])
    ->state(ProviderToken::class, ProviderToken::TWITTER, [
        'provider' => ProviderToken::TWITTER,
    ]);
