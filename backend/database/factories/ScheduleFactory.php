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

$factory->define(App\Schedule::class, function (Faker $faker) {
    return [
        'curtain_id' => factory(\App\Curtain::class)->id,
        'owner_id' => factory(\App\User::class)->id,
        'title' => $faker->title,
    ];
});
