<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone_number' => $faker->e164PhoneNumber,
        'access' => $faker->numberBetween(1, 3),
        'username' => $faker->userName,
        'password' => Hash::make('secret'),
        'photo' => asset('/images/users/userdefault.png'),
        'status' => true,
    ];
});
