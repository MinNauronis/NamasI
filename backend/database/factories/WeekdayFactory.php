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

    $schedule = factory(\App\Schedule::class)->create();

    return [
        'schedule_id' => $schedule->id,
        'owner_id' => $schedule->owner_id,
        'weekday' => 8,
        'open_time' => $faker->time(),
        'close_time' => $faker->time(),
    ];
});
