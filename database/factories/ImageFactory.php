<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use App\User;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'file_name' => $faker->name(),
        'title' => $faker->name(),
        'description' => $faker->text(),
        'date' => $faker->date(),
        'user_id' => factory(User::class)
    ];
});
