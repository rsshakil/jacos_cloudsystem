<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LV3\lv3_job;
use Faker\Generator as Faker;

$factory->define(lv3_job::class, function (Faker $faker) {
    return [
        'lv3_service_id' => factory(App\Models\LV3\lv3_service::class),
        'job_execution_flg' => rand(0,1),
        'execution' => $faker->randomElement(['scenario','batch']),
        'cmn_scenario_id' => rand(0,5),
        // 'cmn_scenario_id' => factory(App\cmn_scenario::class),
        'batch_file_path' => $faker->url,
        'append' => $faker->sentence(5),
    ];
});
