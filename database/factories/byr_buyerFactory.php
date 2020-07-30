<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\byr_buyer;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(byr_buyer::class, function (Faker $faker) {
    return [
        'cmn_company_id' => factory(App\cmn_company::class),
        'super_code' => Str::random(4),
        'adm_role_id' => factory(Spatie\Permission\Models\Role::class),
    ];
});
