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

use template\Domain\Files\Medias\Media;

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory
    ->define(Media::class, function (Faker\Generator $faker) {
        return [
            'model_id' => null,
            'model_type' => '',
            'collection_name' => $faker->text,
            'name' => $faker->text,
            'file_name' => null,
            'mime_type' => null,
            'disk' => 'object-storage',
            'size' => 0,
            'manipulations' => '',
            'custom_properties' => '',
            'order_column' => $faker->randomDigit,
        ];
    });
