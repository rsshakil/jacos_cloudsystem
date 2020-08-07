<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\cmn_scenario;
use Faker\Generator as Faker;

$factory->define(cmn_scenario::class, function (Faker $faker) {
    return [
        'byr_buyer_id' => factory(App\byr_buyer::class),
        'slr_seller_id' => factory(App\slr_seller::class),
        'class' => $faker->randomElement(['order','shipment','invoice','payment','inventory','other']),
        'vector' => $faker->randomElement(['to_jacos','from_jacos','in_jacos','other']),
        'name' => $faker->word,
        'description' => $faker->sentence(5),
        'file_path' => 'App\Scenarios\ouk_order_toj',
    ];
});
