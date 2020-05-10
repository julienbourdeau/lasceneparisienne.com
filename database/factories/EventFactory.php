<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'venue_id' => factory(App\Venue::class),
        'name' => $faker->name,
        'slug' => $faker->slug,
        'start_time' => $faker->dateTime(),
        'end_time' => $faker->dateTime(),
        'description' => $faker->text,
        'cover' => $faker->word,
        'canceled' => $faker->boolean,
        'soldout' => $faker->boolean,
        'ticket_url' => $faker->text,
        'meta' => $faker->word,
        'uuid' => $faker->uuid,
        'id_facebook' => $faker->word,
        'source' => $faker->word,
        'fb_updated_at' => $faker->dateTime(),
        'last_pulled_at' => $faker->dateTime(),
    ];
});
