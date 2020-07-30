<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\lv3_service;
use Faker\Generator as Faker;

$factory->define(lv3_service::class, function (Faker $faker) {
    return [
        'cmn_connect_id' => factory(App\cmn_connect::class),
        'adm_role_id' => factory(Spatie\Permission\Models\Role::class),
        'service_name' =>  $faker->word,
    ];
});
