<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
// use App\scenarios\ouk_order_toj;
use Illuminate\Http\Request;
use DB;
use App\Models\CMN\cmn_scenario;

class Cmn_ScenarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //test
        return ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($byr_order_id)
    {
        return ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Execute scenario
     *
     * @return \Illuminate\Http\Response
     */
    public function exec(Request $request, $id)
    {
        \Log::debug('scenario exec start---------------');
        // user info check
        \Log::debug($request);
        $user = DB::table('adm_users')->where('email',$request->email)->first();
        if (!$user) {
            return ['status'=>1, 'message' => 'Authentication faild!'];
        }
        if (!Hash::check($request->password, $user->password)) {
            return ['status'=>1, 'message' => 'Authentication faild!'];
        }
        // scenario info check
        $sc = cmn_scenario::where('cmn_scenario_id', $id)->first();
        \Log::info($sc);
        
        // scenario call
        if (!file_exists(app_path().'/'.$sc->file_path.'.php')) {
            \Log::error('Scenario file is not exist!:'.$sc->file_path);
            return ['status'=>'1','message'=>'Scenario file is not exist!'.$sc->file_path];
        }
        // ファイル読み込み
        
        // $sc_obj = new ouk_order_toj();//$sc->file_path;
        $customClassPath = "\\App\\";
        $nw_f_pth = explode('/',$sc->file_path);
        foreach($nw_f_pth as $p){
            $customClassPath .= $p.'\\';
        }
        $customClassPath = rtrim($customClassPath,"\\");
        $sc_obj = new $customClassPath;
        // シナリオ実行
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


        \Log::debug('scenario exec end  ---------------');
        return;
    }

    public function exec_demo(Request $request, $id)
    {
        return response()->json(['req'=>$request->all()]);
    }
    public function get_scenario_list(){
        $result = cmn_scenario::select('cmn_scenarios.*','byr_buyers.super_code')
        ->leftJoin('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_scenarios.byr_buyer_id')
        ->leftJoin('slr_sellers', 'slr_sellers.slr_seller_id', '=', 'cmn_scenarios.slr_seller_id')
        ->get();
        return response()->json(['scenario_list'=>$result]);
    }
}
