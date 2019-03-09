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

$factory->define(App\Curtain::class, function (Faker $faker) {
    return [
        'owner_id' => factory(\App\User::class),
        'title' => $faker->title,
        'micro_controller_id' => '111.111.111.225',
    ];
});
