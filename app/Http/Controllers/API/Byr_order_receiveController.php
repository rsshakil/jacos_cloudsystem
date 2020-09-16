<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AllUsedFunction;
use Illuminate\Http\Request;
use App\Models\CMN\cmn_tbl_col_setting;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_connect;
use App\Models\CMN\cmn_company;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
use App\Models\BYR\byr_receive;
use App\Models\BYR\byr_corrected_receive;
use App\Models\BYR\byr_buyer;
class Byr_order_receiveController extends Controller
{
    private $all_used_fun;

    public function __construct(){
        $this->all_used_fun = new AllUsedFunction();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    public function get_byr_order_receive_list($adm_user_id){
        $authUser=User::find($adm_user_id);
        $cmn_company_id = 0;
        if(!$authUser->hasRole('Super Admin')){
            $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            $byr_buyer_id = $cmn_company_info['byr_buyer_id'];
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
            $result = byr_receive::select('byr_receives.*','cmn_companies.company_name')
            ->join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_receives.cmn_connect_id')
            ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
            ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')
            ->where('byr_receives.cmn_connect_id',$cmn_connect_id)->get();
        }else{
            $result = byr_receive::select('byr_receives.*','cmn_companies.company_name')
            ->join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_receives.cmn_connect_id')
            ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
            ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')->get();
           
        }

        $byr_buyer =$this->all_used_fun->get_company_list($cmn_company_id);
        
        return response()->json(['order_list' => $result,'byr_buyer_list'=>$byr_buyer]);
    }

    public function get_byr_order_corrected_receive_list($adm_user_id){
        $authUser=User::find($adm_user_id);
        $cmn_company_id = 0;
        if(!$authUser->hasRole('Super Admin')){
            $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            $byr_buyer_id = $cmn_company_info['byr_buyer_id'];
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
            $result = byr_corrected_receive::select('byr_corrected_receives.*','cmn_companies.company_name')
            ->join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_corrected_receives.cmn_connect_id')
            ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
            ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')
            ->where('byr_corrected_receives.cmn_connect_id',$cmn_connect_id)->get();
            
        }else{
            $result = byr_corrected_receive::select('byr_corrected_receives.*','cmn_companies.company_name')
            ->join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_corrected_receives.cmn_connect_id')
            ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
            ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')->get();
           
        }

        $byr_buyer =$this->all_used_fun->get_company_list($cmn_company_id);
        
        return response()->json(['corrected_list' => $result,'byr_buyer_list'=>$byr_buyer]);
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
}
