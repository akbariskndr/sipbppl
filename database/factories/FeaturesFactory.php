<?php

use Faker\Generator as Faker;

$factory->define(App\Feature::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        'priority' => $faker->numberBetween(1, 5),
        'project_id' => 1,
    ];
});
