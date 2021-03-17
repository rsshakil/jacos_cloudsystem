<?php

namespace App\Http\Controllers\API\DATA\RECEIVE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AllUsedFunction;
use App\Models\ADM\User;
use App\Models\DATA\RCV\data_receive;
use App\Models\DATA\RCV\data_receive_voucher;
use App\Models\DATA\RCV\data_receive_item;
use App\Models\CMN\cmn_companies_user;
use App\Models\BYR\byr_buyer;
use App\Models\BYR\byr_corrected_receive;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class ReceiveController extends Controller
{
    //orderReceiveList

    private $all_used_fun;

    public function __construct(){
        $this->all_used_fun = new AllUsedFunction();
    }

    public function orderReceiveList(Request $request){
        // return $request->all();
        $adm_user_id = $request->adm_user_id;
        $byr_buyer_id = $request->byr_buyer_id;
        $per_page = $request->per_page == null ? 10 : $request->per_page;
        $submit_type = $request->submit_type;
        $byr_category_code = $request->category_code; // 印刷
        $byr_category_code = $byr_category_code['category_code'];
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

            if ($byr_category_code!='*') {
                $search_where .= "AND dov.mes_lis_ord_tra_goo_major_category='" . $byr_category_code . "' ";
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
        $result=data_receive::select('data_receives.data_receive_id','data_receives.receive_datetime','drv.mes_lis_acc_par_sel_code','drv.mes_lis_acc_par_sel_name',
        'drv.mes_lis_acc_tra_dat_transfer_of_ownership_date','drv.mes_lis_acc_tra_dat_delivery_date','drv.mes_lis_acc_tra_goo_major_category',
        'drv.mes_lis_acc_log_del_delivery_service_code','drv.mes_lis_acc_tra_ins_temperature_code','drv.check_datetime')
        ->join('data_receive_vouchers as drv','data_receives.data_receive_id','=','drv.data_receive_id')
        ->where('data_receives.cmn_connect_id','=',$cmn_connect_id)
        ->groupBy('data_receives.receive_datetime')
        ->groupBy('data_receives.sta_sen_identifier')
        ->groupBy('drv.mes_lis_acc_par_sel_code')
        ->groupBy('drv.mes_lis_acc_par_sel_name')
        // ->groupBy('drv.mes_lis_acc_tra_dat_delivery_date')
        // ->groupBy('drv.mes_lis_acc_tra_goo_major_category')
        // ->groupBy('drv.mes_lis_acc_log_del_delivery_service_code')
        // ->groupBy('drv.mes_lis_acc_tra_ins_temperature_code')
        ->paginate($per_page);

        // $result = new Paginator($result, 2);
        $buyer_settings = byr_buyer::select('setting_information')->where('byr_buyer_id', $byr_buyer_id)->first();
        $byr_buyer = $this->all_used_fun->get_company_list($cmn_company_id);
        $byr_buyer_category_list = $this->all_used_fun->get_allCategoryByByrId($byr_buyer_id);

        return response()->json(['received_item_list' => $result, 'byr_buyer_list' => $byr_buyer, 'buyer_settings' => $buyer_settings->setting_information,'byr_buyer_category_list'=>$byr_buyer_category_list]);

    }

    public function orderReceiveDetailList(Request $request){
        // return $request->all();
        $adm_user_id = $request->adm_user_id;
        $byr_buyer_id = $request->byr_buyer_id;
        $data_receive_id = $request->data_receive_id;
        $per_page = $request->select_field_per_page_num == null ? 10 : $request->select_field_per_page_num;
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


        /*receive order info for single row*/
        $orderInfo=data_receive_voucher::join('data_receives as dr','dr.data_receive_id','=','data_receive_vouchers.data_receive_id')
        ->where('dr.cmn_connect_id','=',$cmn_connect_id)
        ->where('data_receive_vouchers.data_receive_id','=',$data_receive_id)
        // ->groupBy('data_receives.receive_datetime')
        ->groupBy('dr.sta_sen_identifier')
        ->groupBy('data_receive_vouchers.mes_lis_acc_par_sel_code')
        ->groupBy('data_receive_vouchers.mes_lis_acc_par_sel_name')->first();
        /*receive order info for single row*/
        // 検索
        $result=data_receive_voucher::select('data_receive_vouchers.*','dsv.mes_lis_shi_tra_dat_order_date','dsv.mes_lis_shi_tra_trade_number','dsv.mes_lis_shi_tot_tot_net_price_total','dr.cmn_connect_id')
        ->join('data_receives as dr','dr.data_receive_id','=','data_receive_vouchers.data_receive_id')
        ->leftJoin('data_shipment_vouchers as dsv','dsv.mes_lis_shi_tra_trade_number','=','data_receive_vouchers.mes_lis_acc_tra_trade_number')
        ->where('dr.cmn_connect_id','=',$cmn_connect_id)
        ->where('data_receive_vouchers.data_receive_id','=',$data_receive_id)
        // ->whereColumn([
        //     ['data_receive_vouchers.mes_lis_acc_tra_dat_order_date', 'dsv.mes_lis_shi_tra_dat_order_date'],
        //     ['data_receive_vouchers.mes_lis_acc_tra_trade_number', 'dsv.mes_lis_shi_tra_trade_number'],
        // ])
        //->whereColumn('data_receive_vouchers.mes_lis_acc_tra_dat_order_date','=','dsv.mes_lis_shi_tra_dat_order_date')
        //->whereColumn('data_receive_vouchers.mes_lis_acc_tra_trade_number','=','dsv.mes_lis_shi_tra_trade_number')
        ->groupBy('data_receive_vouchers.mes_lis_acc_tra_trade_number')
        // ->groupBy('data_receives.receive_datetime')
        // ->groupBy('dr.sta_sen_identifier')
        // ->groupBy('data_receive_vouchers.mes_lis_acc_par_sel_code')
        // ->groupBy('data_receive_vouchers.mes_lis_acc_par_sel_name')
        ->paginate($per_page);

        // $result = new Paginator($result, 2);
        $buyer_settings = byr_buyer::select('setting_information')->where('byr_buyer_id', $byr_buyer_id)->first();
        $byr_buyer = $this->all_used_fun->get_company_list($cmn_company_id);

        return response()->json(['received_detail_list' => $result, 'byr_buyer_list' => $byr_buyer, 'buyer_settings' => $buyer_settings->setting_information,'order_info'=>$orderInfo]);

    }

    public function orderReceiveItemDetailList(Request $request){
        // return $request->all();
        $adm_user_id = $request->adm_user_id;
        $byr_buyer_id = $request->byr_buyer_id;
        $data_receive_voucher_id = $request->data_receive_voucher_id;
        $per_page = $request->select_field_per_page_num == null ? 10 : $request->select_field_per_page_num;

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


        /*receive order info for single row*/
        $orderInfo=data_receive_item::
        join('data_receive_vouchers as drv','drv.data_receive_voucher_id','=','data_receive_items.data_receive_voucher_id')
        ->join('data_receives as dr','dr.data_receive_id','=','drv.data_receive_id')
        ->where('dr.cmn_connect_id','=',$cmn_connect_id)
        ->where('drv.data_receive_voucher_id','=',$data_receive_voucher_id)
        // ->groupBy('data_receives.receive_datetime')
        ->groupBy('dr.sta_sen_identifier')
        ->groupBy('drv.mes_lis_acc_par_sel_code')
        ->groupBy('drv.mes_lis_acc_par_sel_name')->first();
        /*receive order info for single row*/
        // 検索
        $result=data_receive_item::join('data_receive_vouchers as drv','drv.data_receive_voucher_id','=','data_receive_items.data_receive_voucher_id')
        ->join('data_receives as dr','dr.data_receive_id','=','drv.data_receive_id')
        ->leftJoin('data_order_vouchers as dov','dov.mes_lis_ord_tra_trade_number','=','drv.mes_lis_acc_tra_trade_number')
        ->leftJoin('data_order_items as doi','doi.data_order_voucher_id','=','dov.data_order_voucher_id')
        ->where('dr.cmn_connect_id','=',$cmn_connect_id)
        ->where('drv.data_receive_voucher_id','=',$data_receive_voucher_id)
        //->groupBy('drv.mes_lis_acc_tra_trade_number')
       // ->paginate($per_page);
        ->get();

        // $result = new Paginator($result, 2);
        $buyer_settings = byr_buyer::select('setting_information')->where('byr_buyer_id', $byr_buyer_id)->first();
        $byr_buyer = $this->all_used_fun->get_company_list($cmn_company_id);

        return response()->json(['received_item_detail_list' => $result, 'byr_buyer_list' => $byr_buyer, 'buyer_settings' => $buyer_settings->setting_information,'order_info'=>$orderInfo]);

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
