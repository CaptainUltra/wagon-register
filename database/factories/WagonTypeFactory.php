<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\WagonType;
use App\InteriorType;
use Faker\Generator as Faker;

$factory->define(WagonType::class, function (Faker $faker) {
    return [
        'name' => '85-97',
        'conditioned' => $faker->boolean,
        'interior_type_id' => ''
    ];
});
