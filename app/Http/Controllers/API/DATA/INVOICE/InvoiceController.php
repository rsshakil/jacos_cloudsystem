<?php

namespace App\Http\Controllers\API\DATA\INVOICE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\Cmn_ScenarioController;
use App\Models\ADM\User;
use App\Models\BYR\byr_order_detail;
use App\Models\DATA\INVOICE\data_invoice;
use App\Models\DATA\INVOICE\data_invoice_pay;
use App\Http\Controllers\API\AllUsedFunction;
use DB;

class InvoiceController extends Controller
{
    private $request;
    private $all_used_fun;
    public function __construct()
    {
        $this->request = new \Illuminate\Http\Request();
        $this->request->setMethod('POST');
        $this->all_used_fun = new AllUsedFunction();
    }
    public function invoiceScheduler($start_date,$end_date){
        // $request = new \Illuminate\Http\Request();
        // $request->setMethod('POST');
        $request=$this->request;
        $request->request->add(['scenario_id' => 15]);
        $request->request->add(['data_order_id' => 1]);
        $request->request->add(['email' => 'user@jacos.co.jp']);
        $request->request->add(['password' => 'Qe75ymSr']);
        $request->request->add(['start_date' => $start_date]);
        $request->request->add(['end_date' => $end_date]);
        // return $request->all();
        $cs = new Cmn_ScenarioController();
        return $ret = $cs->exec($request);
        \Log::debug($ret->getContent());
        $ret = json_decode($ret->getContent(), true);
        if (1 === $ret['status']) {
            // sceanario exec error
            \Log::error($ret['message']);
            return $ret;
        }
        return response()->json($ret);
    }

    public function get_all_invoice_list(Request $request)
    {
        // return $request->all();
        $adm_user_id=$request->adm_user_id;
        $per_page = $request->select_field_per_page_num == null ? 10 : $request->select_field_per_page_num;


        $authUser = User::find($adm_user_id);
        $cmn_company_id = 0;
        if (!$authUser->hasRole(config('const.adm_role_name'))) {
            $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            // $byr_buyer_id = $cmn_company_info['byr_buyer_id'];
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }
        $result=data_invoice::select('data_invoices.data_invoice_id','dip.mes_lis_inv_per_end_date',
        'dip.mes_lis_inv_pay_code','dip.mes_lis_buy_name',
        'dip.status','dipd.mes_lis_inv_lin_det_amo_requested_amount'
        )
        ->join('data_invoice_pays as dip','data_invoices.data_invoice_id','=','dip.data_invoice_id')
        ->join('data_invoice_pay_details as dipd','dip.data_invoice_pay_id','=','dipd.data_invoice_pay_id')
        ->where('data_invoices.cmn_connect_id','=',$cmn_connect_id)
        ->groupBy('dip.mes_lis_inv_per_end_date')
        // ->groupBy('data_receives.sta_sen_identifier')
        // ->groupBy('drv.mes_lis_acc_par_sel_code')
        // ->groupBy('drv.mes_lis_acc_par_sel_name')
        // ->groupBy('drv.mes_lis_acc_tra_dat_delivery_date')
        // ->groupBy('drv.mes_lis_acc_tra_goo_major_category')
        // ->groupBy('drv.mes_lis_acc_log_del_delivery_service_code')
        // ->groupBy('drv.mes_lis_acc_tra_ins_temperature_code')
        ->paginate($per_page);
        // if (!$authUser->hasRole(config('const.adm_role_name'))) {
        //     $result = data_invoice::select('data_invoices.*', 'cmn_companies.company_name')
        //         ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'data_invoices.cmn_connect_id')
        //         ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
        //         ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
        //         ->where('data_invoices.cmn_connect_id', $cmn_connect_id)
        //         ->paginate($per_page);

        // } else {
        //     $result = data_invoice::select('data_invoices.*', 'cmn_companies.company_name')
        //         ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'data_invoices.cmn_connect_id')
        //         ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
        //         ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
        //         ->paginate($per_page);
        // }

        $byr_buyer = $this->all_used_fun->get_company_list($cmn_company_id);

        return response()->json(['invoice_list' => $result, 'byr_buyer_list' => $byr_buyer]);
    }
    public function invoiceInsert(Request $request){

        $invoice_id = data_invoice::insertGetId([
            'sta_sen_identifier'=>'',
            'sta_sen_ide_authority'=>'',
            'sta_rec_identifier'=>'',
            'sta_rec_ide_authority'=>'',
            'sta_doc_standard'=>'',
            'sta_doc_type_version'=>'',
            'sta_doc_instance_identifier'=>'',
            'sta_doc_type'=>'',
            'sta_doc_creation_date_and_time'=>'',
            'sta_bus_scope_instance_identifier'=>'',
            'sta_bus_scope_type'=>'',
            'sta_bus_scope_identifier'=>'',
            'mes_ent_unique_creator_identification'=>'',
            'mes_mes_sender_station_address'=>'',
            'mes_mes_ultimate_receiver_station_address'=>'',
            'mes_mes_immediate_receiver_station_addres'=>'',
            'mes_mes_number_of_trading_documents'=>'',
            'mes_mes_system_info'=>'',
            'mes_mes_sys_key'=>'',
            'mes_mes_sys_value'=>'',
            'mes_lis_con_version'=>'',
            'mes_lis_doc_version'=>'',
            'mes_lis_ext_namespace'=>'',
            'mes_lis_ext_version'=>'',
            'mes_lis_pay_code'=>'',
            'mes_lis_pay_gln'=>'',
            'mes_lis_pay_name'=>'',
            'mes_lis_pay_name_sbcs'=>'',
        ]);
        $request['data_invoice_id'] = $invoice_id;
        data_invoice_pay::insert($request->all());


        return response()->json(['success' => 1]);
    }
    public function get_all_invoice_detail_list($byr_invoice_id)
    {
        $result = byr_invoice::select('byr_invoices.byr_invoice_id', 'byr_invoices.cmn_connect_id', 'byr_invoices.send_date', 'byr_shops.shop_name', 'byr_order_details.voucher_number', 'byr_shipment_details.revised_delivery_date', 'byr_order_details.expected_delivery_date', 'byr_order_details.byr_order_detail_id', 'byr_order_details.cost_price', 'byr_shipment_details.revised_cost_price')

            ->join('byr_orders', 'byr_orders.cmn_connect_id', '=', 'byr_invoices.cmn_connect_id')
            ->join('byr_order_details', 'byr_order_details.byr_order_id', '=', 'byr_orders.byr_order_id')
            ->join('byr_shops', 'byr_shops.byr_shop_id', '=', 'byr_order_details.byr_shop_id')
            ->join('byr_shipment_details', 'byr_shipment_details.byr_order_detail_id', '=', 'byr_order_details.byr_order_detail_id')
            ->where('byr_invoices.byr_invoice_id', $byr_invoice_id)
            ->get();
        $voucher_list = byr_invoice::select('byr_invoices.byr_invoice_id', 'byr_invoices.cmn_connect_id', 'byr_order_details.voucher_number')

            ->join('byr_orders', 'byr_orders.cmn_connect_id', '=', 'byr_invoices.cmn_connect_id')
            ->join('byr_order_details', 'byr_order_details.byr_order_id', '=', 'byr_orders.byr_order_id')
            ->where('byr_invoices.byr_invoice_id', $byr_invoice_id)
            ->groupBy('byr_order_details.voucher_number')
            ->get();
        $shop_list = byr_invoice::select('byr_invoices.byr_invoice_id', 'byr_invoices.cmn_connect_id', 'byr_shops.shop_name', 'byr_shops.byr_shop_id')

            ->join('byr_orders', 'byr_orders.cmn_connect_id', '=', 'byr_invoices.cmn_connect_id')
            ->join('byr_order_details', 'byr_order_details.byr_order_id', '=', 'byr_orders.byr_order_id')
            ->join('byr_shops', 'byr_shops.byr_shop_id', '=', 'byr_order_details.byr_shop_id')
            ->where('byr_invoices.byr_invoice_id', $byr_invoice_id)
            ->groupBy('byr_order_details.byr_shop_id')
            ->get();

        $byr_buyer = byr_invoice::select('cmn_companies.cmn_company_id', 'cmn_companies.company_name')
            ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'byr_invoices.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
            ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.byr_buyer_id')
            ->where('byr_invoices.byr_invoice_id', $byr_invoice_id)
            ->get();

        return response()->json(['invoice_list' => $result, 'byr_buyer_list' => $byr_buyer, 'shop_list' => $shop_list, 'voucher_list' => $voucher_list]);
    }

    public function get_all_invoice_by_voucher_number($voucher_number)
    {

        $result = byr_order_detail::select('byr_order_details.*', 'byr_shipment_details.*')
            ->join('byr_shipment_details', 'byr_shipment_details.byr_order_detail_id', '=', 'byr_order_details.byr_order_detail_id')
            ->where('voucher_number', $voucher_number)->get();
        $shop_list = array();
        $voucher_list = array();
        $byr_buyer = array();
        return response()->json(['invoice_list' => $result, 'byr_buyer_list' => $byr_buyer, 'shop_list' => $shop_list, 'voucher_list' => $voucher_list]);
    }
}
