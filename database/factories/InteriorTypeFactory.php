<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InteriorType;
use Faker\Generator as Faker;

$factory->define(InteriorType::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
