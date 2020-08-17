<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Byr_shipment;
use Faker\Generator as Faker;

$factory->define(Byr_shipment::class, function (Faker $faker) {
    return [
        'byr_order_id' => factory(App\Byr_order::class),
        'cmn_connect_id' => factory(App\cmn_connect::class),
        'category' => $faker->randomElement(['edi', 'manual']),
        'send_date' => now(),
        'send_file_path' => $faker->url,
        'data_count' => rand(1, 6),
    ];
});
