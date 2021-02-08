<?php

use Illuminate\Database\Seeder;
use App\Models\LV3\lv3_job;

class Lv3JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $job_array=array(
            [
                'lv3_service_id'=>1,
                'job_execution_flag'=>1,
                'execution'=>"batch",
                'cmn_scenario_id'=>"",
                'batch_file_path'=>"C:\Users\ASUS\OneDrive\Desktop\JCS\Batch\argument_batch.bat arg1 LV3_FILE_PATH",
                'next_service_id'=>2,
                'append'=>'',
            ],
            [
                'lv3_service_id'=>2,
                'job_execution_flag'=>1,
                'execution'=>"scenario",
                'cmn_scenario_id'=>"4",
                'batch_file_path'=>"",
                'next_service_id'=>'',
                'append'=>'',
            ]
        );
        lv3_job::insert($job_array);
    }
}
