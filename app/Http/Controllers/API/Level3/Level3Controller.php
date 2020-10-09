<?php

namespace App\Http\Controllers\API\Level3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ADM\User;
use App\Models\Lv3\lv3_history;
use App\Models\Lv3\lv3_trigger_schedule;
use App\Models\CMN\cmn_companies_user;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class Level3Controller extends Controller
{
    private $message;
    private $status_code;
    private $class_name;
    private $lst_customer_id;
    private $lst_service_id;
    private $flag;
    public function __ApiController()
    {
        $this->message = '';
        $this->status_code = '';
        $this->class_name = '';
        $this->lst_customer_id = '';
        $this->lst_service_id = '';
        $this->flag = '';
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
        $user_id=$request->user_id;
        $all_history = lv3_history::select('lv3_histories.*', 'lv3_services.lv3_service_id','lv3_services.service_name', 'cmn_companies.company_name', 'cmn_connects.partner_code')
            ->join('lv3_services', 'lv3_histories.lv3_service_id', '=', 'lv3_services.lv3_service_id')
            ->join('cmn_connects','lv3_services.cmn_connect_id','=','cmn_connects.cmn_connect_id')
            ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
            ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')
            ->where('lv3_services.adm_user_id', $user_id)
            ->orderBy('lv3_histories.lv3_history_id','DESC')
            ->take(100)->get();
            \Log::info($all_history);
        return \response()->json(['histories' => $all_history]);
    }

    public function getCustomer(Request $request)
    {
        $user_id = $request->user_id;
        $customers_data = cmn_companies_user::select('cmn_connects.partner_code','cmn_companies.company_name')
        ->join('slr_sellers','slr_sellers.cmn_company_id','=','cmn_companies_users.cmn_company_id')
        ->join('cmn_connects','cmn_connects.slr_seller_id','=','slr_sellers.slr_seller_id')
        ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
        ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')
        ->where('cmn_companies_users.adm_user_id', $user_id)->get();
        \Log::info($customers_data);
        return response()->json(['customers_data' => $customers_data]);
    }

    public function scheduleData(Request $request)
    {
        // return $request->all();
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
        $job_info=job::where('service_id',$service_id)->first();
// return $schedule_array;
        return response()->json(['schedule_array' => $schedule_array, 'file_path_info' => $file_path_info,'job_info'=>$job_info]);
        // return $schedule_array;

    }
    public function scheduleTimeData(Request $request){
        $service_id = $request->service_id;
        $schedule_time_data = schedule::select('schedule_id','weekday','time')->where('service_id', $service_id)
        ->where('weekday','!=', 0)->get();

        $schedule_array = array();
        $active_weekday_array = array();

        if (!empty($schedule_time_data)) {
            foreach ($schedule_time_data as $key => $value) {
                $weekday=str_split($this->binary_format($this->decimal_to_binary($value->weekday)));
                $key_day = array_search('1', $weekday);

                foreach ($weekday as $key1 => $value1) {
                    if ($value1==1) {
                        $active_weekday_array[]=$key1;
                    }
                }

                $test['schedule_id'] = $value->schedule_id;
                // $test['weekday'] = str_split($this->binary_format($this->decimal_to_binary($value->weekday)));
                $test['weekday'] = $active_weekday_array;
                $test['time'] = $value->time;
                // $test['disabled'] = $value->disabled;
                $test['original_weekday'] = $value->weekday;
                $schedule_array[] = $test;
                $active_weekday_array=[];
            }
        }
        return response()->json(['schedule_time_data' => $schedule_array]);
    }

    public function setScheduleData(Request $request)
    {
        // return $request->all();
        $user_id = $request->user_id;
        $customer_id = $request->customer_id;
        $service_id = $request->service_id;
        $data_array = $request->data_array;
        $time_array = $request->time_array;
        $time_sp_array = $request->time_sp_array;
        $last_day_array = $request->last_day_array;
        $day_array = $request->day_array;

        $insert_first_array = array();
        $insert_second_array = array();

        for ($i = 0; $i < count($data_array); $i++) {
            $test_first['service_id'] = $service_id;
            // $test_first['user_id'] = $user_id;
            $test_first['customer_id'] = $customer_id;
            $test_first['name'] = "No Name";
            $test_first['weekday'] = $this->binary_to_decimal($data_array[$i]);
            $test_first['time'] = $time_array[$i];
            $test_first['disabled'] = 0;
            $insert_first_array[] = $test_first;
        }
        for ($j = 0; $j < count($last_day_array); $j++) {
            $test_second['service_id'] = $service_id;
            // $test_second['user_id'] = $user_id;
            $test_second['customer_id'] = $customer_id;
            $test_second['name'] = "No Name";
            $test_second['day'] = $day_array[$j];
            $test_second['time'] = $time_sp_array[$j];
            $test_second['last_day'] = $last_day_array[$j];
            $test_second['disabled'] = 0;
            $insert_second_array[] = $test_second;
        }
        // return $insert_array;
        schedule::where('customer_id', $customer_id)->where('service_id', $service_id)->delete();
        schedule::insert($insert_first_array);
        schedule::insert($insert_second_array);
        // return response()->json(['message' => 'Schedule updated', 'class_name' => 'alert-success']);
        return response()->json(['message' => '更新完了', 'class_name' => 'alert-success']);

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

    public function getFilePath($user_id, $service_id)
    {
        return file_path::where('service_id', $service_id)->first();
    }
    public function setFilePath(Request $request)
    {
        // return $request->all();
        $user_id = $request->user_id;
        // $customer_id=$request->customer_id;
        $service_id = $request->service_id;
        $path_execution_flag = $request->path_execution_flag;
        // $shipment_path_execute=$request->shipment_path_execute;
        $file_source_path = $request->file_source_path;
        $file_move_path = $request->file_move_path;
        $api_url = $request->api_url;
        $api_folder_path = $request->api_folder_path;
        $file_path_array = array(
            // 'customer_id'=>$customer_id,
            'service_id' => $service_id,
            'check_folder_path' => $file_source_path,
            'moved_folder_path' => $file_move_path,
            'api_url'=>$api_url,
            'api_folder_path'=>$api_folder_path,
            'path_execution_flag' => $path_execution_flag,
        );
        if (file_path::where('service_id', $service_id)->exists()) {
            file_path::where('service_id', $service_id)->update($file_path_array);
        } else {
            file_path::insert($file_path_array);
        }
        // return \response()->json(['message'=>'File path saved','class_name'=>'alert-success']);
        return \response()->json(['message' => 'ファイルパスを保存しました。', 'class_name' => 'alert-success']);
    }

    public function setJobData(Request $request)
    {
        // return $request->all();
        $job_id = $request->job_update_id;
        $service_id = $request->service_id;
        $api_path = $request->api_path;
        $batch_file_path = $request->batch_file_path;
        $job_execution_flag = $request->job_execution_flag;
        $execution = $request->execution;
        $job_array = array(
            'service_id' => $service_id,
            'api_path' => $api_path,
            'batch_file_path' => $batch_file_path,
            'job_execution_flag' => $job_execution_flag,
            'execution' => $execution,
        );

        if ($job_id != null) {
            job::where('job_id', $job_id)->update($job_array);
            $this->message = 'jobを作成しました。';
            $this->status_code = 200;
            $this->class_name = 'alert-success';
        } else {
            job::insert($job_array);
            $this->message = 'jobを更新しました。';
            $this->status_code = 200;
            $this->class_name = 'alert-success';
        }
        return response()->json(['message' => $this->message,'status_code'=>$this->status_code,'class_name'=>$this->class_name]);
    }
    
    public function getServiceData(Request $request){
        // return $request->all();
        $service_id = $request->service_id;
        $service = $request->service;
        if($service==1){
            $service1=job::select('service_id','batch_file_path','execution','job_execution_flag')->where('service_id',$service_id)->first();
            return response()->json(['service1'=>$service1]);
        }
        if($service==2){
            $service2=file_path::select('file_paths.service_id','file_paths.check_folder_path','file_paths.path_execution_flag',
            'jobs.batch_file_path')
            ->join('jobs','jobs.service_id','=','file_paths.service_id')
            ->where('file_paths.service_id',$service_id)->first();
            return response()->json(['service2'=>$service2]);
        }
        if($service==3){
            $service3=file_path::select('file_paths.service_id','file_paths.check_folder_path','file_paths.moved_folder_path',
            'file_paths.path_execution_flag','jobs.api_path','jobs.execution')
            ->join('jobs','jobs.service_id','=','file_paths.service_id')
            ->where('file_paths.service_id',$service_id)->first();
            return response()->json(['service3'=>$service3]);
        }
        if($service==4){
            $service4=file_path::select('service_id','api_folder_path','api_url','path_execution_flag')->where('service_id',$service_id)->first();
            return response()->json(['service4'=>$service4]);
        }
        if($service==5){
            $service5=file_path::select('file_paths.service_id','file_paths.check_folder_path',
            'jobs.job_execution_flag','jobs.batch_file_path','jobs.execution')
            ->join('jobs','jobs.service_id','=','file_paths.service_id')
            ->where('file_paths.service_id',$service_id)->first();
            return response()->json(['service5'=>$service5]);
        }
        if($service==6){
            // $service6=job::select('service_id','batch_file_path','execution','job_execution_flag')->where('service_id',$service_id)->first();

            $service6=file_path::select('file_paths.service_id','file_paths.check_folder_path',
            'jobs.job_execution_flag','jobs.batch_file_path','jobs.execution')
            ->join('jobs','jobs.service_id','=','file_paths.service_id')
            ->where('file_paths.service_id',$service_id)->first();
            return response()->json(['service6'=>$service6]);
        }
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

    public function getShipmentFile(Request $request)
    {
        // return $request->all();
        $file_path_id = $request->file_path_id;
        $url_path = \Config::get('app.url') . 'public/backend/test_csv/moved/';
        $path = \public_path() . '/backend/test_csv/';
        $files = array_values(array_diff(scandir($path), array('.', '..')));
        // $files = array_values($files);
        // $files = scandir($path);
        $files_array = array();
        if (!empty($files)) {
            for ($i = 0; $i < count($files); $i++) {
                if (is_file($path . $files[$i])) {
                    $tmp_array['file_name'] = $files[$i];
                    $tmp_array['file_path'] = $url_path . $files[$i];
                    $files_array[] = $tmp_array;
                    rename($path . $files[$i], $path . 'Moved/' . $files[$i]);
                }

            }
        } else {
            $this->message = "フォルダが空です";
            $this->status_code = 400;
            // return \response()->json(['message'=>'Directory empty','status_code'=>400]);
            return \response()->json(['message' => $this->message, 'status_code' => $this->status_code]);
        }

        if (!empty($files_array)) {

            history::insert([
                'file_path_id' => $file_path_id,
                'execute_name' => '確定データ',
                'status' => "Success",
            ]);
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
            if (customer::where('user_id',$user_id)->where('partner_code', $partner_code)->exists()) {
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
    public function addService(Request $request)
    {
        // return $request->all();
        $user_id = $request->user_id;
        $service_id = $request->service_id;
        $customer_id = $request->customer_id;
        $service_name = $request->service_name;
        // $service_count=service::where('customer_id', $customer_id)->count();
        // if($service_count>=3){
        //     return \response()->json(['message' => "Service full in database", 'status_code' => 403, 'class_name' => 'alert-danger']);
        // }

        $service_array = array(
            'customer_id' => $customer_id,
            'service_name' => $service_name,
        );
        // return $service_array;
        if ($service_id != null) {
            $service_info = service::where('service_id', $service_id)->first();
            if ($service_info['service_name'] != $service_name) {
                if (service::where('customer_id', $customer_id)->where('service_name', $service_name)->exists()) {
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
            service::where('service_id', $service_id)->update($service_array);
        } else {
            if (service::where('customer_id', $customer_id)->where('service_name', $service_name)->exists()) {
                // $this->message='Partner code alrady exists';
                $this->message = 'Service name already exists';
                $this->status_code = 403;
                $this->class_name = 'alert-danger';
                // return \response()->json(['message'=>$this->message,'status_code'=>$this->status_code,'class_name'=>$this->class_name]);
            } else {
                $this->lst_service_id = service::insertGetId($service_array);
                // $this->message='Insert Success';
                $this->message = '登録完了';
                $this->status_code = 200;
                $this->class_name = 'alert-success';
                $this->flag = 0;
            }
        }

        return \response()->json(['message' => $this->message, 'status_code' => $this->status_code, 'class_name' => $this->class_name, 'flag' => $this->flag, 'lst_service_id' => $this->lst_service_id]);
    }
    public function deleteCustomer(Request $request)
    {
        $customer_id = $request->customer_id;
        customer::where('customer_id', $customer_id)->delete();
        $customer_services=service::select('service_id')->where('customer_id',$customer_id)->get();
        foreach ($customer_services as $key => $customer_service) {
            service::where('customer_id',$customer_id)->delete();
            schedule::where('service_id',$customer_service->service_id)->delete();
            if(file_path::where('service_id',$customer_service->service_id)->exists()){
                $file_path=file_path::where('service_id',$customer_service->service_id)->first();
                history::where('file_path_id',$file_path['file_path_id'])->delete();
            }
            file_path::where('service_id',$customer_service->service_id)->delete();
            job::where('service_id',$customer_service->service_id)->delete();
        }
        $this->message = '削除が完了しました。';
        $this->status_code = 200;
        $this->class_name = 'alert-success';
        return \response()->json(['message' => $this->message, 'status_code' => $this->status_code, 'class_name' => $this->class_name]);
    }
    public function deleteService(Request $request)
    {
        $service_id = $request->service_id;
        service::where('service_id', $service_id)->delete();
        $this->message = '削除が完了しました。';
        $this->status_code = 200;
        $this->class_name = 'alert-success';
        return \response()->json(['message' => $this->message, 'status_code' => $this->status_code, 'class_name' => $this->class_name]);
    }
    public function historyCreate(Request $request)
    {
        // return $request->all();
        $user_id=$request->user_id;
        $service_id=$request->service_id;
        $execute_name=$request->execute_name;
        $status=$request->status;
        $history_message=$request->history_message;

        $execute_type = $request->process_type;
        if ($execute_type=="Auto") {
            $execute_type="自動";
        }elseif($execute_type=="Manual") {
            $execute_type="手動";
        }else{
            $execute_type="自動";
        }
        
        history::insert([
            'user_id' => $user_id,
            'service_id' => $service_id,
            'execute_name' => $execute_name,
            'execute_type' => $execute_type,
            'status' => $status,
            'message' => $history_message,
        ]);
        return \response()->json(['message' => 'success', 'status_code' => 200, 'class_name' => 'alert-success']);
    }
    
    public function showServiceData(Request $request)
    {
        $customer_id = $request->customer_id;
        $all_service_data = service::where('customer_id', $customer_id)->get();
        return \response()->json(['all_service_data' => $all_service_data]);
    }
    public function job_list(Request $request){
        return $request->all();
    }
    private function binary_to_decimal($binary)
    {
        return bindec($binary);
    }
    private function decimal_to_binary($decimal)
    {
        $bos = null;
        while ($decimal >= 1) {$bin = $decimal % 2;
            $decimal = round($decimal / 2, 0,
                PHP_ROUND_HALF_DOWN);
            $bos .= $bin;
        }
        return strrev($bos);

    }
    private function binary_format($binary_number)
    {
        $binary_length = strlen($binary_number);

        $formated_binary_number = null;
        if ($binary_length < 7) {
            $addable = 7 - $binary_length;
            $formated_binary_number = str_repeat('0', $addable) . $binary_number;
        } else {
            $formated_binary_number = $binary_number;
        }
        return $formated_binary_number;
    }
}
