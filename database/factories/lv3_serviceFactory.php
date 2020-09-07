<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LV3\lv3_service;
use Faker\Generator as Faker;

$factory->define(lv3_service::class, function (Faker $faker) {
    return [
        'cmn_connect_id' => factory(App\Models\CMN\cmn_connect::class),
        'adm_role_id' => Spatie\Permission\Models\Role::all()->random()->id,
        'service_name' =>  $faker->word,
    ];
});
