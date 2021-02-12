<?php

namespace App\Http\Controllers\API\DATA\RECEIVE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AllUsedFunction;
use App\Models\ADM\User;
use App\Models\DATA\RCV\data_receive;
use App\Models\BYR\byr_corrected_receive;

class ReceiveController extends Controller
{
    //orderReceiveList

    private $all_used_fun;

    public function __construct(){
        $this->all_used_fun = new AllUsedFunction();
    }

    public function orderReceiveList(Request $request){
        return $request->all();
        $adm_user_id = $request->adm_user_id;
        $byr_buyer_id = $request->byr_buyer_id;
        $submit_type = $request->submit_type;
        $search_where = '';
        $having_var = '';

        if ($submit_type == "search") {
            // 条件指定検索
            $receive_date_from = $request->receive_date_from; // 受信日時開始
            $receive_date_to = $request->receive_date_to; // 受信日時終了
            $delivery_date_from = $request->delivery_date_from; // 納品日開始
            $delivery_date_to = $request->delivery_date_to; // 納品日終了
            $delivery_service_code = $request->delivery_service_code; // 便
            $temperature = $request->temperature; // 配送温度区分

            // $check_datetime=$request->check_datetime;
            $confirmation_status = $request->confirmation_status; // 参照
            $decission_cnt = $request->decission_cnt; // 確定
            $print_cnt = $request->print_cnt; // 印刷

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
            $cmn_company_info = cmn_companies_user::select('slr_sellers.cmn_company_id', 'slr_sellers.slr_seller_id', 'cmn_connects.cmn_connect_id')
                ->join('slr_sellers', 'slr_sellers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
                ->join('cmn_connects', 'cmn_connects.slr_seller_id', '=', 'slr_sellers.slr_seller_id')
                ->where('cmn_companies_users.adm_user_id', $adm_user_id)->first();
            $cmn_company_id = $cmn_company_info->cmn_company_id;
            $cmn_connect_id = $cmn_company_info->cmn_connect_id;
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

        return response()->json(['order_list' => $result, 'byr_buyer_list' => $byr_buyer, 'buyer_settings' => $buyer_settings->setting_information]);
        // $authUser=User::find($adm_user_id);
        // $cmn_company_id = 0;
        // if(!$authUser->hasRole(config('const.adm_role_name'))){
        //     $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id);
        //     $cmn_company_id = $cmn_company_info['cmn_company_id'];
        //     $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        //     $result = data_receive::select('data_receives.*','cmn_companies.company_name')
        //     ->join('cmn_connects','cmn_connects.cmn_connect_id','=','data_receives.cmn_connect_id')
        //     ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
        //     ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')
        //     ->where('data_receives.cmn_connect_id',$cmn_connect_id)->get();
        // }else{
        //     $result = data_receive::select('data_receives.*','cmn_companies.company_name')
        //     ->join('cmn_connects','cmn_connects.cmn_connect_id','=','data_receives.cmn_connect_id')
        //     ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
        //     ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')->get();

        // }

        // $byr_buyer =$this->all_used_fun->get_company_list($cmn_company_id);

        // return response()->json(['received_item_list' => $result,'byr_buyer_list'=>$byr_buyer]);
    }

    public function correctedReceiveList($adm_user_id){
        $authUser=User::find($adm_user_id);
        $cmn_company_id = 0;
        if(!$authUser->hasRole(config('const.adm_role_name'))){
            $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
            $result = byr_corrected_receive::select('byr_corrected_receives.*','cmn_companies.company_name')
            ->join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_corrected_receives.cmn_connect_id')
            ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
            ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')
            ->where('byr_corrected_receives.cmn_connect_id',$cmn_connect_id)->get();
        }else{
            $result = byr_corrected_receive::select('byr_corrected_receives.*','cmn_companies.company_name')
            ->join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_corrected_receives.cmn_connect_id')
            ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
            ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')->get();
        }

        $byr_buyer =$this->all_used_fun->get_company_list($cmn_company_id);

        return response()->json(['corrected_list' => $result,'byr_buyer_list'=>$byr_buyer]);
    }
}
