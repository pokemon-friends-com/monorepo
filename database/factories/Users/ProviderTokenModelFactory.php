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

use pkmnfriends\Domain\Users\ProvidersTokens\ProviderToken;

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory
    ->define(pkmnfriends\Domain\Users\ProvidersTokens\ProviderToken::class, function (Faker\Generator $faker) {
        return [
            'user_id' => 0,
            'provider' => $faker->randomElement(ProviderToken::PROVIDERS),
            'provider_id' => $faker->randomDigitNotNull,
            'provider_token' => $faker->randomDigitNotNull,
        ];
    })
    ->state(ProviderToken::class, ProviderToken::GOOGLE, [
        'provider' => ProviderToken::GOOGLE,
    ])
    ->state(ProviderToken::class, ProviderToken::TWITTER, [
        'provider' => ProviderToken::TWITTER,
    ]);
