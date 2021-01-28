<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\AllUsedFunction;
use App\Models\ADM\User;
use App\Models\CMN\cmn_scenario;

class ShipmentConroller extends Controller
{
    public function shipmentCSVCreate(Request $request){
        if(isset($request->email) && isset($request->password)){
            $user = User::where('email', '=', $request->email)->first();
            if (!$user) {
                return ['status'=>1, 'message' => 'Authentication faild!'];
            }
            if (!Hash::check($request->password, $user->password)) {
                return ['status'=>1, 'message' => 'Authentication faild!'];
            } 
        }else{
            return ['status'=>1, 'message' => 'Authentication faild!'];
        }
        $cmn_scenario_id=$request->scenario_id;
        $sc=cmn_scenario::where('cmn_scenario_id',$cmn_scenario_id)->first();
        // scenario call
        if (!file_exists(app_path().'/'.$sc->file_path.'.php')) {
            \Log::error('Scenario file is not exist!:'.$sc->file_path);
            return ['status'=>'1','message'=>'Scenario file is not exist!'.$sc->file_path];
        }
        // ファイル読み込み
        $customClassPath = "\\App\\";
        $nw_f_pth = explode('/',$sc->file_path);
        foreach($nw_f_pth as $p){
            $customClassPath .= $p.'\\';
        }
        $customClassPath = rtrim($customClassPath,"\\");
        $sc_obj = new $customClassPath;
        if (!method_exists($sc_obj, 'exec')) {
            \Log::error('scenario exec error');
            return ['status'=>'1','message'=>'Scenario exec function is not exist!'];
        }
        $ret = $sc_obj->exec($request,$sc);
        if ($ret !== 0) {
            // error
            \Log::debug('scenario exec error');
        } else {
            // success
            \Log::debug('scenario exec success');
        }
        return $ret;
    }
}
