<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\WagonType;
use App\InteriorType;
use Faker\Generator as Faker;

$factory->define(WagonType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'conditioned' => $faker->boolean,
        'revision_valid_for' => $faker->randomDigitNotNull,
        'interior_type_id' => factory(InteriorType::class)
    ];
});
