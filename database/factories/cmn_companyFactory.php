<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\cmn_company;
use Faker\Generator as Faker;

$factory->define(cmn_company::class, function (Faker $faker) {
    return [
        'company_name' => $faker->name,
        'company_name_kana' => $faker->word,
        'jcode' => rand(1000, 20000),
        'phone' => $faker->phoneNumber,
        'fax' => $faker->email,
        'postal_code' => rand(1089, 10299),
        'address' => $faker->address,
    ];
});
