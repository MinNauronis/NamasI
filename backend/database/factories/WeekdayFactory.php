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

$factory->define(App\Weekday::class, function (Faker $faker) {
    return [
        'schedule_id' => factory(\App\Schedule::class)->id,
        'owner_id' => factory(\App\User::class)->id,
        'weekday' => $faker->unique()->numberBetween(0, 6),
        'open_time' => $faker->time(),
        'close_time' => $faker->time(),
    ];
});
