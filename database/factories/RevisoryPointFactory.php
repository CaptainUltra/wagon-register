<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\RevisoryPoint;
use Faker\Generator as Faker;

$factory->define(RevisoryPoint::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'abbreviation' => substr($faker->name, 0, 2)
    ];
});
