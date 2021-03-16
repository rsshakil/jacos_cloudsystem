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
    public function orderList(Request $request)
    {
        // return $request->all();
        $adm_user_id = $request->adm_user_id;
        $byr_buyer_id = $request->byr_buyer_id;
        $submit_type = $request->submit_type;
        $search_where = '';
        $having_var = '';

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
            $byr_category_code = $byr_category_code['category_code'];
            if ($receive_date_from) {
                $search_where .= "AND dor.receive_datetime >= '" . $receive_date_from . "' ";
            }
            if ($receive_date_to) {
                $search_where .= "AND dor.receive_datetime <= '" . $receive_date_to . "' ";
            }
            if ($delivery_date_from) {
                $search_where .= "AND dov.mes_lis_ord_tra_dat_delivery_date >= '" . $delivery_date_from . "' ";
            }
            if ($delivery_date_to) {
                $search_where .= "AND dov.mes_lis_ord_tra_dat_delivery_date <= '" . $delivery_date_to . "' ";
            }
            if ($delivery_service_code!='*') {
                $search_where .= "AND dov.mes_lis_ord_log_del_delivery_service_code='" . $delivery_service_code . "' ";
            }

            if ($temperature!='*') {
                $search_where .= "AND dov.mes_lis_ord_tra_ins_temperature_code='" . $temperature . "' ";
            }

            if ($byr_category_code!='*') {
                $search_where .= "AND dov.mes_lis_ord_tra_goo_major_category='" . $byr_category_code . "' ";
            }

            if ($check_datetime!='*') {
                if($check_datetime==1){
                    $search_where .= "AND dov.check_datetime is null ";
                }else{
                    $search_where .= "AND dov.check_datetime is not null ";
                }

            }

            // 参照
            if ($confirmation_status) {
                // TODO 参照条件作成
            }
            // 印刷
            if ($print_cnt == "!0") {
                $having_var = "HAVING print_cnt!=0 ";
            } elseif ($print_cnt != "*") {
                $having_var = "HAVING print_cnt='" . $print_cnt . "' ";
            }

            // 確定
            if ($decission_cnt == "!0") {
                if ($having_var) {
                    $having_var .= "OR decision_cnt!=0";
                } else {
                    $having_var .= "HAVING decision_cnt!=0";
                }
            } elseif ($decission_cnt != "*") {
                if ($having_var) {
                    $having_var .= "OR decision_cnt='" . $decission_cnt . "'";
                } else {
                    $having_var .= "HAVING decision_cnt='" . $decission_cnt . "'";
                }
            }
        }
        $authUser = User::find($adm_user_id);
        $cmn_company_id = '';
        $cmn_connect_id = '';
        if (!$authUser->hasRole(config('const.adm_role_name'))) {
            $cmn_company_info=$this->all_used_fun->get_user_info($adm_user_id,$byr_buyer_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }

        // 検索
        $result = DB::select("SELECT
        dor.data_order_id,
        dor.receive_datetime,
        dov.mes_lis_ord_par_sel_code,
        dov.mes_lis_ord_par_sel_name,
        dov.mes_lis_ord_tra_dat_delivery_date,
        dov.mes_lis_ord_tra_goo_major_category,
        dov.mes_lis_ord_log_del_delivery_service_code,
        dov.mes_lis_ord_tra_ins_temperature_code
        ,COUNT(distinct dov.data_order_voucher_id) AS cnt
        ,COUNT( isnull( dsv.decision_datetime) OR NULL) AS decision_cnt
        ,COUNT( isnull( dsv.print_datetime)  OR NULL) AS print_cnt
        ,dov.check_datetime

        FROM data_orders AS dor
        INNER JOIN data_order_vouchers AS dov ON dor.data_order_id=dov.data_order_id
        INNER JOIN data_shipment_vouchers AS dsv ON dsv.data_order_voucher_id = dov.data_order_voucher_id
        WHERE
        dor.cmn_connect_id='$cmn_connect_id'
        $search_where
        GROUP BY
        dor.receive_datetime
        ,dor.sta_sen_identifier
        ,dov.mes_lis_ord_tra_dat_delivery_date
        ,dov.mes_lis_ord_tra_goo_major_category
        ,dov.mes_lis_ord_log_del_delivery_service_code
        ,dov.mes_lis_ord_tra_ins_temperature_code
        $having_var

        ");
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
                $slr_order_info = cmn_connect::select(DB::raw('(CASE WHEN data_order_vouchers.check_datetime is null THEN count(data_order_vouchers.data_order_id) ELSE 0 END) as total_order'), 'byr_buyers.byr_buyer_id', 'cmn_companies.company_name as buyer_name')
                ->leftJoin('data_orders', 'data_orders.cmn_connect_id', '=', 'cmn_connects.cmn_connect_id')
                ->leftJoin('data_order_vouchers', 'data_order_vouchers.data_order_id', '=', 'data_orders.data_order_id')
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
        $data_order_id = $request->data_order_id;
        $delivery_date = $request->delivery_date;
        $delivery_service_code = $request->delivery_service_code;
        $major_category = $request->major_category;
        $temperature_code = $request->temperature_code;
        $per_page = $request->per_page == null ? 10 : $request->per_page;
        $temperature_code = $temperature_code == null ? '' : $temperature_code;
        $form_search = $request->form_search;

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
                    $result->where('dsv.mes_lis_shi_tra_trade_number', $form_search['mes_lis_shi_tra_trade_number']);
                }
                if($form_search['fixedSpecial']!="*"){
                    $result->where('dsv.mes_lis_shi_tra_ins_goods_classification_code', $form_search['fixedSpecial']);
                }
                if($form_search['printingStatus']!="*"){
                    if($form_search['printingStatus']=="未印刷あり"){
                        $result->whereNull('dsv.print_datetime');
                    }
                    if($form_search['printingStatus']=="印刷済"){
                        $result->whereNotNull('dsv.print_datetime');
                    }

                }
                if($form_search['situation']!="*"){
                    if($form_search['situation']=="未確定あり"){
                        $result->whereNull('dsv.decision_datetime');
                    }
                    if($form_search['situation']=="確定済"){
                        $result->whereNotNull('dsv.decision_datetime');
                    }
                }
           $result->groupBy('dsv.mes_lis_shi_tra_trade_number');
            $result = $result->paginate($per_page);


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
