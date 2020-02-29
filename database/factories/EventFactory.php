<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use App\Station;
use App\Train;
use App\User;
use App\Wagon;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'date' => $faker->date(),
        'comment' => $faker->sentence,
        'wagon_id' => factory(Wagon::class),
        'user_id' => factory(User::class),
        'station_id' => factory(Station::class),
        'train_id' => factory(Train::class)
    ];
});
