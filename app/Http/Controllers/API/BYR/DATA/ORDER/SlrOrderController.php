<?php

namespace App\Http\Controllers\API\BYR\DATA\ORDER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\ADM\User;
use App\Models\DATA\ORD\data_order;
use App\Models\DATA\ORD\data_order_voucher;
use App\Http\Controllers\API\BYR\DATA\ORDER\DataController;
use App\Http\Controllers\API\BYR\DATA\DFLT\DefaultFunctions;
use App\Traits\Csv;
use App\Http\Controllers\API\CMN\CmnScenarioController;
// use App\Http\Controllers\API\AllUsedFunction;

class SlrOrderController extends Controller
{
    // private $default_functions;
    // private $all_used_fun;
    public function __construct()
    {
        // $this->default_functions = new DefaultFunctions();
        // $this->all_used_fun = new AllUsedFunction();
    }

    public function slrOrderList(Request $request){
        Log::debug(__METHOD__.':start---');
        // return $request->all();
        // $buyer_info = Auth::User()->ByrInfo;
        // $adm_user_id = $request->adm_user_id;
        // $global_user_type = $request->global_user_type;

        // $byr_buyer_id =$buyer_info->byr_buyer_id;
        $byr_buyer_id =Auth::User()->ByrInfo->byr_buyer_id;
        $per_page = $request->per_page?$request->per_page:10;
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;

        $table_name='dor.';
        if ($sort_by=="data_order_id" || $sort_by=="receive_datetime") {
            $table_name='dor.';
        } elseif ($sort_by=="decision_datetime" || $sort_by=="print_datetime") {
            $table_name='dsv.';
        } else {
            $table_name='dov.';
        }
        $result = DB::table('data_orders AS dor')
        ->select(
            'dor.data_order_id',
            'dor.receive_datetime',
            'dov.mes_lis_ord_par_sel_code',
            'dov.mes_lis_ord_par_sel_name',
            'dov.mes_lis_ord_tra_dat_delivery_date',
            'dov.mes_lis_ord_tra_goo_major_category',
            'dov.mes_lis_ord_log_del_delivery_service_code',
            'dov.mes_lis_ord_tra_ins_temperature_code',
            DB::raw('COUNT(distinct dov.data_order_voucher_id) AS cnt'),
            DB::raw('COUNT( isnull( dsv.decision_datetime) OR NULL) AS decision_cnt'),
            // DB::raw('COUNT( isnull( dsv.print_datetime)  OR NULL) AS print_cnt'),
            DB::raw('COUNT( isnull( dsv.send_datetime)  OR NULL) AS send_cnt'),
            'dov.check_datetime'
        )
        ->join('data_order_vouchers AS dov', 'dor.data_order_id', '=', 'dov.data_order_id')
        ->join('data_shipment_vouchers AS dsv', 'dsv.data_order_voucher_id', '=', 'dov.data_order_voucher_id')
        ->join('cmn_connects as cc', 'cc.cmn_connect_id', '=', 'dor.cmn_connect_id')
        ->where('cc.byr_buyer_id', $byr_buyer_id);
        // ->where('cc.slr_seller_id', $slr_seller_id);
        $receive_date_from = $request->receive_date_from;
        $receive_date_to = $request->receive_date_to;
        $delivery_date_from = $request->delivery_date_from;
        $delivery_date_to = $request->delivery_date_to;
        $receive_date_from = $receive_date_from!=null? date('Y-m-d 00:00:00', strtotime($receive_date_from)):$receive_date_from; // 受信日時開始
        $receive_date_to = $receive_date_to!=null? date('Y-m-d 23:59:59', strtotime($receive_date_to)):$receive_date_to; // 受信日時終了
        $delivery_date_from = $delivery_date_from!=null? date('Y-m-d 00:00:00', strtotime($delivery_date_from)):$delivery_date_from; // 納品日開始
        $delivery_date_to =$delivery_date_to!=null? date('Y-m-d 23:59:59', strtotime($delivery_date_to)):$delivery_date_to;// 納品日終了
        $delivery_service_code = $request->delivery_service_code; // 便
        $temperature = $request->temperature; // 配送温度区分
        $check_datetime = $request->check_datetime;
        $confirmation_status = $request->confirmation_status; // 参照
        $decission_cnt = $request->decission_cnt; // 確定
        $send_cnt = $request->send_cnt; // 印刷
        $byr_category_code = $request->category_code; // 印刷
        $mes_lis_ord_par_sel_code = $request->mes_lis_ord_par_sel_code; // 印刷


        $byr_category_code = $byr_category_code['category_code'];

        if ($receive_date_from && $receive_date_to) {
            $result= $result->whereBetween('dor.receive_datetime', [$receive_date_from, $receive_date_to]);
        }
        if ($delivery_date_from && $delivery_date_to) {
            $result= $result->whereBetween('dov.mes_lis_ord_tra_dat_delivery_date', [$delivery_date_from, $delivery_date_to]);
        }

        if ($mes_lis_ord_par_sel_code!='') {
            $result= $result->where('dov.mes_lis_ord_par_sel_code', $mes_lis_ord_par_sel_code);
        }
        if ($delivery_service_code!='*') {
            $result= $result->where('dov.mes_lis_ord_log_del_delivery_service_code', $delivery_service_code);
        }
        if ($temperature!='*') {
            $result= $result->where('dov.mes_lis_ord_tra_ins_temperature_code', $temperature);
        }

        if ($byr_category_code!='*') {
            $result= $result->where('dov.mes_lis_ord_tra_goo_major_category', $byr_category_code);
        }

        if ($check_datetime!='*') {
            if ($check_datetime==1) {
                $result= $result->whereNull('dov.check_datetime');
            } else {
                $result= $result->whereNotNull('dov.check_datetime');
            }
        }

        if ($send_cnt == "!0") {
            $result= $result->having('send_cnt', '!=', '0');
        } elseif ($send_cnt != "*") {
            $result= $result->having('send_cnt', '=', $send_cnt);
        }
        if ($decission_cnt == "!0") {
            $result= $result->having('decision_cnt', '!=', '0');
        } elseif ($decission_cnt != "*") {
            $result= $result->having('decision_cnt', '=', $decission_cnt);
        }
        // }
        $result = $result->groupBy([
            'dor.receive_datetime',
            'dor.sta_sen_identifier',
            'dov.mes_lis_ord_tra_dat_delivery_date',
            'dov.mes_lis_ord_tra_goo_major_category',
            'dov.mes_lis_ord_log_del_delivery_service_code',
            'dov.mes_lis_ord_tra_ins_temperature_code',
            'dov.mes_lis_ord_par_sel_code'
        ])
        ->orderBy($table_name.$sort_by, $sort_type)
        ->orderBy('dov.mes_lis_ord_par_sel_code')
        ->orderBy('dov.mes_lis_ord_tra_dat_delivery_date')
        ->orderBy('dov.mes_lis_ord_tra_goo_major_category')
        ->orderBy('dov.mes_lis_ord_log_del_delivery_service_code')
        ->orderBy('dov.mes_lis_ord_tra_ins_temperature_code')
        ->paginate($per_page);
        // $cmn_company_id =$buyer_info->cmn_company_id;
        // $byr_buyer = $this->all_used_fun->get_company_list($cmn_company_id);
        Log::debug(__METHOD__.':end---');
        return response()->json(['order_list' => $result]);
        // return response()->json(['order_list' => $result, 'byr_buyer_list' => $byr_buyer]);
    }
    // slrCustomerCodeList
    public function slrCustomerCodeList(Request $request)
    {
        Log::debug(__METHOD__.':start---');

        $byr_buyer_id =Auth::User()->ByrInfo->byr_buyer_id;
        $query = data_order::join('data_order_vouchers as dov', 'dov.data_order_id', '=', 'data_orders.data_order_id')
            ->join('cmn_connects as cc', 'cc.cmn_connect_id', '=', 'data_orders.cmn_connect_id')
            ->select(
                'dov.mes_lis_ord_par_sel_code',
                'dov.mes_lis_ord_par_sel_name',
                'dov.mes_lis_ord_par_pay_code',
                'dov.mes_lis_ord_par_pay_name'
            )
            ->where('cc.byr_buyer_id', $byr_buyer_id)
            // ->where('cc.slr_seller_id', $slr_seller_id)
            ->groupby('dov.mes_lis_ord_par_sel_code', 'dov.mes_lis_ord_par_pay_code');
        $result = $query->get();
        Log::debug(__METHOD__.':end---');
        return response()->json(['order_customer_code_lists' => $result]);
    }

    public function slrOrderDetails(Request $request){
        Log::debug(__METHOD__.':start---');
        // return $request->all();
        // $form_search = $request->form_search;
        $data_order_id = $request->data_order_id;
        $order_info=$request->order_info;
        // Log::info($order_info);
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;
        $par_shi_code = $request->par_shi_code;
        $par_rec_code = $request->par_rec_code;
        $order_item_code = $request->order_item_code;
        $per_page = $request->per_page == null ? 10 : $request->per_page;

        $mes_lis_shi_tra_trade_number=$request->mes_lis_shi_tra_trade_number;
        $fixedSpecial=$request->fixedSpecial;
        $printingStatus=$request->printingStatus;
        $situation=$request->situation;
        $send_datetime=$request->send_datetime;

        // Log::info($mes_lis_shi_tra_trade_number);

        $delivery_date = $order_info['delivery_date'];
        // Log::info($delivery_date);
        $delivery_service_code = $order_info['delivery_service_code'];
        $major_category = $order_info['major_category'];
        $temperature_code = $order_info['temperature_code'];
        $sel_code = $order_info['sel_code'];
        $temperature_code = $temperature_code == null ? '' : $temperature_code;

        data_order_voucher::where('data_order_id', $data_order_id)
        ->where('mes_lis_ord_tra_goo_major_category', $major_category)
        ->where('mes_lis_ord_log_del_delivery_service_code', $delivery_service_code)
        ->where('mes_lis_ord_tra_dat_delivery_date', $delivery_date)
        ->where('mes_lis_ord_par_sel_code', $sel_code)
        ->whereNull('check_datetime')->update(['check_datetime'=>date('Y-m-d H:i:s')]);
        $order_info = DB::table('data_shipments as ds')
        ->select(
            'dor.receive_datetime',
            'dsv.mes_lis_shi_par_sel_code',
            'dsv.mes_lis_shi_par_sel_name',
            'dsv.mes_lis_shi_tra_dat_delivery_date',
            'dsv.mes_lis_shi_tra_goo_major_category',
            'dsv.mes_lis_shi_log_del_delivery_service_code',
            'dsv.mes_lis_shi_tra_ins_temperature_code',
            'dsv.mes_lis_shi_tra_trade_number'
        )
        ->join('data_shipment_vouchers as dsv', 'dsv.data_shipment_id', '=', 'ds.data_shipment_id')
        ->join('data_shipment_items as dsi', 'dsi.data_shipment_voucher_id', '=', 'dsv.data_shipment_voucher_id')
        ->join('data_orders as dor', 'dor.data_order_id', '=', 'ds.data_order_id')
        ->where('ds.data_order_id', $data_order_id)
        ->where('dsv.mes_lis_shi_tra_dat_delivery_date', $delivery_date)
        ->where('dsv.mes_lis_shi_tra_goo_major_category', $major_category)
        ->where('dsv.mes_lis_shi_log_del_delivery_service_code', $delivery_service_code)
        ->where('dsv.mes_lis_shi_tra_ins_temperature_code', $temperature_code)
        ->where('dsv.mes_lis_shi_par_sel_code', $sel_code)
        ->groupBy('dsv.mes_lis_shi_tra_trade_number')
        ->first();

        $result = DB::table('data_shipments as ds')
            ->select(
                'dor.receive_datetime',
                'dsv.mes_lis_shi_par_sel_code',
                'dsv.mes_lis_shi_par_sel_name',
                'dsv.data_shipment_voucher_id',
                'dsv.mes_lis_shi_tra_dat_delivery_date',
                'dsv.mes_lis_shi_tra_goo_major_category',
                'dsv.mes_lis_shi_log_del_delivery_service_code',
                'dsv.mes_lis_shi_tra_ins_temperature_code',
                'dsv.decision_datetime',
                'dsv.mes_lis_shi_par_shi_code',
                'dsv.mes_lis_shi_par_rec_code',
                'dsv.mes_lis_shi_par_rec_name',
                'dsv.mes_lis_shi_tra_trade_number',
                'dsv.mes_lis_shi_tra_ins_goods_classification_code',
                'dsv.mes_lis_shi_tot_tot_net_price_total',
                'dsv.status',
                'dsv.updated_at',
                'dsv.print_datetime',
                'dsv.send_datetime'
            )
            ->join('data_shipment_vouchers as dsv', 'dsv.data_shipment_id', '=', 'ds.data_shipment_id')
            ->join('data_shipment_items as dsi', 'dsi.data_shipment_voucher_id', '=', 'dsv.data_shipment_voucher_id')
            ->join('data_orders as dor', 'dor.data_order_id', '=', 'ds.data_order_id')
            ->where('ds.data_order_id', $data_order_id)
            ->where('dsv.mes_lis_shi_tra_dat_delivery_date', $delivery_date)
            ->where('dsv.mes_lis_shi_tra_goo_major_category', $major_category)
            ->where('dsv.mes_lis_shi_log_del_delivery_service_code', $delivery_service_code)
            ->where('dsv.mes_lis_shi_tra_ins_temperature_code', $temperature_code)
            ->where('dsv.mes_lis_shi_par_sel_code', $sel_code);


        if ($mes_lis_shi_tra_trade_number!=null) {
            $result = $result->where('dsv.mes_lis_shi_tra_trade_number', $mes_lis_shi_tra_trade_number);
        }
        if ($fixedSpecial!="*") {
            $result = $result->where('dsv.mes_lis_shi_tra_ins_goods_classification_code', $fixedSpecial);
        }
        if ($printingStatus!="*") {
            if ($printingStatus=="未印刷あり") {
                $result = $result->whereNull('dsv.print_datetime');
            }
            if ($printingStatus=="印刷済") {
                $result = $result->whereNotNull('dsv.print_datetime');
            }
        }
        if ($situation!="*") {
            if ($situation=="未確定あり") {
                $result = $result->whereNull('dsv.decision_datetime');
            }
            if ($situation=="確定済") {
                $result = $result->whereNotNull('dsv.decision_datetime');
            }
        }
        if ($send_datetime!="*") {
            if ($send_datetime=="未送信あり") {
                $result = $result->whereNull('dsv.send_datetime');
            }
            if ($send_datetime=="送信済") {
                $result = $result->whereNotNull('dsv.send_datetime');
            }
        }
        if ($par_shi_code!=null) {
            $result = $result->where('dsv.mes_lis_shi_par_shi_code', $par_shi_code);
        }
        if ($par_rec_code!=null) {
            $result = $result->where('dsv.mes_lis_shi_par_rec_code', $par_rec_code);
        }
        if ($order_item_code!=null) {
            $result = $result->where('dsi.mes_lis_shi_lin_ite_order_item_code', $order_item_code);
        }
        $result = $result->orderBy('dsv.'.$sort_by, $sort_type);
        $result = $result->groupBy('dsv.mes_lis_shi_tra_trade_number')
                ->paginate($per_page);
        /*coll setting*/
        $slected_list = array();
        Log::debug(__METHOD__.':end---');
        return response()->json(['order_list_detail' => $result, 'order_info' => $order_info, 'slected_list' => $slected_list]);
    }
}
