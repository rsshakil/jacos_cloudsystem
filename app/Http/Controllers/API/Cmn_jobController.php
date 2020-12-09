<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CMN\cmn_job;
use App\Models\BYR\byr_buyer;
use App\Models\SLR\slr_seller;
use App\Models\CMN\cmn_company;
use App\Models\ADM\User;
use DB;
use Auth;

class Cmn_jobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $byr_company_list = byr_buyer::get()->byr_company;
        $byr_company_list = byr_buyer::select('byr_buyers.super_code','cmn_companies.company_name','cmn_companies.cmn_company_id')
        ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')->get();
        $slr_company_list = slr_seller::select('cmn_companies.company_name','cmn_companies.jcode','cmn_companies.cmn_company_id')
        ->join('cmn_companies','cmn_companies.cmn_company_id','=','slr_sellers.cmn_company_id')->get();

        $job_list = cmn_job::select('cmn_jobs.*','cmn_scenarios.*','cmn_companies.company_name as byr_company','byr_buyers.super_code','slr_companies.company_name as slr_company','slr_companies.jcode')
        ->join('cmn_scenarios', 'cmn_jobs.cmn_scenario_id', '=', 'cmn_scenarios.cmn_scenario_id')
        ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'cmn_jobs.cmn_connect_id')
        ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
        ->join('slr_sellers', 'slr_sellers.slr_seller_id', '=', 'cmn_connects.slr_seller_id')
        ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
        ->join('cmn_companies as slr_companies', 'slr_companies.cmn_company_id', '=', 'slr_sellers.cmn_company_id')
        
        ->get();
        return response()->json(['job_list'=>$job_list,'byr_company_list'=>$byr_company_list,'slr_company_list'=>$slr_company_list]);
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
    public function show($id)
    {
        //
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

    public function exec(Request $request)
    {
        // return "OK";
        // return $request->all();
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
        // return $request->all();
        // scenario info check
        // byr_buyers.spr_code
        // cmn_connects.partner_code
        // cmn_jobs.class
        // cmn_job_id
        // $sc=null;
        // return $request->all();
        // if (isset($request['spr_code'])) {
            // return $request->all();
        // }
        // return $array = json_decode(json_encode($request->all()), true);
        // // return array_keys((array) $request);
        // if (array_key_exists('cmn_job_id',$request)) {
        //     return $request->all();
        // }else{
        //     return "Not Found";
        // }
        $request_all=$request->all();
        if (array_key_exists("spr_code",$request_all) && array_key_exists("partner_code",$request_all) && array_key_exists("class",$request_all)) {
            
            $spr_code=$request->spr_code;
            $partner_code=$request->partner_code;
            $class=$request->class;
            $sc=cmn_job::select('cmn_jobs.cmn_connect_id','cmn_scenarios.*')
            ->join('cmn_scenarios', 'cmn_jobs.cmn_scenario_id', '=', 'cmn_scenarios.cmn_scenario_id')
            ->join('cmn_connects','cmn_connects.cmn_connect_id','=','cmn_jobs.cmn_connect_id')
            ->join('byr_buyers','cmn_connects.byr_buyer_id','=','byr_buyers.byr_buyer_id')
            ->where([
                ['byr_buyers.spr_code','=',$spr_code],
                ['cmn_connects.partner_code','=',$partner_code],
                ['cmn_jobs.class','=',$class],
            ])
            ->first();
        }else if (array_key_exists("cmn_job_id",$request_all)){
            $cmn_job_id=$request->cmn_job_id;
            $sc = cmn_job::select('cmn_jobs.cmn_connect_id','cmn_scenarios.*')
            ->join('cmn_scenarios', 'cmn_jobs.cmn_scenario_id', '=', 'cmn_scenarios.cmn_scenario_id')
            ->where('cmn_jobs.cmn_job_id', $cmn_job_id)->where('cmn_jobs.is_active',1)->first();
        }
        // return $sc;
        \Log::info($sc);
        // return response()->json($sc);
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
        return $ret;
    }

   
    public function slr_job_list_by_seller_id($slr_seller_id){
        $sc = cmn_job::select('cmn_jobs.*','cmn_scenarios.*')
        ->join('cmn_scenarios', 'cmn_jobs.cmn_scenario_id', '=', 'cmn_scenarios.cmn_scenario_id')
        ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'cmn_jobs.cmn_connect_id')
        ->where('cmn_connects.slr_seller_id', $slr_seller_id)->get();
        return response()->json(['slr_job_list'=>$sc]);
    }
}
