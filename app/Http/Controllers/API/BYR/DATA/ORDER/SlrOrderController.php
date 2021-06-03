<?php

namespace App\Http\Controllers\API\BYR\DATA\ORDER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ADM\User;
use App\Http\Controllers\API\BYR\DATA\DFLT\DefaultFunctions;

class SlrOrderController extends Controller
{
    private $default_functions;
    public function __construct()
    {
        $this->default_functions = new DefaultFunctions();
    }

    public function slrOrderList(Request $request){
        Log::debug(__METHOD__.':start---');
        // return $UserType = Auth::User()->UserType;
        // return $request->all();
        $adm_user_id = $request->adm_user_id;
        $global_user_type = $request->global_user_type;
        $buyer_info = $this->default_functions->getByrInfo($adm_user_id);
        $byr_buyer_id =$buyer_info->byr_buyer_id;
        $cmn_company_id =$buyer_info->cmn_company_id;
    //    return $byr_buyer_id = $global_user_type=='byr'?$adm_user_id:'';
        $per_page = $request->per_page?$request->per_page:10;

        $authUser = User::find($adm_user_id);
        // return Auth::User()->SlrInfo;
        // $slr_info = SlrController::getSlrInfoByUserId($adm_user_id);
        // $slr_seller_id = $slr_info->slr_seller_id;
        // $slr_seller_id = Auth::User()->SlrInfo->slr_seller_id;

        // $cmn_company_id = '';
        // if (!$authUser->hasRole(config('const.adm_role_name'))) {
        //     $cmn_company_info=$this->all_used_fun->get_user_info($adm_user_id, $byr_buyer_id);
        //     $cmn_company_id = $cmn_company_info['cmn_company_id'];
        //     // $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        // }
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
        // if ($submit_type == "search") {
        // 条件指定検索
        $receive_date_from = $request->receive_date_from;
        $receive_date_to = $request->receive_date_to;
        $delivery_date_from = $request->delivery_date_from;
        $delivery_date_to = $request->delivery_date_to;
        $receive_date_from = $receive_date_from!=null? date('Y-m-d 00:00:00', strtotime($receive_date_from)):$receive_date_from; // 受信日時開始
            $receive_date_to = $receive_date_to!=null? date('Y-m-d 23:59:59', strtotime($receive_date_to)):$receive_date_to; // 受信日時終了
            $delivery_date_from = $delivery_date_from!=null? date('Y-m-d 00:00:00', strtotime($delivery_date_from)):$delivery_date_from; // 納品日開始
            $delivery_date_to =$delivery_date_to!=null? date('Y-m-d 23:59:59', strtotime($delivery_date_to)):$delivery_date_to;
        ; // 納品日終了
            $delivery_service_code = $request->delivery_service_code; // 便
            $temperature = $request->temperature; // 配送温度区分
            $check_datetime = $request->check_datetime;
        // $check_datetime=$request->check_datetime;
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
            'dov.mes_lis_ord_tra_ins_temperature_code'
        ])
        ->orderBy($table_name.$sort_by, $sort_type)
        ->orderBy('dov.mes_lis_ord_par_sel_code')
        ->orderBy('dov.mes_lis_ord_tra_dat_delivery_date')
        ->orderBy('dov.mes_lis_ord_tra_goo_major_category')
        ->orderBy('dov.mes_lis_ord_log_del_delivery_service_code')
        ->orderBy('dov.mes_lis_ord_tra_ins_temperature_code')
        ->paginate($per_page);
        // $byr_buyer = $this->all_used_fun->get_company_list($cmn_company_id);
        Log::debug(__METHOD__.':end---');
        return response()->json(['order_list' => $result]);
        // return response()->json(['order_list' => $result, 'byr_buyer_list' => $byr_buyer]);
    }
}
