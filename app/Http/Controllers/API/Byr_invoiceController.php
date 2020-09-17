<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AllUsedFunction;
use Illuminate\Http\Request;
use App\Models\BYR\byr_buyer;
use App\Models\BYR\byr_invoice;
use App\Models\BYR\byr_invoice_detail;
use App\Models\BYR\byr_shipment;
use App\Models\BYR\byr_shipment_detail;
use App\Models\BYR\byr_order;
use App\Models\BYR\byr_order_detail;
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
class Byr_invoiceController extends Controller
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

    public function get_all_invoice_list($adm_user_id){
        $authUser=User::find($adm_user_id);
        $cmn_company_id = 0;
        if(!$authUser->hasRole('Super Admin')){
            $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            $byr_buyer_id = $cmn_company_info['byr_buyer_id'];
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }

        if(!$authUser->hasRole('Super Admin')){
            $result = byr_invoice::select('byr_invoices.*','cmn_companies.company_name')
            ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'byr_invoices.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
            ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
            ->where('byr_invoices.cmn_connect_id',$cmn_connect_id)
            ->get();
            
        }else{
            $result = byr_invoice::select('byr_invoices.*','cmn_companies.company_name')
            ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'byr_invoices.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
            ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
            ->get();
        }

        $byr_buyer =$this->all_used_fun->get_company_list($cmn_company_id);
    
        
        return response()->json(['invoice_list' => $result,'byr_buyer_list'=>$byr_buyer]);
    }

    public function get_all_invoice_detail_list($byr_invoice_id){
        $result = byr_invoice::select('byr_invoices.byr_invoice_id','byr_invoices.cmn_connect_id','byr_invoices.send_date','byr_shops.shop_name','byr_order_details.voucher_number','byr_shipment_details.revised_delivery_date','byr_order_details.expected_delivery_date','byr_order_details.byr_order_detail_id','byr_order_details.cost_price','byr_shipment_details.revised_cost_price')
       
        ->join('byr_orders', 'byr_orders.cmn_connect_id', '=', 'byr_invoices.cmn_connect_id')
        ->join('byr_order_details', 'byr_order_details.byr_order_id', '=', 'byr_orders.byr_order_id')
        ->join('byr_shops', 'byr_shops.byr_shop_id', '=', 'byr_order_details.byr_shop_id')
        ->join('byr_shipment_details', 'byr_shipment_details.byr_order_detail_id', '=', 'byr_order_details.byr_order_detail_id')
        ->where('byr_invoices.byr_invoice_id',$byr_invoice_id)
        ->get();
        $voucher_list = byr_invoice::select('byr_invoices.byr_invoice_id','byr_invoices.cmn_connect_id','byr_order_details.voucher_number')
       
        ->join('byr_orders', 'byr_orders.cmn_connect_id', '=', 'byr_invoices.cmn_connect_id')
        ->join('byr_order_details', 'byr_order_details.byr_order_id', '=', 'byr_orders.byr_order_id')
        ->where('byr_invoices.byr_invoice_id',$byr_invoice_id)
        ->groupBy('byr_order_details.voucher_number')
        ->get();
        $shop_list = byr_invoice::select('byr_invoices.byr_invoice_id','byr_invoices.cmn_connect_id','byr_shops.shop_name','byr_shops.byr_shop_id')
       
        ->join('byr_orders', 'byr_orders.cmn_connect_id', '=', 'byr_invoices.cmn_connect_id')
        ->join('byr_order_details', 'byr_order_details.byr_order_id', '=', 'byr_orders.byr_order_id')
        ->join('byr_shops', 'byr_shops.byr_shop_id', '=', 'byr_order_details.byr_shop_id')
        ->where('byr_invoices.byr_invoice_id',$byr_invoice_id)
        ->groupBy('byr_order_details.byr_shop_id')
        ->get();

        $byr_buyer = byr_invoice::select('cmn_companies.cmn_company_id','cmn_companies.company_name')
        ->join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_invoices.cmn_connect_id')
        ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
        ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.byr_buyer_id')
        ->where('byr_invoices.byr_invoice_id',$byr_invoice_id)
        ->get();

        return response()->json(['invoice_list' => $result,'byr_buyer_list'=>$byr_buyer,'shop_list'=>$shop_list,'voucher_list'=>$voucher_list]);
    }

    public function get_all_invoice_by_voucher_number($voucher_number){

        $result = byr_order_detail::select('byr_order_details.*','byr_shipment_details.*')
        ->join('byr_shipment_details','byr_shipment_details.byr_order_detail_id','=','byr_order_details.byr_order_detail_id')
        ->where('voucher_number',$voucher_number)->get();
        $shop_list = array();
        $voucher_list = array();
        $byr_buyer = array();
        return response()->json(['invoice_list' => $result,'byr_buyer_list'=>$byr_buyer,'shop_list'=>$shop_list,'voucher_list'=>$voucher_list]);
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
