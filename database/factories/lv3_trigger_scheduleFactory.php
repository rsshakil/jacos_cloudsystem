<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LV3\lv3_trigger_schedule;
use Faker\Generator as Faker;

$factory->define(lv3_trigger_schedule::class, function (Faker $faker) {
    return [
        'lv3_service_id' => factory(App\Models\LV3\lv3_service::class),
        'day' => rand(1,31),
        'weekday' => rand(0,254),
        'time' => $faker->time,
        'last_day' => rand(0,1),
        'disabled' => rand(0,1),
    ];
});
