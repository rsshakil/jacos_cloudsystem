<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LV3\lv3_trigger_file_path;
use Faker\Generator as Faker;

$factory->define(lv3_trigger_file_path::class, function (Faker $faker) {
    return [
        'lv3_service_id' => factory(App\Models\LV3\lv3_service::class),
        'check_folder_path' => $faker->url,
        'moved_folder_path' => $faker->url,
        'api_url' => $faker->url,
        'api_folder_path' => $faker->url,
        'path_execution_flag' => rand(0,1),
    ];
});
