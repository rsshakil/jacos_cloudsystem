<?php

namespace App\Http\Controllers\API\DATA\PAYMENT;

use App\Http\Controllers\API\AllUsedFunction;
use App\Http\Controllers\API\DATA\PAYMENT\DataController;
use App\Http\Controllers\Controller;
use App\Models\ADM\User;
use App\Models\BYR\byr_buyer;
use App\Models\DATA\PAYMENT\data_payment;
use App\Models\DATA\PAYMENT\data_payment_pay;
use App\Models\DATA\PAYMENT\data_payment_pay_detail;
use App\Traits\Csv;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $all_used_fun;

    public function __construct()
    {
        $this->all_used_fun = new AllUsedFunction();
        $this->all_used_fun->folder_create('app/'.config('const.PAYMENT_CSV_PATH'));
    }

    public function getPaymentList(Request $request)
    {
        // return $request->all();
        $adm_user_id = $request->adm_user_id;
        $byr_buyer_id = $request->byr_buyer_id;
        $per_page = $request->per_page == null ? 10 : $request->per_page;
        $submit_type = $request->submit_type;
        $search_where = array();
        $having_var = '';
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;

        // if ($submit_type == "search") {
            // 条件指定検索
            $mes_lis_pay_pay_code = $request->mes_lis_pay_pay_code; // 受信日時開始
            $receive_date_from = $request->receive_date_from; // 受信日時開始
            $receive_date_to = $request->receive_date_to; // 受信日時終了
            $mes_lis_buy_name = $request->mes_lis_buy_name; // 納品日開始
            $mes_lis_pay_per_end_date_from = $request->mes_lis_pay_per_end_date_from; // 納品日開始
            $mes_lis_pay_per_end_date_to = $request->mes_lis_pay_per_end_date_to; // 納品日終了
            $check_datetime = $request->check_datetime; // 便


        // }
        $authUser = User::find($adm_user_id);
        $cmn_company_id = '';
        $cmn_connect_id = '';
        if (!$authUser->hasRole(config('const.adm_role_name'))) {
            $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id, $byr_buyer_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }
        $search_where[] = ['data_payments.cmn_connect_id', '=', $cmn_connect_id];
        // 検索
        $table_name = 'dpp.';
        if ($sort_by == "receive_datetime" || $sort_by == "data_payment_id") {
            $table_name = 'data_payments.';
        } else if ($sort_by == "mes_lis_pay_pay_code" || $sort_by == "mes_lis_buy_name" || $sort_by == "mes_lis_pay_per_end_date" || $sort_by == "check_datetime") {
            $table_name = 'dpp.';
        } else if ($sort_by == "mes_lis_pay_lin_det_pay_out_date" || $sort_by == "mes_lis_pay_lin_det_amo_payable_amount") {
            $table_name = 'dppd.';
        }

        $result = data_payment::select('data_payments.data_payment_id', 'data_payments.receive_datetime',
            'dpp.mes_lis_pay_pay_code',
            'dpp.mes_lis_buy_name',
            'dpp.check_datetime',
            'dpp.mes_lis_pay_per_end_date',
            'dppd.mes_lis_pay_lin_det_pay_out_date',
            'dppd.mes_lis_pay_lin_det_amo_payable_amount',
            DB::raw('(dppd.mes_lis_pay_lin_det_amo_payable_amount+dppd.mes_lis_pay_lin_det_amo_tax) as total_amount')
        )
            ->join('data_payment_pays as dpp', 'data_payments.data_payment_id', '=', 'dpp.data_payment_id')
            ->join('data_payment_pay_details as dppd', 'dpp.data_payment_pay_id', '=', 'dppd.data_payment_pay_id');
            // ->where($search_where);
            if ($mes_lis_pay_pay_code !=null) {
                $result =$result->where('dpp.mes_lis_pay_pay_code',$mes_lis_pay_pay_code);
            }
            if ($receive_date_from && $receive_date_to) {
                $result= $result->whereBetween('data_payments.receive_datetime', [$receive_date_from, $receive_date_to]);
            }
            if ($mes_lis_pay_per_end_date_from && $mes_lis_pay_per_end_date_to) {
                $result= $result->whereBetween('dpp.mes_lis_pay_per_end_date', [$mes_lis_pay_per_end_date_from, $mes_lis_pay_per_end_date_to]);
            }
            if ($mes_lis_buy_name !=null) {
                $result =$result->where('dpp.mes_lis_buy_name',$mes_lis_buy_name);
            }
            if ($check_datetime!='*') {
                if($check_datetime==1){
                    $result= $result->whereNull('dpp.check_datetime');
                }else{
                    $result= $result->whereNotNull('dpp.check_datetime');
                }
            }
            $result =$result->where('dppd.mes_lis_pay_lin_det_pay_code','3003')
        // ->where('data_payments.cmn_connect_id','=',$cmn_connect_id)
            ->groupBy('data_payments.receive_datetime')
            ->groupBy('dpp.mes_lis_pay_pay_code')
            ->groupBy('dpp.mes_lis_pay_per_end_date')
            ->groupBy('dppd.mes_lis_pay_lin_det_pay_out_date')
            ->orderBy($table_name . $sort_by, $sort_type)

            ->paginate($per_page);

        // $result = new Paginator($result, 2);
        // $buyer_settings = byr_buyer::select('setting_information')->where('byr_buyer_id', $byr_buyer_id)->first();
        $byr_buyer = $this->all_used_fun->get_company_list($cmn_company_id);
        // 'buyer_settings' => $buyer_settings->setting_information
        return response()->json(['payment_item_list' => $result, 'byr_buyer_list' => $byr_buyer]);
    }

    public function get_payment_detail_list(Request $request)
    {
        $data_payment_id = $request->data_payment_id;
        $today=date('Y-m-d H:i:s');
        $result = data_payment::select('data_payments.data_payment_id', 'data_payments.receive_datetime',
            'dpp.mes_lis_pay_pay_code',
            'dpp.mes_lis_pay_pay_name',
            'dpp.mes_lis_pay_pay_gln',
            'dpp.mes_lis_pay_pay_id',
            'dpp.mes_lis_buy_name',
            'dpp.mes_lis_buy_code',
            'dpp.check_datetime',
            'dpp.mes_lis_pay_per_end_date',
            'dppd.mes_lis_pay_lin_det_pay_out_date',
            'dppd.mes_lis_pay_lin_det_amo_payable_amount',
            DB::raw('(dppd.mes_lis_pay_lin_det_amo_payable_amount+dppd.mes_lis_pay_lin_det_amo_tax) as total_amount')
        )
            ->join('data_payment_pays as dpp', 'data_payments.data_payment_id', '=', 'dpp.data_payment_id')
            ->join('data_payment_pay_details as dppd', 'dpp.data_payment_pay_id', '=', 'dppd.data_payment_pay_id')
            ->where('dpp.data_payment_id', $data_payment_id)
            ->where('dppd.mes_lis_pay_lin_det_pay_code','3003')
        // ->where('data_payments.cmn_connect_id','=',$cmn_connect_id)
            ->groupBy('data_payments.receive_datetime')
            ->groupBy('dpp.mes_lis_pay_pay_code')
            ->groupBy('dpp.mes_lis_pay_per_end_date')
            ->groupBy('dppd.mes_lis_pay_lin_det_pay_out_date')
            ->first();
        $paymentdetailTopTable = data_payment_pay_detail::select(
            DB::raw("SUM(mes_lis_pay_lin_det_amo_payable_amount + mes_lis_pay_lin_det_amo_tax) as totalAmount")
        )
            ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')

            ->where(['mes_lis_pay_lin_det_pay_code' => '3003', 'dpp.data_payment_id' => $data_payment_id])->groupBy('data_payment_pay_details.data_payment_pay_id')->first();

        $paymentdetailRghtTable = data_payment_pay_detail::select(
            // DB::raw('SUM(data_payment_pay_details.mes_lis_pay_lin_det_amo_requested_amount) as mes_lis_pay_lin_det_amo_requested_amount_sum'),
            DB::raw('SUM(CASE WHEN data_payment_pay_details.mes_lis_pay_lin_det_amo_pay_plus_minus = "+" or data_payment_pay_details.mes_lis_pay_lin_det_amo_pay_plus_minus is NULL then data_payment_pay_details.mes_lis_pay_lin_det_amo_payable_amount
             WHEN data_payment_pay_details.mes_lis_pay_lin_det_amo_pay_plus_minus = "-" then - data_payment_pay_details.mes_lis_pay_lin_det_amo_payable_amount
        END) as mes_lis_pay_lin_det_amo_payable_amount_sum'),
            'data_payment_pay_details.mes_lis_pay_lin_det_det_meaning',
            'data_payment_pay_details.mes_lis_pay_lin_det_det_code',
            'dpp.mes_lis_pay_pay_code')
            ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')
            ->where(['data_payment_pay_details.mes_lis_pay_lin_det_pay_code' => '2000', 'dpp.data_payment_id' => $data_payment_id])->groupBy('data_payment_pay_details.mes_lis_pay_lin_det_det_code')->get();

        $pQ1 = data_payment_pay_detail::select(
            DB::raw('"仕入合計金額" as p_title'),
            DB::raw('SUM(mes_lis_pay_lin_det_amo_requested_amount) as amount'),
            DB::raw('"1" as sumation_type')
        )
            ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')

            ->where('mes_lis_pay_lin_det_pay_code', '3001')->where('dpp.data_payment_id', $data_payment_id)->groupBy('data_payment_pay_details.data_payment_pay_id');
        $pQ2 = data_payment_pay_detail::select(
            DB::raw('"仕入消費税" as p_title'),
            DB::raw('SUM(mes_lis_pay_lin_det_amo_tax) as amount'),
            DB::raw('"1" as sumation_type')
        )
            ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')

            ->where('mes_lis_pay_lin_det_pay_code', '3001')->where('dpp.data_payment_id', $data_payment_id)->groupBy('data_payment_pay_details.data_payment_pay_id');

        $pQ3 = data_payment_pay_detail::select(
            DB::raw('"相殺合計金額" as p_title'),
            DB::raw('SUM(mes_lis_pay_lin_det_amo_payable_amount) as amount'),
            DB::raw('"2" as sumation_type')
        )
            ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')

            ->where('mes_lis_pay_lin_det_pay_code', '3002')->where('dpp.data_payment_id', $data_payment_id)->groupBy('data_payment_pay_details.data_payment_pay_id');
        $pQ4 = data_payment_pay_detail::select(
            DB::raw('"相殺消費税" as p_title'),
            DB::raw('SUM(mes_lis_pay_lin_det_amo_tax) as amount'),
            DB::raw('"2" as sumation_type')
        )
            ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')

            ->where('mes_lis_pay_lin_det_pay_code', '3002')->where('dpp.data_payment_id', $data_payment_id)->groupBy('data_payment_pay_details.data_payment_pay_id');
        $pdtableleft = $pQ1->union($pQ2)->union($pQ3)->union($pQ4)->orderBy('sumation_type', 'ASC')->get();
        data_payment_pay::where('data_payment_id',$data_payment_id)->whereNull('check_datetime')->update(['check_datetime'=>$today]);
        return response()->json(['payment_item_header' => $result, 'paymentdetailTopTable' => $paymentdetailTopTable, 'pdtableleft' => $pdtableleft, 'paymentdetailRghtTable' => $paymentdetailRghtTable]);
    }

    public function get_payment_item_detail_list(Request $request)
    {
        // return $request->all();
        $payment_id = $request->payment_id;
        $byr_buyer_id = $request->byr_buyer_id;
        $per_page = $request->select_field_per_page_num;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $category_code = $request->category_code;

        $category_code = $category_code['category_code'];

        $mes_lis_pay_lin_tra_code = $request->mes_lis_pay_lin_tra_code;

        $mes_lis_pay_lin_lin_trade_number_eference = $request->mes_lis_pay_lin_lin_trade_number_eference;
        $mes_lis_inv_lin_det_pay_code = $request->mes_lis_inv_lin_det_pay_code;
        $mes_lis_pay_lin_det_verification_result_code = $request->mes_lis_pay_lin_det_verification_result_code;
        $mes_lis_pay_lin_det_trade_type_code = $request->mes_lis_pay_lin_det_trade_type_code;
        $mes_lis_pay_lin_det_balance_carried_code = $request->mes_lis_pay_lin_det_balance_carried_code;
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;
        $result = data_payment::select('data_payments.data_payment_id', 'data_payments.receive_datetime',
            'dpp.mes_lis_pay_pay_code',
            'dpp.mes_lis_pay_pay_name',
            'dpp.mes_lis_pay_pay_gln',
            'dpp.mes_lis_pay_pay_id',
            'dpp.mes_lis_buy_name',
            'dpp.mes_lis_buy_code',
            'dpp.check_datetime',
            'dpp.mes_lis_pay_per_end_date',
            'dppd.mes_lis_pay_lin_det_pay_out_date',
            'dppd.mes_lis_pay_lin_det_amo_payable_amount'
        )
            ->join('data_payment_pays as dpp', 'data_payments.data_payment_id', '=', 'dpp.data_payment_id')
            ->join('data_payment_pay_details as dppd', 'dpp.data_payment_pay_id', '=', 'dppd.data_payment_pay_id')
            ->where('dpp.data_payment_id', $payment_id)
        // ->where('data_payments.cmn_connect_id','=',$cmn_connect_id)
            ->groupBy('data_payments.receive_datetime')
            ->groupBy('dpp.mes_lis_pay_pay_code')
            ->groupBy('dpp.mes_lis_pay_per_end_date')
            ->groupBy('dppd.mes_lis_pay_lin_det_pay_out_date')
            ->first();

        $result1 = data_payment_pay_detail::
            join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')
            ->where(['dpp.data_payment_id' => $payment_id])
            ->whereIn('data_payment_pay_details.mes_lis_pay_lin_det_pay_code', ['1001', '1002', '1004']);
        if ($from_date != '' && $from_date != null) {
            $result1 = $result1->whereDate('data_payment_pay_details.mes_lis_pay_lin_det_transfer_of_ownership_date', '>=', $from_date);
        }
        if ($to_date != '' && $to_date != null) {
            $result1 = $result1->whereDate('data_payment_pay_details.mes_lis_pay_lin_det_transfer_of_ownership_date', '<=', $to_date);
        }
        if ($mes_lis_pay_lin_tra_code != '' && $mes_lis_pay_lin_tra_code != null) {
            $result1 = $result1->where('data_payment_pay_details.mes_lis_pay_lin_tra_code', $mes_lis_pay_lin_tra_code);
        }
        if ($mes_lis_pay_lin_lin_trade_number_eference != '' && $mes_lis_pay_lin_lin_trade_number_eference != null) {
            $result1 = $result1->where('data_payment_pay_details.mes_lis_pay_lin_lin_trade_number_eference', $mes_lis_pay_lin_lin_trade_number_eference);
        }

        if ($mes_lis_inv_lin_det_pay_code != '*') {
            $result1 = $result1->where('data_payment_pay_details.mes_lis_pay_lin_det_pay_code', $mes_lis_inv_lin_det_pay_code);
        }

        if ($mes_lis_pay_lin_det_verification_result_code != '*') {
            $result1 = $result1->where('data_payment_pay_details.mes_lis_pay_lin_det_verification_result_code', $mes_lis_pay_lin_det_verification_result_code);
        }

        if ($mes_lis_pay_lin_det_trade_type_code != '*') {
            $result1 = $result1->where('data_payment_pay_details.mes_lis_pay_lin_det_trade_type_code', $mes_lis_pay_lin_det_trade_type_code);
        }

        if ($mes_lis_pay_lin_det_balance_carried_code != '*') {
            $result1 = $result1->where('data_payment_pay_details.mes_lis_pay_lin_det_balance_carried_code', $mes_lis_pay_lin_det_balance_carried_code);
        }

        if ($category_code != '*') {
            $result1 = $result1->where('data_payment_pay_details.mes_lis_pay_lin_det_goo_major_category', $category_code);
        }
        $result1 = $result1->orderBy('data_payment_pay_details.' . $sort_by, $sort_type);

        $paymentdetailTopTable = $result1->paginate($per_page);
        $byr_buyer_category_list = $this->all_used_fun->get_allCategoryByByrId($byr_buyer_id);
        $buyer_settings = byr_buyer::select('setting_information')->where('byr_buyer_id', $byr_buyer_id)->first();
        $buyer_settings = $buyer_settings->setting_information;
        return response()->json(['payment_item_header' => $result, 'paymentdetailTopTable' => $paymentdetailTopTable, 'byr_buyer_category_list' => $byr_buyer_category_list, 'buyer_settings' => $buyer_settings]);
    }
    public function paymentDownload(Request $request)
    {
        // $this->all_used_fun->folder_create('app/'.config('const.PAYMENT_CSV_PATH'));
        // return $request->all();
        $data_payment_id=$request->data_payment_id?$request->data_payment_id:1;
        $downloadType = $request->downloadType;
        $new_file_name ='';
        $csv_data_count = 0;
        if ($downloadType == 1) {
            // CSV Download
            $new_file_name = $this->all_used_fun->downloadFileName($request, 'csv');
            // self::paymentFileName($data_payment_id, 'csv');
            $download_file_url = Config::get('app.url') . "storage/app" . config('const.PAYMENT_CSV_PATH') . "/" . $new_file_name;

            // get shipment data query
            $payment_query = DataController::getPaymentData($request);
            $csv_data_count = $payment_query->count();
            $payment_data = $payment_query->get()->toArray();

            // CSV create
            Csv::create(
                config('const.PAYMENT_CSV_PATH') . "/" . $new_file_name,
                $payment_data,
                DataController::paymentCsvHeading(),
                'shift-jis'
            );
        }

        return response()->json(['message' => 'Success', 'status' => 1, 'new_file_name' => $new_file_name, 'url' => $download_file_url, 'csv_data_count' => $csv_data_count]);
    }
    private static function paymentFileName($data_payment_id, $file_type = "csv")
    {
        $file_name_info = data_payment::select('cmn_connects.partner_code', 'byr_buyers.super_code', 'cmn_companies.jcode','cmn_companies.company_name')
            ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'data_payments.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
            ->join('slr_sellers', 'slr_sellers.slr_seller_id', '=', 'cmn_connects.slr_seller_id')
            ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'slr_sellers.cmn_company_id')
            ->where('data_payments.data_payment_id', $data_payment_id)
            ->first();
            $file_name = '受注'.'_'.$file_name_info->company_name.'_'.date('YmdHis').'.'.$file_type;
        // $file_name = $file_name_info->super_code . '-' . "payment_" . $file_name_info->super_code . '-' . $file_name_info->partner_code . "-" . $file_name_info->jcode . '_payment_' . date('YmdHis') . '.' . $file_type;
        return $file_name;
    }

    public function get_payment_customer_code_list(Request $request)
    {
        $cmn_connect_id = $this->all_used_fun->getCmnConnectId($request->adm_user_id,$request->byr_buyer_id);
        $result = DB::select("SELECT
        dpp.mes_lis_buy_code,
        dpp.mes_lis_buy_name,
        dpp.mes_lis_pay_pay_code,
        dpp.mes_lis_pay_pay_name
        FROM
       data_payments AS dp
       INNER JOIN data_payment_pays AS dpp ON dp.data_payment_id=dpp.data_payment_id
       WHERE dp.cmn_connect_id='".$cmn_connect_id."'
       GROUP BY
        dpp.mes_lis_buy_code,
        dpp.mes_lis_pay_pay_code");
        return response()->json(['order_customer_code_lists' => $result]);

    }
}
