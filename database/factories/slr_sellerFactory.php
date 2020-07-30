<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\slr_seller;
use Faker\Generator as Faker;

$factory->define(slr_seller::class, function (Faker $faker) {
    return [
        'cmn_company_id' => factory(App\cmn_company::class),
        'adm_role_id' => factory(Spatie\Permission\Models\Role::class),
    ];
});
