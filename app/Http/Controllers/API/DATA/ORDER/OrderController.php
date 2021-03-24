<?php

namespace App\Http\Controllers\API\DATA\ORDER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMN\cmn_companies_user;
use App\Models\CMN\cmn_connect;
use DB;
use App\Models\ADM\User;
use App\Models\BYR\byr_buyer;
use App\Http\Controllers\API\AllUsedFunction;
use App\Models\DATA\ORD\data_order_voucher;
use App\Models\CMN\cmn_tbl_col_setting;

class OrderController extends Controller
{
    private $all_used_fun;

    public function __construct()
    {
        $this->all_used_fun = new AllUsedFunction();
    }
    public function get_order_customer_code_list(Request $request)
    {
        // return $request->all();
        $adm_user_id = $request->adm_user_id;
        $byr_buyer_id = $request->byr_buyer_id;
        $submit_type = $request->submit_type;
        $per_page = $request->per_page?$request->per_page:10;

        $authUser = User::find($adm_user_id);
        $cmn_company_id = '';
        $cmn_connect_id = '';
        if (!$authUser->hasRole(config('const.adm_role_name'))) {
            $cmn_company_info=$this->all_used_fun->get_user_info($adm_user_id,$byr_buyer_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }
        $result = DB::select("SELECT
        dov.mes_lis_ord_par_sel_code,
        dov.mes_lis_ord_par_sel_name,
        dov.mes_lis_ord_par_pay_code,
        dov.mes_lis_ord_par_pay_name
        FROM
       data_orders AS dao
       INNER JOIN data_order_vouchers AS dov ON dao.data_order_id=dov.data_order_id
       WHERE dao.cmn_connect_id='".$cmn_connect_id."'
       GROUP BY
        dov.mes_lis_ord_par_sel_code,
        dov.mes_lis_ord_par_pay_code");
        return response()->json(['order_customer_code_lists' => $result]);

    }
    public function orderList(Request $request)
    {
        // return $request->all();
        $adm_user_id = $request->adm_user_id;
        $byr_buyer_id = $request->byr_buyer_id;
        $submit_type = $request->submit_type;
        $per_page = $request->per_page?$request->per_page:10;

        $authUser = User::find($adm_user_id);
        $cmn_company_id = '';
        $cmn_connect_id = '';
        if (!$authUser->hasRole(config('const.adm_role_name'))) {
            $cmn_company_info=$this->all_used_fun->get_user_info($adm_user_id,$byr_buyer_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;

        $table_name='dor.';
        if ($sort_by=="data_order_id" || $sort_by=="receive_datetime") {
            $table_name='dor.';
        }else if($sort_by=="decision_datetime" || $sort_by=="print_datetime"){
            $table_name='dsv.';
        }else{
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
            DB::raw('COUNT( isnull( dsv.print_datetime)  OR NULL) AS print_cnt'),
            'dov.check_datetime'
        )
        ->join('data_order_vouchers AS dov','dor.data_order_id','=','dov.data_order_id')
        ->join('data_shipment_vouchers AS dsv','dsv.data_order_voucher_id','=','dov.data_order_voucher_id')
        ->where('dor.cmn_connect_id',$cmn_connect_id);
        if ($submit_type == "search") {
            // 条件指定検索
            $receive_date_from = $request->receive_date_from;
            $receive_date_to = $request->receive_date_to;
            $delivery_date_from = $request->delivery_date_from;
            $delivery_date_to = $request->delivery_date_to;
            $receive_date_from = $receive_date_from!=null? date('Y-m-d 00:00:00',strtotime($receive_date_from)):$receive_date_from; // 受信日時開始
            $receive_date_to = $receive_date_to!=null? date('Y-m-d 23:59:59',strtotime($receive_date_to)):$receive_date_to; // 受信日時終了
            $delivery_date_from = $delivery_date_from!=null? date('Y-m-d 00:00:00',strtotime($delivery_date_from)):$delivery_date_from; // 納品日開始
            $delivery_date_to =$delivery_date_to!=null? date('Y-m-d 23:59:59',strtotime($delivery_date_to)):$delivery_date_to;; // 納品日終了
            $delivery_service_code = $request->delivery_service_code; // 便
            $temperature = $request->temperature; // 配送温度区分
            $check_datetime = $request->check_datetime;
            // $check_datetime=$request->check_datetime;
            $confirmation_status = $request->confirmation_status; // 参照
            $decission_cnt = $request->decission_cnt; // 確定
            $print_cnt = $request->print_cnt; // 印刷
            $byr_category_code = $request->category_code; // 印刷
            $mes_lis_ord_par_sel_code = $request->mes_lis_ord_par_sel_code; // 印刷


            $byr_category_code = $byr_category_code['category_code'];




        if ($receive_date_from) {
            $result= $result->where('dor.receive_datetime','>=',$receive_date_from);
        }
        if ($receive_date_to) {
            $result= $result->where('dor.receive_datetime','<=',$receive_date_to);
        }
        if ($delivery_date_from) {
            $result= $result->where('dov.mes_lis_ord_tra_dat_delivery_date','>=',$delivery_date_from);
        }
        if ($delivery_date_to) {
            $result= $result->where('dov.mes_lis_ord_tra_dat_delivery_date','<=',$delivery_date_to);
        }
        if ($delivery_service_code!='*') {
            $result= $result->where('dov.mes_lis_ord_log_del_delivery_service_code',$delivery_service_code);
        }
        if ($mes_lis_ord_par_sel_code!='') {
            $result= $result->where('dov.mes_lis_ord_par_sel_code',$mes_lis_ord_par_sel_code);
        }

        if ($temperature!='*') {
            $result= $result->where('dov.mes_lis_ord_tra_ins_temperature_code',$temperature);
        }

        if ($byr_category_code!='*') {
            $result= $result->where('dov.mes_lis_ord_tra_goo_major_category',$byr_category_code);
        }

        if ($check_datetime!='*') {
            if($check_datetime==1){
                $result= $result->whereNull('dov.check_datetime');
            }else{
                $result= $result->whereNotNull('dov.check_datetime');
            }

        }

        if ($print_cnt == "!0") {
            $result= $result->having('print_cnt','!=','0');
        } elseif ($print_cnt != "*") {
            $result= $result->having('print_cnt','=',$print_cnt);
        }
        if ($decission_cnt == "!0") {
            $result= $result->having('decision_cnt','!=','0');
        } elseif ($decission_cnt != "*") {
            $result= $result->having('decision_cnt','=',$decission_cnt);
        }
    }
        $result = $result->groupBy([
            'dor.receive_datetime',
            'dor.sta_sen_identifier',
            'dov.mes_lis_ord_tra_dat_delivery_date',
            'dov.data_order_voucher_id',
            'dov.mes_lis_ord_tra_goo_major_category',
            'dov.mes_lis_ord_log_del_delivery_service_code',
            'dov.mes_lis_ord_tra_ins_temperature_code'
        ])
        ->orderBy($table_name.$sort_by,$sort_type)
        ->paginate($per_page);
        $buyer_settings = byr_buyer::select('setting_information')->where('byr_buyer_id', $byr_buyer_id)->first();
        $byr_buyer = $this->all_used_fun->get_company_list($cmn_company_id);
        $byr_buyer_category_list = $this->all_used_fun->get_allCategoryByByrId($byr_buyer_id);
        return response()->json(['order_list' => $result, 'byr_buyer_list' => $byr_buyer, 'buyer_settings' => $buyer_settings->setting_information,'byr_buyer_category_list'=>$byr_buyer_category_list]);
    }
    public function getByrOrderDataBySlr(Request $request)
    {
        $user_id = $request->user_id;
        $slr_order_info =array();
        $slr_info = cmn_companies_user::select('slr_sellers.slr_seller_id')
            ->join('slr_sellers', 'slr_sellers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
            ->where('cmn_companies_users.adm_user_id', $user_id)->first();
            if ($slr_info) {
                $slr_id = $slr_info->slr_seller_id;
                // $slr_order_info = cmn_connect::select(DB::raw('count(data_order_vouchers.data_order_id) as total_order'), 'byr_buyers.byr_buyer_id', 'cmn_companies.company_name as buyer_name')
                $slr_order_info = cmn_connect::select(DB::raw('count(data_order_items.data_order_voucher_id) as total_order'), 'byr_buyers.byr_buyer_id', 'cmn_companies.company_name as buyer_name')
                ->leftJoin('data_orders', 'data_orders.cmn_connect_id', '=', 'cmn_connects.cmn_connect_id')
                ->leftJoin('data_order_vouchers', 'data_order_vouchers.data_order_id', '=', 'data_orders.data_order_id')
                ->leftJoin('data_order_items', 'data_order_items.data_order_voucher_id', '=', 'data_order_vouchers.data_order_voucher_id') //New Added
                ->leftJoin('data_shipment_vouchers', 'data_shipment_vouchers.data_order_voucher_id', '=', 'data_order_vouchers.data_order_voucher_id')
                ->leftJoin('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
                ->leftJoin('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
                // ->where('data_order_vouchers.check_datetime', null)
                ->whereNull('data_shipment_vouchers.send_datetime')
                ->where('cmn_connects.slr_seller_id', $slr_id)
                ->groupBy('byr_buyers.byr_buyer_id')
                ->get();
            }
        return response()->json(['slr_order_info' => $slr_order_info]);
    }
    public function orderDetails(Request $request)
    {
        // return $request->all();
        $data_order_id = $request->data_order_id;
        $delivery_date = $request->delivery_date;
        $delivery_service_code = $request->delivery_service_code;
        $major_category = $request->major_category;
        $temperature_code = $request->temperature_code;
        $per_page = $request->per_page == null ? 10 : $request->per_page;
        $temperature_code = $temperature_code == null ? '' : $temperature_code;
        $form_search = $request->form_search;
        $sort_by=$form_search['sort_by'];
        $sort_type=$form_search['sort_type'];

        data_order_voucher::where('data_order_id',$data_order_id)->where('mes_lis_ord_tra_goo_major_category',$major_category)->where('mes_lis_ord_log_del_delivery_service_code',$delivery_service_code)->where('mes_lis_ord_tra_dat_delivery_date',$delivery_date)->whereNull('check_datetime')->update(['check_datetime'=>date('Y-m-d H:i:s')]);
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
            // ->where('ds.data_order_id', $data_order_id);
            ->where('dsv.mes_lis_shi_tra_dat_delivery_date', $delivery_date)
            ->where('dsv.mes_lis_shi_tra_goo_major_category', $major_category)
            ->where('dsv.mes_lis_shi_log_del_delivery_service_code', $delivery_service_code)
            ->where('dsv.mes_lis_shi_tra_ins_temperature_code', $temperature_code);
                if($form_search['mes_lis_shi_tra_trade_number']!=""){
                    $result = $result->where('dsv.mes_lis_shi_tra_trade_number', $form_search['mes_lis_shi_tra_trade_number']);
                }
                if($form_search['fixedSpecial']!="*"){
                    $result = $result->where('dsv.mes_lis_shi_tra_ins_goods_classification_code', $form_search['fixedSpecial']);
                }
                if($form_search['printingStatus']!="*"){
                    if($form_search['printingStatus']=="未印刷あり"){
                        $result = $result->whereNull('dsv.print_datetime');
                    }
                    if($form_search['printingStatus']=="印刷済"){
                        $result = $result->whereNotNull('dsv.print_datetime');
                    }

                }
                if($form_search['situation']!="*"){
                    if($form_search['situation']=="未確定あり"){
                        $result = $result->whereNull('dsv.decision_datetime');
                    }
                    if($form_search['situation']=="確定済"){
                        $result = $result->whereNotNull('dsv.decision_datetime');
                    }
                }
                $result = $result->orderBy('dsv.'.$sort_by,$sort_type);
                $result = $result->groupBy('dsv.mes_lis_shi_tra_trade_number')
                ->paginate($per_page);
        /*coll setting*/
        $slected_list = array();
        // $result_data = cmn_tbl_col_setting::where('url_slug', 'order_list_details')->first();
        // $header_list = json_decode($result_data->content_setting);
        // foreach ($header_list as $header) {
        //     if ($header->header_status == true) {
        //         $slected_list[] = $header->header_field;
        //     }
        // }
        /*coll setting*/
        return response()->json(['order_list_detail' => $result, 'order_info' => $order_info, 'slected_list' => $slected_list]);
    }
    public function getOrderById($byr_order_id)
    {
        $result = DB::table('bms_orders')->where('bms_orders.byr_order_id', $byr_order_id)
            ->get();
        /*coll setting*/
        $slected_list = array();
        $result_data = cmn_tbl_col_setting::where('url_slug', 'order_list_detail')->first();
        $header_list = json_decode($result_data->content_setting);
        foreach ($header_list as $header) {
            if ($header->header_status == true) {
                $slected_list[] = $header->header_field;
            }
        }
        /*coll setting*/
        return response()->json(['order_list_detail' => $result, 'slected_list' => $slected_list]);
    }
}
