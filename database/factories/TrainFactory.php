<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Train;
use Faker\Generator as Faker;

$factory->define(Train::class, function (Faker $faker) {
    return [
        'number' => $faker->randomNumber(),
        'route' => $faker->sentence,
        'description' => $faker->text
    ];
});