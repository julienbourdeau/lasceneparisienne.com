<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Venue::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->company,
        'slug' => str_slug($name),
        'city' => $faker->city,
        'email' => $faker->companyEmail,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
        'uuid' => $faker->uuid,
        'id_facebook' => $faker->randomNumber(8),
    ];
});
