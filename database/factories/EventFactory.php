<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    $start = $faker->dateTimeThisYear();
    $end = carbon($start)->addHours(4);

    return [
        'venue_id' => factory(App\Venue::class),
        'name' => $name = $faker->name,
        'slug' => str_slug($name),
        'start_time' => $start,
        'end_time' => $end,
        'description' => $faker->text,
        'cover' => $faker->imageUrl(),
        'canceled' => $faker->boolean(35),
        'soldout' => $faker->boolean(20),
        'uuid' => $faker->uuid,
        'id_facebook' => $faker->randomNumber(8),
        'fb_updated_at' => $faker->dateTime(),
        'last_pulled_at' => $faker->dateTime(),
    ];
});
