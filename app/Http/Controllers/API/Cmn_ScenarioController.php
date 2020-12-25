<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_scenario_history;

class Cmn_ScenarioController extends Controller
{
    private $sc_history_array;
    public function __construct()
    {
        $this->sc_history_array = array();
    }

    /**
     * Execute scenario
     *
     * @return \Illuminate\Http\Response
     */
    public function exec(Request $request)
    {
        \Log::debug('scenario exec start---------------');
        $cmn_scenario_id=$request->scenario_id;
        \Log::debug('scenario_id:'.$cmn_scenario_id);
        $this->sc_history_array['cmn_scenario_id']=$request->scenario_id;
        if (array_key_exists('order_id', $request->all())) {
            $this->sc_history_array['byr_order_id']=$request->order_id;
            // $this->byr_order_id = $request->order_id;
        }
        if (array_key_exists('job_id', $request->all())) {
            // $this->cmn_job_id = $request->job_id;
            $this->sc_history_array['cmn_job_id']=$request->job_id;
        }

        $user = DB::table('adm_users')->where('email', $request->email)->first();
        if (!$user) {
            self::history_create('error', "User Name Error");
            return ['status'=>1, 'message' => 'Authentication faild!'];
        }
        if (!\Hash::check($request->password, $user->password)) {
            self::history_create('error', "Password Error");
            return ['status'=>1, 'message' => 'Authentication faild!'];
        }
        $this->sc_history_array['adm_user_id']=$user->id;
        // scenario info check
        $sc = cmn_scenario::where('cmn_scenario_id', $cmn_scenario_id)->first();
        \Log::info($sc);
        if (!empty($sc)) {
            // scenario call
            if (!file_exists(app_path().'/'.$sc->file_path.'.php')) {
                \Log::error('Scenario file is not exist!:'.$sc->file_path);
                self::history_create('error', 'Scenario file is not exist!'.$sc->file_path);
                return ['status'=>'1','message'=>'Scenario file is not exist!'.$sc->file_path];
            }
            // ファイル読み込み
        
            // $sc_obj = new ouk_order_toj();//$sc->file_path;
            $customClassPath = "\\App\\";
            $nw_f_pth = explode('/', $sc->file_path);
            foreach ($nw_f_pth as $p) {
                $customClassPath .= $p.'\\';
            }
            $customClassPath = rtrim($customClassPath, "\\");
            $sc_obj = new $customClassPath;
            // シナリオ実行
            if (!method_exists($sc_obj, 'exec')) {
                \Log::error('scenario exec error');
                self::history_create('error', "Scenario exec function is not exist!");
                return ['status'=>'1','message'=>'Scenario exec function is not exist!'];
            }
            $ret = $sc_obj->exec($request, $sc);
            // if ($ret !== 0) {
            //     // error
            //     self::history_create('error',"scenario exec error!");
            //     \Log::debug('scenario exec error');
            // } else {
            //     // success
            //     self::history_create('success',"scenario exec success");
            //     \Log::debug('scenario exec success');
            // }
            \Log::debug('scenario exec end  ---------------');
            self::history_create('success', "scenario exec success");
            return $ret;
        } else {
            self::history_create('error', "No scenario found");
            return ['status'=>1, 'message' => 'No scenario found!'];
        }
    }

    private function history_create($status, $information)
    {
        $this->sc_history_array['status']=$status;
        $this->sc_history_array['information']=$information;
        cmn_scenario_history::insert($this->sc_history_array);
    }

    public function exec_demo(Request $request, $id)
    {
        return response()->json(['req'=>$request->all()]);
    }
    public function get_scenario_list()
    {
        $result = cmn_scenario::select('cmn_scenarios.*', 'byr_buyers.super_code')
        ->leftJoin('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_scenarios.byr_buyer_id')
        ->leftJoin('slr_sellers', 'slr_sellers.slr_seller_id', '=', 'cmn_scenarios.slr_seller_id')
        ->get();
        return response()->json(['scenario_list'=>$result]);
    }
}
