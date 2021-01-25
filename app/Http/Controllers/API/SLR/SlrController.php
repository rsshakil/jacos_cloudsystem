<?php

namespace App\Http\Controllers\API\SLR;

use App\Http\Controllers\API\AllUsedFunction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMN\cmn_companies_user;
use App\Models\ADM\User;

class SlrController extends Controller
{
    private $all_used_fun;

    public function __construct()
    {
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
    public function get_selected_byr_info($byr_buyer_id)
    {

        $byr_info = $this->all_used_fun->get_byr_info_by_byr_buyer_id($byr_buyer_id);

        return response()->json(['byr_info' => $byr_info]);
    }
    public function slr_management($adm_user_id){
        $authUser=User::find($adm_user_id);
        if(!$authUser->hasRole(config('const.adm_role_name'))){
            $cmn_company_info = cmn_companies_user::where('adm_user_id',$adm_user_id)->first();
            $cmn_company_id = $cmn_company_info->cmn_company_id;
        }

        $result = DB::table('cmn_companies')
        ->join('slr_sellers', 'slr_sellers.cmn_company_id', '=', 'cmn_companies.cmn_company_id')
        ->groupBy('cmn_companies.cmn_company_id');
        if(!$authUser->hasRole(config('const.adm_role_name'))){
            $result = $result->where('cmn_companies.cmn_company_id',$cmn_company_id);
        }
        $result= $result->get();
        return response()->json(['slr_list'=>$result]);
    }

}
