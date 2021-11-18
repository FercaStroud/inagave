<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(App\Product::class, function (Faker $faker) {

    return [
        'estate' => $faker->text,
        'size_state' => $faker->numberBetween(1,100),
        'quantity' => $faker->numberBetween(100, 1000),
        'price' => $faker->randomFloat(2, 1, 50),
        'age' => $faker->numberBetween(1, 7),
        'municipality' => $faker->text(75),
        'location_url' => $faker->url(),
        'location' => '24.170300138817815, -110.29608660056246',
        'description' => $faker->sentence(20, true),
    ];
});
