<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BYR\byr_buyer;
use App\Models\BYR\byr_item;
use App\Models\BYR\byr_item_class;
use App\Models\CMN\cmn_maker;
use App\Models\CMN\cmn_category;
use App\Models\CMN\cmn_category_description;
use App\Models\CMN\cmn_category_path;
use App\Models\BYR\byr_shop;
use App\Models\CMN\cmn_pdf_canvas;
use App\Models\CMN\cmn_tbl_col_setting;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_connect;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
use DB;
class Byr_itemController extends Controller
{
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
    public function get_all_master_item($adm_user_id){
        $authUser=User::find($adm_user_id);
        if(!$authUser->hasRole('Super Admin')){
            $cmn_company_info = cmn_companies_user::select('byr_buyers.cmn_company_id','byr_buyers.byr_buyer_id','cmn_connects.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
            ->join('cmn_connects', 'cmn_connects.byr_buyer_id', '=', 'byr_buyers.byr_buyer_id')
            ->where('cmn_companies_users.adm_user_id',$adm_user_id)->first();
            $cmn_company_id = $cmn_company_info->cmn_company_id;
            $byr_buyer_id = $cmn_company_info->byr_buyer_id;
            $cmn_connect_id = $cmn_company_info->cmn_connect_id;
        }

        if(!$authUser->hasRole('Super Admin')){
            $result = byr_item::select('byr_items.*','byr_item_classes.*','cmn_category_descriptions.category_name','cmn_category_descriptions.category_code','cmn_makers.maker_name_kana','cmn_makers.maker_name')
            ->join('byr_item_classes', 'byr_item_classes.byr_item_id', '=', 'byr_items.byr_item_id')
            ->join('cmn_makers', 'cmn_makers.cmn_maker_id', '=', 'byr_items.cmn_maker_id')
            ->join('cmn_category_descriptions', 'cmn_category_descriptions.cmn_category_id', '=', 'byr_items.cmn_category_id')
            ->where('byr_items.byr_buyer_id',$byr_buyer_id)
            ->get();
            
            $byr_buyer = byr_buyer::where('byr_buyer_id',$byr_buyer_id)->get();
        }else{
            $result = byr_item::select('byr_items.*','byr_item_classes.*','cmn_category_descriptions.category_name','cmn_category_descriptions.category_code','cmn_makers.maker_name_kana','cmn_makers.maker_name')
            ->join('byr_item_classes', 'byr_item_classes.byr_item_id', '=', 'byr_items.byr_item_id')
            ->join('cmn_makers', 'cmn_makers.cmn_maker_id', '=', 'byr_items.cmn_maker_id')
            ->join('cmn_category_descriptions', 'cmn_category_descriptions.cmn_category_id', '=', 'byr_items.cmn_category_id')
            ->get();
            $byr_buyer = byr_buyer::all();
        }

    
        
        return response()->json(['item_list' => $result,'byr_buyer_list'=>$byr_buyer]);
    }
}
