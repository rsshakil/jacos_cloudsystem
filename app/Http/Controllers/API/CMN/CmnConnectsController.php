<?php

namespace App\Http\Controllers\API\CMN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\API\AllUsedFunction;
use App\Models\ADM\User;
use App\Models\BYR\byr_buyer;
use App\Models\BYR\byr_order;
use App\Models\BYR\byr_order_item;
use App\Models\BYR\byr_shipment_item;
use App\Models\CMN\cmn_companies_user;
use App\Models\CMN\cmn_connect;
use App\Models\CMN\cmn_pdf_canvas;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_tbl_col_setting;
use App\Models\DATA\SHIPMENT\data_shipment_voucher;
use App\Models\DATA\ORD\data_order_voucher;
use DB;

class CmnConnectsController extends Controller
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

    public function update_cmn_connects_optional(Request $request){
        $invoicedayslist = $request->selected_item;
        $customdata = array();
        foreach($invoicedayslist as $val){
            if($val['value']!=''){
                $customdata[]=$val['value'];
            }      
        }
        
        $jsonArray = array(
            'order'=>array(
                'download'=>7,
            ),
            'invoice'=>$customdata,
        );
        $invoicedayslistjson = \json_encode($jsonArray);
        
        cmn_connect::where('cmn_connect_id',1)->update(['optional'=>$invoicedayslistjson]);
        return response()->json(['success'=>1]);
    }

    public function get_allInvoiceJsonSetting_info(Request $request){
        $result = cmn_connect::where('cmn_connect_id',1)->first();
        $jsnresp = array();
        if($result->optional){
            $jsdecode = \json_decode($result->optional);
            foreach($jsdecode->invoice as $key=>$inv){
                $jsnresp[]= array(
                    'id'=>$key,
                    'value'=>$inv
                );
            }
            return response()->json(['result'=>$jsnresp,'success'=>1]);
        }
        return response()->json(['result'=>$jsnresp,'success'=>0]);
    }
}
