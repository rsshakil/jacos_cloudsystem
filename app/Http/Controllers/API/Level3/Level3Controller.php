<?php

namespace App\Http\Controllers\API\Level3;

use App\Http\Controllers\API\AllUsedFunction;
use App\Http\Controllers\API\Cmn_ScenarioController;
use App\Http\Controllers\Controller;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
use App\Models\Lv3\lv3_history;
use App\Models\Lv3\lv3_job;
use App\Models\Lv3\lv3_service;
use App\Models\Lv3\lv3_trigger_file_path;
use App\Models\Lv3\lv3_trigger_schedule;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Level3Controller extends Controller
{
    private $message;
    private $status_code;
    private $class_name;
    private $lst_customer_id;
    private $lst_service_id;
    private $flag;
    private $all_functions;
    public function __construct()
    {
        $this->message = '';
        $this->status_code = '';
        $this->class_name = '';
        $this->lst_customer_id = '';
        $this->lst_service_id = '';
        $this->flag = '';
        $this->all_functions = new AllUsedFunction();
    }
    public function userLogin(Request $request)
    {
        // return $request->all();
        $email = $request->user_name;
        $password = $request->password;
        // return response()->json(['UserName'=>$email, 'Password' => $password]);
        if (User::where('email', '=', $email)->exists()) {
            $user = User::where('email', '=', $email)->first();
            if (Hash::check($password, $user->password)) {
                return response()->json(['message' => 'success', 'class_name' => 'alert-success', 'user_id' => $user->id, 'user_name' => $user->name]);
            } else {
                // return response()->json(['message' => "Please enter a valid password in propery.txt file", 'class_name' => 'alert-danger']);
                return response()->json(['message' => "passwordがありません。properties.fileを確認してください。", 'class_name' => 'alert-danger']);
            }

        } else {
            // return response()->json(['message' => "Please enter a valid email in propery.txt file", 'class_name' => 'alert-danger']);
            return response()->json(['message' => "emailがありません。properties.fileを確認してください。", 'class_name' => 'alert-danger']);
        }
        // return "Hi";

    }

    public function historyData(Request $request)
    {
        $user_id = $request->user_id;
        $all_history = lv3_history::select('lv3_histories.*', 'lv3_services.lv3_service_id', 'lv3_services.service_name', 'cmn_companies.company_name', 'cmn_connects.partner_code')
            ->join('lv3_services', 'lv3_histories.lv3_service_id', '=', 'lv3_services.lv3_service_id')
            ->join('cmn_connects', 'lv3_services.cmn_connect_id', '=', 'cmn_connects.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
            ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
            ->where('lv3_services.adm_user_id', $user_id)
            ->orderBy('lv3_histories.lv3_history_id', 'DESC')
            ->take(100)->get();
        \Log::info($all_history);
        return \response()->json(['histories' => $all_history]);
    }

    public function getCustomer(Request $request)
    {
        $user_id = $request->user_id;
        $customers_data = cmn_companies_user::select('cmn_companies_users.adm_user_id', 'cmn_connects.cmn_connect_id', 'cmn_connects.partner_code', 'cmn_companies.company_name')
            ->join('slr_sellers', 'slr_sellers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
            ->join('cmn_connects', 'cmn_connects.slr_seller_id', '=', 'slr_sellers.slr_seller_id')
            ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
            ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
            ->where('cmn_companies_users.adm_user_id', $user_id)->get();
        \Log::info($customers_data);
        return response()->json(['customers_data' => $customers_data]);
    }

    public function showServiceData(Request $request)
    {
        $cmn_connect_id = $request->cmn_connect_id;
        $adm_user_id = $request->adm_user_id;
        $all_service_data = lv3_service::where(['cmn_connect_id' => $cmn_connect_id, 'adm_user_id' => $adm_user_id])->get();
        return \response()->json(['all_service_data' => $all_service_data]);
    }

    public function addService(Request $request)
    {
        // return $request->all();
        $user_id = $request->user_id;
        $service_id = $request->service_id;
        $cmn_connect_id = $request->cmn_connect_id;
        $service_name = $request->service_name;
        // $service_count=service::where('customer_id', $customer_id)->count();
        // if($service_count>=3){
        //     return \response()->json(['message' => "Service full in database", 'status_code' => 403, 'class_name' => 'alert-danger']);
        // }

        $service_array = array(
            'cmn_connect_id' => $cmn_connect_id,
            'adm_user_id' => $user_id,
            'service_name' => $service_name,
        );
        // return $service_array;
        if ($service_id != null) {
            $service_info = lv3_service::where('lv3_service_id', $service_id)->first();
            if ($service_info['service_name'] != $service_name) {
                if (lv3_service::where(['cmn_connect_id' => $cmn_connect_id, 'adm_user_id' => $user_id, 'service_name' => $service_name])->exists()) {
                    // $this->message='Partner code alrady exists';
                    $this->message = 'このサービス名はすでに使われています。';
                    $this->status_code = 403;
                    $this->class_name = 'alert-danger';
                    return \response()->json(['message' => $this->message, 'status_code' => $this->status_code, 'class_name' => $this->class_name, 'lst_service_id' => $this->lst_service_id]);
                }
            }
            // $this->message='Update Success';
            $this->message = '更新完了';
            $this->status_code = 200;
            $this->class_name = 'alert-success';
            $this->flag = 1;
            $this->lst_service_id = $service_id;
            lv3_service::where('lv3_service_id', $service_id)->update($service_array);
        } else {
            if (lv3_service::where(['cmn_connect_id' => $cmn_connect_id, 'adm_user_id' => $user_id, 'service_name' => $service_name])->exists()) {
                // $this->message='Partner code alrady exists';
                $this->message = 'Service name already exists';
                $this->status_code = 403;
                $this->class_name = 'alert-danger';
                // return \response()->json(['message'=>$this->message,'status_code'=>$this->status_code,'class_name'=>$this->class_name]);
            } else {
                $this->lst_service_id = lv3_service::insertGetId($service_array);
                // $this->message='Insert Success';
                $this->message = '登録完了';
                $this->status_code = 200;
                $this->class_name = 'alert-success';
                $this->flag = 0;
            }
        }

        return \response()->json(['message' => $this->message, 'status_code' => $this->status_code, 'class_name' => $this->class_name, 'flag' => $this->flag, 'lst_service_id' => $this->lst_service_id]);
    }

    public function scheduleData(Request $request)
    {
        // return $request->all();
        // \Log::info($request->all());
        $user_id = $request->user_id;
        $service_id = $request->service_id;
        $schedule_data = lv3_trigger_schedule::where('lv3_service_id', $service_id)->get();

        $schedule_array = array();
        if (!empty($schedule_data)) {
            foreach ($schedule_data as $key => $value) {
                $test['schedule_id'] = $value->lv3_trigger_schedule_id;
                $test['service_id'] = $value->lv3_service_id;
                // $test['user_id'] = $value->user_id;
                // $test['customer_id'] = $value->customer_id;
                // $test['schedule_name'] = $value->name;
                $test['day'] = $value->day;
                $test['weekday'] = str_split($this->all_functions->binary_format($this->all_functions->decimal_to_binary($value->weekday)));
                $test['time'] = $value->time;
                $test['last_day'] = $value->last_day;
                $test['disabled'] = $value->disabled;
                $test['original_weekday'] = $value->weekday;
                $schedule_array[] = $test;
            }
        }
        $file_path_info = $this->getFilePath($user_id, $service_id);
        $job_info = lv3_job::select('lv3_job_id', 'lv3_service_id', 'job_execution_flag', 'cmn_scenario_id',
            'execution', 'batch_file_path', 'next_service_id', 'append')
            ->where('lv3_service_id', $service_id)->first();

        $job_api_scenario_list = DB::select('SELECT cs.cmn_scenario_id,cs.name,cs.description FROM cmn_scenarios AS cs
        INNER JOIN adm_model_has_roles AS amhr ON cs.adm_role_id = amhr.role_id
        WHERE amhr.model_id =' . $user_id . ' AND cs.byr_buyer_id =
        (
            SELECT byr_buyer_id FROM cmn_companies_users AS ccu
            INNER JOIN byr_buyers AS bb ON bb.cmn_company_id=ccu.cmn_company_id
            WHERE ccu.adm_user_id=' . $user_id . '
        )');
        // $job_info['job_api_scenario_list']=$job_api_scenario_list;
        // $job_info=lv3_job::select('lv3_jobs.*','cmn_scenarios.name')
        // ->join('cmn_scenarios','cmn_scenarios.cmn_scenario_id','lv3_jobs.cmn_scenario_id')
        // ->where('lv3_jobs.lv3_service_id',$service_id)->first();
        $all_service_data = lv3_service::select('lv3_service_id', 'service_name', 'cmn_connect_id')
            ->where('adm_user_id', $user_id)->get();
        // $next_service_info=lv3_job::select('next_service_id')

        $final_arr = array(
            'schedule_array' => $schedule_array,
            'file_path_info' => $file_path_info,
            'job_info' => $job_info,
            'job_api_scenario_list' => $job_api_scenario_list,
            'all_service_data' => $all_service_data,
        );
        return response()->json($final_arr);

    }

    public function getFilePath($user_id, $service_id)
    {
        return lv3_trigger_file_path::where('lv3_service_id', $service_id)->first();
    }

    public function setScheduleData(Request $request)
    {
        // return $request->all();

        $user_id = $request->user_id;
        $customer_id = $request->cmn_connect_id;
        $service_id = $request->service_id;
        $data_array = $request->data_array;
        $time_array = $request->time_array;
        $time_sp_array = $request->time_sp_array;
        $last_day_array = $request->last_day_array;
        $day_array = $request->day_array;

        $insert_first_array = array();
        $insert_second_array = array();

        \Log::info($data_array[0]);
        for ($i = 0; $i < count($data_array); $i++) {
            $test_first['lv3_service_id'] = $service_id;
            // $test_first['user_id'] = $user_id;
            // $test_first['customer_id'] = $customer_id;
            // $test_first['name'] = "No Name";
            $test_first['weekday'] = $this->all_functions->binary_to_decimal($data_array[$i]);
            // $test_first['weekday'] = 210;
            $test_first['time'] = $time_array[$i];
            $test_first['disabled'] = 0;
            $insert_first_array[] = $test_first;
        }
        for ($j = 0; $j < count($last_day_array); $j++) {
            $test_second['lv3_service_id'] = $service_id;
            // $test_second['user_id'] = $user_id;
            // $test_second['customer_id'] = $customer_id;
            // $test_second['name'] = "No Name";
            $test_second['day'] = $day_array[$j];
            $test_second['time'] = $time_sp_array[$j];
            $test_second['last_day'] = $last_day_array[$j];
            $test_second['disabled'] = 0;
            $insert_second_array[] = $test_second;
        }
        // return $insert_array;
        lv3_trigger_schedule::where('lv3_service_id', $service_id)->delete();
        lv3_trigger_schedule::insert($insert_first_array);
        lv3_trigger_schedule::insert($insert_second_array);
        // return response()->json(['message' => 'Schedule updated', 'class_name' => 'alert-success']);
        return response()->json(['message' => '更新完了', 'class_name' => 'alert-success']);

    }
    // public function binary_to_decimal($binary)
    // {
    //     \Log::info($binary);
    //     return bindec($binary);
    // }
    public function setFilePath(Request $request)
    {
        // return $request->all();
        $user_id = $request->user_id;
        // $customer_id=$request->cmn_connect_id;
        $service_id = $request->service_id;
        $path_execution_flag = $request->path_execution_flag;
        // $shipment_path_execute=$request->shipment_path_execute;
        $file_source_path = $request->file_source_path;
        $file_move_path = $request->file_move_path;
        $api_url = $request->api_url;
        $api_folder_path = $request->api_folder_path;
        $file_path_array = array(
            // 'customer_id'=>$customer_id,
            'lv3_service_id' => $service_id,
            'check_folder_path' => $file_source_path,
            'moved_folder_path' => $file_move_path,
            'api_url' => $api_url,
            'api_folder_path' => $api_folder_path,
            'path_execution_flag' => $path_execution_flag,
        );
        if (lv3_trigger_file_path::where('lv3_service_id', $service_id)->exists()) {
            lv3_trigger_file_path::where('lv3_service_id', $service_id)->update($file_path_array);
        } else {
            lv3_trigger_file_path::insert($file_path_array);
        }
        // return \response()->json(['message'=>'File path saved','class_name'=>'alert-success']);
        return \response()->json(['message' => 'ファイルパスを保存しました。', 'class_name' => 'alert-success']);
    }

    public function setJobData(Request $request)
    {
        // return $request->all();
        $job_id = $request->job_update_id;
        $service_id = $request->service_id;
        $cmn_scenario_id = $request->cmn_scenario_id;
        $batch_file_path = $request->batch_file_path;
        $job_execution_flag = $request->job_execution_flag;
        $execution = $request->execution;
        $next_service_id = $request->next_service_id;
        $job_array = array(
            'lv3_service_id' => $service_id,
            'cmn_scenario_id' => $cmn_scenario_id,
            'batch_file_path' => $batch_file_path,
            'job_execution_flag' => $job_execution_flag,
            'execution' => $execution,
            'next_service_id' => $next_service_id,
        );

        if ($job_id != null) {
            lv3_job::where('lv3_job_id', $job_id)->update($job_array);
            $this->message = 'jobを作成しました。';
            $this->status_code = 200;
            $this->class_name = 'alert-success';
        } else {
            lv3_job::insert($job_array);
            $this->message = 'jobを更新しました。';
            $this->status_code = 200;
            $this->class_name = 'alert-success';
        }
        return response()->json(['message' => $this->message, 'status_code' => $this->status_code, 'class_name' => $this->class_name]);
    }
    public function lv3ScheduleData(Request $request)
    {
        $type = $request->type;
        $schedule_array = array();
        if ($type == 1) {
            $schedule_array = $this->scheduleTimeData($request);
        } elseif ($type == 2) {
            $schedule_array = $this->scheduleDateData($request);
        }
        return response()->json(['schedule_date_time_data' => $schedule_array]);
    }

    public function scheduleTimeData($request)
    {
        // return date('w');
        $service_id = $request->service_id;
        $trigger_execution_time = ($request->trigger_execution_time) / 1000;
        $today = date('w');
        $ret_arr = array();
        $schedule_time_data = lv3_trigger_schedule::select('lv3_trigger_schedule_id', 'weekday', 'time')->where('lv3_service_id', $service_id)
            ->where('weekday', '!=', 0)->get();

        $schedule_array = array();
        $active_weekday_array = array();

        // if (!empty($schedule_time_data)) {
        foreach ($schedule_time_data as $key => $value) {
            $weekday = str_split($this->all_functions->binary_format($this->all_functions->decimal_to_binary($value->weekday)));
            $key_day = array_search('1', $weekday);

            foreach ($weekday as $key1 => $value1) {
                if ($value1 == 1) {
                    $active_weekday_array[] = $key1;
                }
            }

            $test['lv3_trigger_schedule_id'] = $value->lv3_trigger_schedule_id;
            // $test['weekday'] = str_split($this->binary_format($this->decimal_to_binary($value->weekday)));
            $test['weekday'] = $active_weekday_array;
            $test['time'] = $value->time;
            // $test['disabled'] = $value->disabled;
            $test['original_weekday'] = $value->weekday;
            $schedule_array[] = $test;
            if (in_array($today, $test['weekday'])) {
                array_push($ret_arr, $this->dateProcess($value, $trigger_execution_time));
            }
            $active_weekday_array = [];
        }
        // }
        // return $schedule_array;

        // foreach ($schedule_array as $key => $data) {
        //     if (in_array($today,$data['weekday'])) {
        //         array_push($ret_arr,$this->dateProcess($data,$trigger_execution_time));
        //     }
        // }
        return $ret_arr;
    }
    public function scheduleDateData($request)
    {
        $service_id = $request->service_id;
        $trigger_execution_time = ($request->trigger_execution_time) / 1000;
        $schedule_date_data = lv3_trigger_schedule::select('lv3_trigger_schedule_id', 'day', 'time', 'last_day')->where('lv3_service_id', $service_id)
            ->where('weekday', '=', 0)->get();
        $ret_arr = array();
        foreach ($schedule_date_data as $key => $data) {
            if ($data->last_day == 1) {
                array_push($ret_arr, $this->dateProcess($data, $trigger_execution_time));
            } elseif ($data->day != null) {
                $full_day = strtotime(date('y-m-' . $data->day));
                if (strtotime(date('y-m-d')) == $full_day) {
                    array_push($ret_arr, $this->dateProcess($data, $trigger_execution_time));
                }
            }
        }
        // \Log::info($ret_arr);
        return $ret_arr;
    }
    public function dateProcess($data, $trigger_execution_time)
    {
        $cur_date_time = date('2013-11-13 H:i:s');
        // $cur_date_time= strtotime($cur_date_time);
        $advance_time = date("Y-m-d H:i:s", (strtotime($cur_date_time) - $trigger_execution_time));
        // $advance_date= strtotime($advance_time);
        $arr_time = date('2013-11-13 H:i:s', strtotime($data['time']));
        // $arr_time=strtotime();
        if (strtotime($arr_time) > strtotime($advance_time) && strtotime($arr_time) <= strtotime($cur_date_time)) {
            return true;
        } else {
            return false;
        }

        // $arr_time=date('y-m-d H:i:s',strtotime($data['time']));
        // $cur_date_time= date('y-m-d H:i:s');

        // $trigger_execution_sec=$trigger_execution_time%60;
        // $trigger_execution_min=floor($trigger_execution_time/60);
        // $trigger_execution_hour=floor($trigger_execution_min/60);
        // $trigger_execution_day=floor($trigger_execution_hour/12);

        // $date_diff= $this->dateDiff($arr_time,$cur_date_time);
        // if ($date_diff['sec']>=$trigger_execution_sec && $date_diff['minutes']<=$trigger_execution_min && $date_diff['hours']<=$trigger_execution_hour && $date_diff['day']<=$trigger_execution_day) {
        //     return true;
        // }else{
        //     return false;
        // }
    }

    public function dateDiff($date1, $date2)
    {
        $t1 = strtotime($date1);
        $t2 = strtotime($date2);

        $delta_T = ($t2 - $t1);

        $day = round(($delta_T % 604800) / 86400);
        $hours = round((($delta_T % 604800) % 86400) / 3600);
        $minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60);
        $sec = round((((($delta_T % 604800) % 86400) % 3600) % 60));

        return array(
            'day' => $day,
            'hours' => $hours,
            'minutes' => $minutes,
            'sec' => $sec,
        );
    }
    public function getServiceData(Request $request)
    {
        $service_id = $request->service_id;
        // $service_traking_number = $request->service_traking_number;
        // $service=null;
        $service = lv3_job::select('lv3_trigger_file_paths.*', 'lv3_jobs.*')
            ->leftJoin('lv3_trigger_file_paths', 'lv3_trigger_file_paths.lv3_service_id', '=', 'lv3_jobs.lv3_service_id')
            ->where('lv3_jobs.lv3_service_id', $service_id)->first();
        return response()->json(['service' => $service]);
        // if($service_traking_number==1){
        //     $service=lv3_job::select('lv3_service_id','batch_file_path','execution','job_execution_flag')->where('lv3_service_id',$service_id)->first();
        // }
        // if($service_traking_number==2){
        //     $service=lv3_trigger_file_path::select('lv3_trigger_file_paths.lv3_service_id','lv3_trigger_file_paths.check_folder_path','lv3_trigger_file_paths.path_execution_flag',
        //     'lv3_jobs.batch_file_path')
        //     ->join('lv3_jobs','lv3_jobs.lv3_service_id','=','lv3_trigger_file_paths.lv3_service_id')
        //     ->where('lv3_trigger_file_paths.lv3_service_id',$service_id)->first();
        // }
        // if($service_traking_number==3){
        //     \Log::info($service_id);
        //     $service=lv3_job::select('lv3_service_id','job_execution_flag','execution','cmn_scenario_id','batch_file_path','append')
        //     ->where('lv3_jobs.lv3_service_id',$service_id)->first();
        // }
        // if($service_traking_number==4){
        //     $service=lv3_trigger_file_path::select('lv3_service_id','api_folder_path','api_url','path_execution_flag')->where('lv3_service_id',$service_id)->first();
        // }
        // if($service_traking_number==5){
        //     $service=lv3_trigger_file_path::select('lv3_trigger_file_paths.lv3_service_id','lv3_trigger_file_paths.check_folder_path',
        //     'lv3_jobs.job_execution_flag','lv3_jobs.batch_file_path','lv3_jobs.execution')
        //     ->join('lv3_jobs','lv3_jobs.lv3_service_id','=','lv3_trigger_file_paths.lv3_service_id')
        //     ->where('lv3_trigger_file_paths.lv3_service_id',$service_id)->first();
        // }
        // if($service_traking_number==6){
        //     $service=lv3_trigger_file_path::select('lv3_trigger_file_paths.lv3_service_id','lv3_trigger_file_paths.check_folder_path',
        //     'lv3_jobs.job_execution_flag','lv3_jobs.batch_file_path','lv3_jobs.execution')
        //     ->join('lv3_jobs','lv3_jobs.lv3_service_id','=','lv3_trigger_file_paths.lv3_service_id')
        //     ->where('lv3_trigger_file_paths.lv3_service_id',$service_id)->first();
        // }
        // return response()->json(['service'=>$service]);
    }

    public function historyCreate(Request $request)
    {
        $service_id = $request->service_id;
        $status = $request->status;
        $history_message = $request->history_message;

        $execute_type = $request->process_type;
        if ($execute_type == "Auto") {
            $execute_type = "自動";
        } elseif ($execute_type == "Manual") {
            $execute_type = "手動";
        } else {
            $execute_type = "自動";
        }

        lv3_history::insert([
            // 'user_id' => $user_id,
            'lv3_service_id' => $service_id,
            // 'execute_name' => $execute_name,
            'execute_type' => $execute_type,
            'status' => $status,
            'message' => $history_message,
        ]);
        return \response()->json(['message' => 'success', 'status_code' => 200, 'class_name' => 'alert-success']);
    }

    public function jobScenario(Request $request)
    {
        // return $request->all();
        $cs = new Cmn_ScenarioController();
        $ret = $cs->exec($request);
        \Log::debug($ret->getContent());
        $ret = json_decode($ret->getContent(), true);
        if (1 === $ret['status']) {
            // sceanario exec error
            \Log::error($ret['message']);
            return $ret;
        }
        return response()->json($ret);
    }
    public function getShipmentFile(Request $request)
    {
        // return $request->all();
        // $file_path_id = $request->file_path_id;
        $url_path = \Config::get('app.url') . 'storage/app/public/Shipment_CSV/moved/';
        $path = \storage_path('/app/public/Shipment_CSV/');
        $files = array_values(array_diff(scandir($path), array('.', '..')));
        // $files = array_values($files);
        // $files = scandir($path);
        $files_array = array();
        if (!empty($files)) {
            for ($i = 0; $i < count($files); $i++) {
                if (is_file($path . $files[$i])) {
                    $tmp_array['file_name'] = $files[$i];
                    $tmp_array['file_path'] = $url_path . $files[$i];

                    rename($path . $files[$i], $path . 'Moved/' . $files[$i]);
                    // $myfile = file_get_contents($path . $files[$i], FILE_USE_INCLUDE_PATH);
                    // $myfile = readfile($path . $files[$i]);
                    // $tmp_array['file_data'] = $myfile;

                    $files_array[] = $tmp_array;
                }

            }
        } else {
            $this->message = "フォルダが空です";
            $this->status_code = 400;
            // return \response()->json(['message'=>'Directory empty','status_code'=>400]);
            return \response()->json(['message' => $this->message, 'status_code' => $this->status_code]);
        }
        // return $files_array;

        if (!empty($files_array)) {

            // history::insert([
            //     'file_path_id' => $file_path_id,
            //     'execute_name' => '確定データ',
            //     'status' => "Success",
            // ]);
            $this->message = "ファイルが見つかりました。";
            $this->status_code = 200;
            // return \response()->json(['message'=>'File found','status_code'=>200,'files_array'=>$files_array]);
            // return \response()->json(['message'=>$this->message,'status_code'=>$this->status_code,'files_array'=>$files_array]);
        } else {
            $this->message = "ファイルが見つかりませんでした。";
            $this->status_code = 401;
            // return \response()->json(['message'=>$this->message,'status_code'=>$this->status_code]);
        }
        return \response()->json(['message' => $this->message, 'status_code' => $this->status_code, 'files_array' => $files_array]);
        // $files_array = array_values($files_array);

        // return $files_array;
    }
    public function setScheduleFileData(Request $request)
    {
        $user_id = $request->user_id;
        $schedule_id = $request->schedule_id;
        $time = $request->time;
        $status = $request->status;
        schedule::where('schedule_id', $schedule_id)->update(['disabled' => 1]);
        return $request->all();
    }

    public function fileSave(Request $request)
    {
        //    return $request->all();

        $file_path_id = $request->file_path_id;
        // history::insert([
        //     'file_path_id' => $file_path_id,
        //     'execute_name' => '発注データ',
        //     'status' => "Success",
        // ]);
        // return $request->all();
        if ($request->hasFile('upfile')) {

            // save image file to storage
            $file = $request->file('upfile');
            $file_name = $file->getClientOriginalName();

            $file->storeAs(config('const.TEST_FILE_UPLOAD'), $file_name);
            return response()->json(['fileName' => $file_name]);
            \Log::info('New Image Name' . $file_name);

        }
    }

    public function addCustomer(Request $request)
    {
        // return $request->all();
        $user_id = $request->user_id;
        $customer_id = $request->customer_id;
        $customer_name = $request->customer_name;
        $partner_code = $request->partner_code;

        $customer_array = array(
            'user_id' => $user_id,
            'customer_name' => $customer_name,
            'partner_code' => $partner_code,
        );
        if ($customer_id != null) {
            $customer_info = customer::where('customer_id', $customer_id)->first();
            if ($customer_info['partner_code'] != $partner_code) {
                if (customer::where('user_id', $user_id)->where('partner_code', $partner_code)->exists()) {
                    // $this->message='Partner code alrady exists';
                    $this->message = '登録済みの取引先コードです。';
                    $this->status_code = 403;
                    $this->class_name = 'alert-danger';
                    return \response()->json(['message' => $this->message, 'status_code' => $this->status_code, 'class_name' => $this->class_name, 'lst_customer_id' => $this->lst_customer_id]);
                }
            }
            // $this->message='Update Success';
            $this->message = '更新完了';
            $this->status_code = 200;
            $this->class_name = 'alert-success';
            $this->flag = 1;
            $this->lst_customer_id = $customer_id;
            customer::where('customer_id', $customer_id)->update($customer_array);
        } else {
            if (customer::where('user_id', $user_id)->where('partner_code', $partner_code)->exists()) {
                // $this->message='Partner code alrady exists';
                $this->message = '登録済みの取引先コードです。';
                $this->status_code = 403;
                $this->class_name = 'alert-danger';
                // return \response()->json(['message'=>$this->message,'status_code'=>$this->status_code,'class_name'=>$this->class_name]);
            } else {
                $this->lst_customer_id = customer::insertGetId($customer_array);
                // $this->message='Insert Success';
                $this->message = '登録完了';
                $this->status_code = 200;
                $this->class_name = 'alert-success';
                $this->flag = 0;
            }
        }

        return \response()->json(['message' => $this->message, 'status_code' => $this->status_code, 'class_name' => $this->class_name, 'flag' => $this->flag, 'lst_customer_id' => $this->lst_customer_id]);
    }

    public function deleteCustomer(Request $request)
    {
        $customer_id = $request->customer_id;
        customer::where('customer_id', $customer_id)->delete();
        $customer_services = service::select('service_id')->where('customer_id', $customer_id)->get();
        foreach ($customer_services as $key => $customer_service) {
            service::where('customer_id', $customer_id)->delete();
            schedule::where('service_id', $customer_service->service_id)->delete();
            if (file_path::where('service_id', $customer_service->service_id)->exists()) {
                $file_path = file_path::where('service_id', $customer_service->service_id)->first();
                history::where('file_path_id', $file_path['file_path_id'])->delete();
            }
            file_path::where('service_id', $customer_service->service_id)->delete();
            job::where('service_id', $customer_service->service_id)->delete();
        }
        $this->message = '削除が完了しました。';
        $this->status_code = 200;
        $this->class_name = 'alert-success';
        return \response()->json(['message' => $this->message, 'status_code' => $this->status_code, 'class_name' => $this->class_name]);
    }
    public function deleteService(Request $request)
    {
        $service_id = $request->service_id;
        lv3_service::where('lv3_service_id', $service_id)->delete();
        $this->message = '削除が完了しました。';
        $this->status_code = 200;
        $this->class_name = 'alert-success';
        return \response()->json(['message' => $this->message, 'status_code' => $this->status_code, 'class_name' => $this->class_name]);
    }

    public function job_list(Request $request)
    {
        return $request->all();
    }
}
