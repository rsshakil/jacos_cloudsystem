<?php

namespace App\Scenarios;
use App\Models\LV3\lv3_trigger_schedule;
use App\Models\LV3\lv3_trigger_file_path;
use App\Models\LV3\lv3_job;
use App\Models\LV3\lv3_service;

class schedule_data
{
    //
    public function exec($request,$sc)
    {
        $user_id = $request->user_id;
        $service_id = $request->service_id;

        $schedule_data = lv3_trigger_schedule::where('lv3_service_id', $service_id)->get();

        $schedule_array = array();
        if (!empty($schedule_data)) {
            foreach ($schedule_data as $key => $value) {
                $test['schedule_id'] = $value->schedule_id;
                $test['service_id'] = $value->service_id;
                // $test['user_id'] = $value->user_id;
                // $test['customer_id'] = $value->customer_id;
                // $test['schedule_name'] = $value->name;
                $test['day'] = $value->day;
                $test['weekday'] = str_split($this->binary_format($this->decimal_to_binary($value->weekday)));
                $test['time'] = $value->time;
                $test['last_day'] = $value->last_day;
                $test['disabled'] = $value->disabled;
                $test['original_weekday'] = $value->weekday;
                $schedule_array[] = $test;
            }
        }
        $file_path_info = $this->getFilePath($user_id, $service_id);
        $job_info="";
        $job_info=lv3_job::select('lv3_jobs.*','cmn_scenarios.name')
        ->join('cmn_scenarios','cmn_scenarios.cmn_scenario_id','lv3_jobs.cmn_scenario_id')
        ->where('lv3_jobs.lv3_service_id',$service_id)->first();
        $final_arr=array(
            'schedule_array' => $schedule_array,
            'file_path_info' => $file_path_info,
            'job_info'=>$job_info
        );
        return $final_arr;
        // return response()->json(['schedule_array' => $schedule_array, 'file_path_info' => $file_path_info,'job_info'=>$job_info]);
    }
    public function getFilePath($user_id, $service_id)
    {
        return lv3_trigger_file_path::where('lv3_service_id', $service_id)->first();
    }

    
}
