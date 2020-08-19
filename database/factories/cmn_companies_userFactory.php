<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\cmn_companies_user;
use App\User;
use Faker\Generator as Faker;

$factory->define(cmn_companies_user::class, function (Faker $faker) {
    return [
        'cmn_company_id' => factory(App\cmn_company::class),
        'adm_user_id' => User::all()->random()->id,
    ];
});
