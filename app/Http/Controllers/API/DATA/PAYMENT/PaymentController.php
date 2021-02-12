<?php

namespace App\Http\Controllers\API\DATA\PAYMENT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ADM\User;
use App\Http\Controllers\API\AllUsedFunction;
use App\Models\CMN\cmn_companies_user;
use App\Models\DATA\PAYMENT\data_payment;
use App\Models\BYR\byr_buyer;

class PaymentController extends Controller
{
    private $all_used_fun;

    public function __construct(){
        $this->all_used_fun = new AllUsedFunction();
    }


    public function getPaymentList(Request $request){
        $adm_user_id = $request->adm_user_id;
        $byr_buyer_id = $request->byr_buyer_id;
        $per_page = $request->per_page == null ? 10 : $request->per_page;
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
        $result=data_payment::select('data_payments.data_payment_id','data_payments.receive_datetime',
        'dpp.mes_lis_pay_pay_code',
        'dpp.mes_lis_buy_name',
        // 'dpp.check_datetime',
        'dpp.mes_lis_pay_per_end_date',
        'dppd.mes_lis_pay_lin_det_pay_out_date',
        'dppd.mes_lis_pay_lin_det_amo_payable_amount',
        )
        ->join('data_payment_pays as dpp','data_payments.data_payment_id','=','dpp.data_payment_id')
        ->join('data_payment_pay_details as dppd','dpp.data_payment_pay_id','=','dppd.data_payment_pay_id')
        ->where('data_payments.cmn_connect_id','=',$cmn_connect_id)
        ->groupBy('data_payments.receive_datetime')
        ->groupBy('data_payments.sta_sen_identifier')
        ->paginate($per_page);

        // $result = new Paginator($result, 2);
        $buyer_settings = byr_buyer::select('setting_information')->where('byr_buyer_id', $byr_buyer_id)->first();
        $byr_buyer = $this->all_used_fun->get_company_list($cmn_company_id);

        return response()->json(['payment_item_list' => $result, 'byr_buyer_list' => $byr_buyer, 'buyer_settings' => $buyer_settings->setting_information]);
    }
}
