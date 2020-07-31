<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Byr_shipment_detail;
use Faker\Generator as Faker;

$factory->define(Byr_shipment_detail::class, function (Faker $faker) {
    return [
        'byr_shipment_id' => factory(App\Byr_shipment::class),
        'byr_order_detail_id' => factory(App\Byr_order_detail::class),
        'order_quantity' => rand(1, 10),
        'confirm_quantity' => rand(1, 10),
        'delivery_quantity' => rand(1, 10),
        'stock_out_quantity' => rand(1, 10),
        'damage_quantity' => rand(1, 10),
        'lack_reason' => $faker->word,
        'revised_delivery_date' =>$faker->date,
        'revised_cost_unit_price' => rand(1, 10),
        'revised_cost_price' => rand(9999, 90999),
        'revised_selling_unit_price' => rand(1, 5),
        'revised_selling_price' => rand(1, 200),
        'update_by' => rand(0,1),
    ];
});
