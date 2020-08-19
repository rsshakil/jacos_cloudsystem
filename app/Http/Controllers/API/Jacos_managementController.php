<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class Jacos_managementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::table('byr_buyers')
        ->leftJoin('cmn_companies', 'byr_buyers.cmn_company_id', '=', 'cmn_companies.cmn_company_id')
        ->select('byr_buyers.super_code', 'cmn_companies.company_name','cmn_companies.cmn_company_id','byr_buyers.byr_buyer_id')
        ->get();
        return response()->json(['company_list'=>$result]);
    }

    public function company_user_list($byr_buyer_id){
        $result = DB::table('byr_buyers')
        ->join('cmn_companies', 'byr_buyers.cmn_company_id', '=', 'cmn_companies.cmn_company_id')
        ->join('cmn_companies_users', 'cmn_companies_users.cmn_company_id', '=', 'cmn_companies.cmn_company_id')
        ->join('adm_users', 'adm_users.id', '=', 'cmn_companies_users.adm_user_id')
        ->select('adm_users.*')
        ->where('byr_buyers.byr_buyer_id',$byr_buyer_id)
        ->get();
        return response()->json(['user_list'=>$result]); 
    }

    public function company_partner_list($byr_buyer_id){
      $result = DB::table('cmn_connects')
        ->leftJoin('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
        ->leftJoin('cmn_companies', 'byr_buyers.cmn_company_id', '=', 'cmn_companies.cmn_company_id')
        ->select('cmn_connects.byr_buyer_id','byr_buyers.super_code', 'cmn_companies.company_name', 'cmn_companies.jcode','cmn_connects.partner_code','cmn_connects.is_active')
        ->where('cmn_connects.byr_buyer_id',$byr_buyer_id)
        ->get();
        return response()->json(['partner_list'=>$result]); 
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
