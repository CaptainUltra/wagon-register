<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Wagon;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Wagon::class, function (Faker $faker) {
    return [
        'number' => '615285970039',
        'letter_index' => $faker->name,
        'v_max' => $faker->numberBetween($min = 100, $max = 200),
        'seats' => $faker->numberBetween($min = 10, $max = 80),
        'depot_id' => 1,
        'revisory_point_id' => 1,
        'revision_date' => $faker->date()
    ];
});
