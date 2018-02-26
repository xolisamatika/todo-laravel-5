<?php

use Faker\Generator as Faker;

$factory->define(App\Todo::class, function (Faker $faker) {
    return [
        'title' => substr($faker->sentence(2), 0, -1),
        'is_complete' => $faker->boolean($chanceOfGettingTrue = 90),
    ];
});
