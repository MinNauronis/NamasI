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

    $curtain = factory(\App\Curtain::class)->create();

    return [
        'curtain_id' => $curtain,
        'owner_id' => $curtain->owner,
        'title' => $faker->title,
    ];
});
