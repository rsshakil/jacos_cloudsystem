<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Byr_order_detail;
use Faker\Generator as Faker;

$factory->define(Byr_order_detail::class, function (Faker $faker) {
    return [
        // 'byr_order_id' => 1,
        'byr_order_id' => factory(App\byr_order::class),
        'byr_shop_id' => factory(App\byr_shop::class),
        'byr_item_id' => rand(1, 6),
        'order_type' => $faker->randomElement(['normal', 'direct']),
        'category_code' => rand(1, 6),
        'voucher_category' => $faker->word,
        'voucher_number' => rand(9998899999, 9998810999),
        'list_number' => rand(1, 20),
        'delivery_service_code' => rand(1, 20),
        'status' => $faker->randomElement(['未確定', '確定済み', '未出荷', '出荷中', '出荷済み']),
        'jan' => rand(9998899999, 9998810999),
        'item_name' => $faker->text,
        'item_name_kana' => $faker->text,
        'spac' => $faker->word,
        'spec_kana' => $faker->sentence,
        'inputs' => rand(1, 10),
        'size' => rand(1, 100),
        'color' => $faker->hexcolor,
        'order_inputs' => $faker->randomElement(['ケース', 'ボール', 'バラ']),
        'order_quantity' => rand(1, 10),
        'order_date' => $faker->date(),
        'expected_delivery_date' => $faker->date(),
        'sale_category' => $faker->word,
        'cost_unit_price' => rand(1, 100),
        'cost_price' => rand(1, 1000),
        'selling_unit_price' => rand(1, 1000),
        'selling_price' => rand(1, 1000),
        'tax_category' => $faker->randomElement(['指定無し', '内税', '外税', '内税(軽減税率)', '外税(軽減税率)', 'その他']),
        'other_info' => $faker->realText(rand(80, 100)),
    ];
});
