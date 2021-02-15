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
        $search_where = array();
        $having_var = '';

        if ($submit_type == "search") {
            // 条件指定検索
            $mes_lis_pay_pay_code = $request->mes_lis_pay_pay_code; // 受信日時開始
            $receive_date_from = $request->receive_date_from; // 受信日時開始
            $receive_date_to = $request->receive_date_to; // 受信日時終了
            $mes_lis_buy_name = $request->mes_lis_buy_name; // 納品日開始
            $mes_lis_pay_per_end_date_from = $request->mes_lis_pay_per_end_date_from; // 納品日開始
            $mes_lis_pay_per_end_date_to = $request->mes_lis_pay_per_end_date_to; // 納品日終了
            $check_datetime = $request->check_datetime; // 便
            $search_where=array(
                ['dpp.mes_lis_pay_pay_code', '=', $mes_lis_pay_pay_code],
                ['data_payments.receive_datetime', '>=', $receive_date_from],
                ['data_payments.receive_datetime', '<', $receive_date_to],
                ['dpp.mes_lis_buy_name', '=', $mes_lis_buy_name],
                ['dpp.mes_lis_pay_per_end_date', '>=', $mes_lis_pay_per_end_date_from],
                ['dpp.mes_lis_pay_per_end_date', '<', $mes_lis_pay_per_end_date_to],
                ['dpp.check_datetime', '=', $check_datetime]
            );
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
        $search_where[]=['data_payments.cmn_connect_id','=',$cmn_connect_id];
        // 検索
        $result=data_payment::select('data_payments.data_payment_id','data_payments.receive_datetime',
        'dpp.mes_lis_pay_pay_code',
        'dpp.mes_lis_buy_name',
        'dpp.check_datetime',
        'dpp.mes_lis_pay_per_end_date',
        'dppd.mes_lis_pay_lin_det_pay_out_date',
        'dppd.mes_lis_pay_lin_det_amo_payable_amount',
        )
        ->join('data_payment_pays as dpp','data_payments.data_payment_id','=','dpp.data_payment_id')
        ->join('data_payment_pay_details as dppd','dpp.data_payment_pay_id','=','dppd.data_payment_pay_id')
        ->where($search_where)
        // ->where('data_payments.cmn_connect_id','=',$cmn_connect_id)
        ->groupBy('data_payments.receive_datetime')
        ->groupBy('dpp.mes_lis_pay_pay_code')
        ->groupBy('dpp.mes_lis_pay_per_end_date')
        ->groupBy('dppd.mes_lis_pay_lin_det_pay_out_date')
        ->paginate($per_page);

        // $result = new Paginator($result, 2);
        // $buyer_settings = byr_buyer::select('setting_information')->where('byr_buyer_id', $byr_buyer_id)->first();
        $byr_buyer = $this->all_used_fun->get_company_list($cmn_company_id);
        // 'buyer_settings' => $buyer_settings->setting_information
        return response()->json(['payment_item_list' => $result, 'byr_buyer_list' => $byr_buyer]);
    }
}
