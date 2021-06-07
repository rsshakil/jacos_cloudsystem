<?php

namespace App\Http\Controllers\API\BYR\DATA\PAYMENT;

use App\Http\Controllers\API\AllUsedFunction;
use App\Http\Controllers\API\BYR\DATA\PAYMENT\DataController;
use App\Http\Controllers\Controller;
use App\Models\ADM\User;
use App\Models\BYR\byr_buyer;
use App\Models\DATA\PAYMENT\data_payment;
use App\Models\DATA\PAYMENT\data_payment_pay;
use App\Models\DATA\PAYMENT\data_payment_pay_detail;
use App\Models\DATA\INVOICE\data_invoice;
use App\Traits\Csv;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $buyer_info = Auth::User()->ByrInfo;
        $byr_buyer_id =$buyer_info->byr_buyer_id;
        $per_page = $request->per_page == null ? 10 : $request->per_page;
        $search_where = array();
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;

        // if ($submit_type == "search") {
            // 条件指定検索
        $mes_lis_pay_pay_code = $request->mes_lis_pay_pay_code; // 受信日時開始
        $receive_date_from = $request->receive_date_from; // 受信日時開始
        $receive_date_to = $request->receive_date_to; // 受信日時終了
        $receive_date_from = $receive_date_from!=null? date('Y-m-d 00:00:00', strtotime($receive_date_from)):$receive_date_from; // 受信日時開始
        $receive_date_to = $receive_date_to!=null? date('Y-m-d 23:59:59', strtotime($receive_date_to)):$receive_date_to; // 受信日時終了
        $mes_lis_buy_name = $request->mes_lis_buy_name; // 納品日開始
        $mes_lis_pay_per_end_date_from = $request->mes_lis_pay_per_end_date_from; // 納品日開始
        $mes_lis_pay_per_end_date_to = $request->mes_lis_pay_per_end_date_to; // 納品日終了
        $mes_lis_pay_per_end_date_from = $mes_lis_pay_per_end_date_from!=null? date('Y-m-d 00:00:00', strtotime($mes_lis_pay_per_end_date_from)):$mes_lis_pay_per_end_date_from; // 受信日時開始
        $mes_lis_pay_per_end_date_to = $mes_lis_pay_per_end_date_to!=null? date('Y-m-d 23:59:59', strtotime($mes_lis_pay_per_end_date_to)):$mes_lis_pay_per_end_date_to; // 受信日時終了
        $mes_lis_pay_lin_det_pay_out_date_from = $request->mes_lis_pay_lin_det_pay_out_date_from;
        $mes_lis_pay_lin_det_pay_out_date_to = $request->mes_lis_pay_lin_det_pay_out_date_to;
        $mes_lis_pay_lin_det_pay_out_date_from = $mes_lis_pay_lin_det_pay_out_date_from!=null? date('Y-m-d 00:00:00', strtotime($mes_lis_pay_lin_det_pay_out_date_from)):$mes_lis_pay_lin_det_pay_out_date_from; // 受信日時開始
        $mes_lis_pay_lin_det_pay_out_date_to = $mes_lis_pay_lin_det_pay_out_date_to!=null? date('Y-m-d 23:59:59', strtotime($mes_lis_pay_lin_det_pay_out_date_to)):$mes_lis_pay_lin_det_pay_out_date_to; // 受信日時終了

        $check_datetime = $request->check_datetime; // 便


        // }
        //$slr_seller_id = Auth::User()->SlrInfo->slr_seller_id;
        $authUser = User::find($adm_user_id);
        $cmn_company_id = '';
        // $cmn_connect_id = '';
        if (!$authUser->hasRole(config('const.adm_role_name'))) {
            $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id, $byr_buyer_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            // $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }
        // $search_where[] = ['data_payments.cmn_connect_id', '=', $cmn_connect_id];
        // 検索
        $table_name = 'dpp.';
        if ($sort_by == "receive_datetime" || $sort_by == "data_payment_id") {
            $table_name = 'data_payments.';
        } elseif ($sort_by == "mes_lis_pay_lin_det_pay_out_date" || $sort_by == "mes_lis_pay_lin_det_amo_payable_amount") {
            $table_name = 'dppd.';
        } else {
            // } else if ($sort_by == "mes_lis_pay_pay_code" || $sort_by == "mes_lis_buy_name" || $sort_by == "mes_lis_pay_per_end_date" || $sort_by == "check_datetime") {
            $table_name = 'dpp.';
        }

        $result = data_payment::select(
            'data_payments.data_payment_id',
            'data_payments.receive_datetime',
            'dpp.mes_lis_pay_pay_code',
            'dpp.mes_lis_buy_name',
            'dpp.check_datetime',
            'dpp.mes_lis_pay_per_end_date',
            'dppd.mes_lis_pay_lin_det_pay_out_date',
            'dppd.mes_lis_pay_lin_det_amo_payable_amount',
            DB::raw('(dppd.mes_lis_pay_lin_det_amo_payable_amount+dppd.mes_lis_pay_lin_det_amo_tax) as total_amount')
        )
            ->join('data_payment_pays as dpp', 'data_payments.data_payment_id', '=', 'dpp.data_payment_id')
            ->join('data_payment_pay_details as dppd', 'dpp.data_payment_pay_id', '=', 'dppd.data_payment_pay_id')
            ->join('cmn_connects as cc', 'cc.cmn_connect_id', '=', 'data_payments.cmn_connect_id')
            ->where('cc.byr_buyer_id', $byr_buyer_id);
           // ->where('cc.slr_seller_id', $slr_seller_id);
            // ->where('data_payments.cmn_connect_id', '=', $cmn_connect_id);
        // ->where($search_where);
        if ($mes_lis_pay_pay_code !=null) {
            $result =$result->where('dpp.mes_lis_pay_pay_code', $mes_lis_pay_pay_code);
        }
        if ($receive_date_from && $receive_date_to) {
            $result= $result->whereBetween('data_payments.receive_datetime', [$receive_date_from, $receive_date_to]);
        }
        if ($mes_lis_pay_per_end_date_from && $mes_lis_pay_per_end_date_to) {
            $result= $result->whereBetween('dpp.mes_lis_pay_per_end_date', [$mes_lis_pay_per_end_date_from, $mes_lis_pay_per_end_date_to]);
        }
        if ($mes_lis_pay_lin_det_pay_out_date_from && $mes_lis_pay_lin_det_pay_out_date_to) {
            $result= $result->whereBetween('dppd.mes_lis_pay_lin_det_pay_out_date', [$mes_lis_pay_lin_det_pay_out_date_from, $mes_lis_pay_lin_det_pay_out_date_to]);
        }
        if ($mes_lis_buy_name !=null) {
            $result =$result->where('dpp.mes_lis_buy_name', $mes_lis_buy_name);
        }
        if ($check_datetime!='*') {
            if ($check_datetime==1) {
                $result= $result->whereNull('dpp.check_datetime');
            } else {
                $result= $result->whereNotNull('dpp.check_datetime');
            }
        }
        $result =$result->where('dppd.mes_lis_pay_lin_det_pay_code', '3003')
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
        $pay_code = $request->pay_code;
        $end_date = $request->end_date;
        $out_date = $request->out_date;
        $today=date('Y-m-d H:i:s');
        $whereClause = [
            'dpp.mes_lis_pay_pay_code'  => $pay_code,
            'dpp.mes_lis_pay_per_end_date'   => $end_date,
            'dppd.mes_lis_pay_lin_det_pay_out_date' => $out_date
        ];

        $result = data_payment::select(
            'data_payments.data_payment_id',
            'data_payments.receive_datetime',
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
            ->where('dppd.mes_lis_pay_lin_det_pay_code', '3003')
            ->where($whereClause)
        // ->where('data_payments.cmn_connect_id','=',$cmn_connect_id)
            // ->groupBy('data_payments.receive_datetime')
            // ->groupBy('dpp.mes_lis_pay_pay_code')
            // ->groupBy('dpp.mes_lis_pay_per_end_date')
            // ->groupBy('dppd.mes_lis_pay_lin_det_pay_out_date')
            ->first();
        // $paymentdetailTopTable = data_payment_pay_detail::select(
        // $paymentdetailTopTable = data_payment_pay_detail::select(
        //     DB::raw("SUM(mes_lis_pay_lin_det_amo_payable_amount + mes_lis_pay_lin_det_amo_tax) as totalAmount")
        // )
        //     ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')

        //     ->where(['mes_lis_pay_lin_det_pay_code' => '3003', 'dpp.data_payment_id' => $data_payment_id])->groupBy('data_payment_pay_details.data_payment_pay_id')->first();

        $paymentdetailRghtTable = data_payment_pay_detail::select(
            // DB::raw('SUM(data_payment_pay_details.mes_lis_pay_lin_det_amo_requested_amount) as mes_lis_pay_lin_det_amo_requested_amount_sum'),
            DB::raw('SUM(CASE WHEN data_payment_pay_details.mes_lis_pay_lin_det_amo_pay_plus_minus = "+" or data_payment_pay_details.mes_lis_pay_lin_det_amo_pay_plus_minus is NULL then data_payment_pay_details.mes_lis_pay_lin_det_amo_payable_amount
             WHEN data_payment_pay_details.mes_lis_pay_lin_det_amo_pay_plus_minus = "-" then - data_payment_pay_details.mes_lis_pay_lin_det_amo_payable_amount
        END) as mes_lis_pay_lin_det_amo_payable_amount_sum'),
            'data_payment_pay_details.mes_lis_pay_lin_det_det_meaning',
            'data_payment_pay_details.mes_lis_pay_lin_det_det_code',
            'dpp.mes_lis_pay_pay_code'
        )
            ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')
            ->where(
                ['data_payment_pay_details.mes_lis_pay_lin_det_pay_code' => '2000',
                'dpp.data_payment_id' => $data_payment_id,
                'dpp.mes_lis_pay_pay_code'  => $pay_code,
                'dpp.mes_lis_pay_per_end_date'   => $end_date,
                'data_payment_pay_details.mes_lis_pay_lin_det_pay_out_date' => $out_date
                ]
            )
                ->groupBy('data_payment_pay_details.mes_lis_pay_lin_det_det_code')->get();

        $pQ1 = data_payment_pay_detail::select(
            DB::raw('"仕入合計金額" as p_title'),
            DB::raw('SUM(mes_lis_pay_lin_det_amo_requested_amount) as amount'),
            DB::raw('"1" as sumation_type')
        )
            ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')
            ->where(
                ['data_payment_pay_details.mes_lis_pay_lin_det_pay_code' => '3001',
                'dpp.data_payment_id' => $data_payment_id,
                'dpp.mes_lis_pay_pay_code'  => $pay_code,
                'dpp.mes_lis_pay_per_end_date'   => $end_date,
                'data_payment_pay_details.mes_lis_pay_lin_det_pay_out_date' => $out_date
                ]
            )
            ->groupBy('data_payment_pay_details.data_payment_pay_id');
        $pQ2 = data_payment_pay_detail::select(
            DB::raw('"仕入消費税" as p_title'),
            DB::raw('SUM(mes_lis_pay_lin_det_amo_tax) as amount'),
            DB::raw('"1" as sumation_type')
        )
            ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')

            ->where(
                ['data_payment_pay_details.mes_lis_pay_lin_det_pay_code' => '3001',
                'dpp.data_payment_id' => $data_payment_id,
                'dpp.mes_lis_pay_pay_code'  => $pay_code,
                'dpp.mes_lis_pay_per_end_date'   => $end_date,
                'data_payment_pay_details.mes_lis_pay_lin_det_pay_out_date' => $out_date
                ]
            )
            ->groupBy('data_payment_pay_details.data_payment_pay_id');

        $pQ3 = data_payment_pay_detail::select(
            DB::raw('"相殺合計金額" as p_title'),
            DB::raw('SUM(mes_lis_pay_lin_det_amo_payable_amount) as amount'),
            DB::raw('"2" as sumation_type')
        )
            ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')
            ->where(
                ['data_payment_pay_details.mes_lis_pay_lin_det_pay_code' => '3002',
                'dpp.data_payment_id' => $data_payment_id,
                'dpp.mes_lis_pay_pay_code'  => $pay_code,
                'dpp.mes_lis_pay_per_end_date'   => $end_date,
                'data_payment_pay_details.mes_lis_pay_lin_det_pay_out_date' => $out_date
                ]
            )
            ->groupBy('data_payment_pay_details.data_payment_pay_id');
        $pQ4 = data_payment_pay_detail::select(
            DB::raw('"相殺消費税" as p_title'),
            DB::raw('SUM(mes_lis_pay_lin_det_amo_tax) as amount'),
            DB::raw('"2" as sumation_type')
        )
            ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')

            ->where(
                ['data_payment_pay_details.mes_lis_pay_lin_det_pay_code' => '3002',
                'dpp.data_payment_id' => $data_payment_id,
                'dpp.mes_lis_pay_pay_code'  => $pay_code,
                'dpp.mes_lis_pay_per_end_date'   => $end_date,
                'data_payment_pay_details.mes_lis_pay_lin_det_pay_out_date' => $out_date
                ]
            )->groupBy('data_payment_pay_details.data_payment_pay_id');
        $pdtableleft = $pQ1->union($pQ2)->union($pQ3)->union($pQ4)->orderBy('sumation_type', 'ASC')->get();

        data_payment_pay::where(
            [
            'data_payment_pays.data_payment_id' => $data_payment_id,
            'data_payment_pays.mes_lis_pay_pay_code'  => $pay_code,
            'data_payment_pays.mes_lis_pay_per_end_date'   => $end_date
            ]
        )->whereNull('check_datetime')->update(['check_datetime'=>$today]);
        return response()->json(['payment_item_header' => $result, 'pdtableleft' => $pdtableleft, 'paymentdetailRghtTable' => $paymentdetailRghtTable]);
        // return response()->json(['payment_item_header' => $result, 'paymentdetailTopTable' => $paymentdetailTopTable, 'pdtableleft' => $pdtableleft, 'paymentdetailRghtTable' => $paymentdetailRghtTable]);
    }

    public function get_payment_item_detail_list(Request $request)
    {
        // return $request->all();
        $payment_id = $request->payment_id;
        $buyer_info = Auth::User()->ByrInfo;
        $byr_buyer_id =$buyer_info->byr_buyer_id;
        $per_page = $request->select_field_per_page_num;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $from_date = $from_date!=null? date('Y-m-d 00:00:00', strtotime($from_date)):$from_date;
        $to_date = $to_date!=null? date('Y-m-d 23:59:59', strtotime($to_date)):$to_date;
        $category_code = $request->category_code;

        $category_code = $category_code['category_code'];

        $mes_lis_pay_lin_tra_code = $request->mes_lis_pay_lin_tra_code;
        $mes_lis_pay_lin_sel_code = $request->mes_lis_pay_lin_sel_code;

        $mes_lis_pay_lin_lin_trade_number_reference = $request->mes_lis_pay_lin_lin_trade_number_reference;
        $mes_lis_inv_lin_det_pay_code = $request->mes_lis_inv_lin_det_pay_code;
        $mes_lis_pay_lin_det_verification_result_code = $request->mes_lis_pay_lin_det_verification_result_code;
        $mes_lis_pay_lin_det_trade_type_code = $request->mes_lis_pay_lin_det_trade_type_code;
        $mes_lis_pay_lin_det_balance_carried_code = $request->mes_lis_pay_lin_det_balance_carried_code;
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;
        $pay_code_list=$request->pay_code_list;

        $pay_code = $request->pay_code;
        $end_date = $request->end_date;
        $out_date = $request->out_date;
        $whereClause = [
            'dpp.mes_lis_pay_pay_code'  => $pay_code,
            'dpp.mes_lis_pay_per_end_date'   => $end_date,
            'dppd.mes_lis_pay_lin_det_pay_out_date' => $out_date
        ];
        $result = data_payment::select(
            'data_payments.data_payment_id',
            'data_payments.receive_datetime',
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
            ->where('dpp.data_payment_id', $payment_id)
            ->where('dppd.mes_lis_pay_lin_det_pay_code', '3003')
            ->where($whereClause)
            // ->where('data_payments.cmn_connect_id','=',$cmn_connect_id)
                // ->groupBy('data_payments.receive_datetime')
                // ->groupBy('dpp.mes_lis_pay_pay_code')
                // ->groupBy('dpp.mes_lis_pay_per_end_date')
                // ->groupBy('dppd.mes_lis_pay_lin_det_pay_out_date')
            ->first();

        $result1 = data_payment_pay_detail::select(
            'data_payment_pay_details.data_payment_pay_detail_id',
            'data_payment_pay_details.mes_lis_pay_lin_det_transfer_of_ownership_date',
            'data_payment_pay_details.mes_lis_pay_lin_det_goo_major_category',
            'data_payment_pay_details.mes_lis_pay_lin_tra_code',
            'data_payment_pay_details.mes_lis_pay_lin_lin_trade_number_reference',
            'data_payment_pay_details.mes_lis_pay_lin_det_pay_code',
            'data_payment_pay_details.mes_lis_pay_lin_det_trade_type_code',
            'data_payment_pay_details.mes_lis_pay_lin_det_balance_carried_code',
            'data_payment_pay_details.mes_lis_pay_lin_det_amo_requested_amount',
            'data_payment_pay_details.mes_lis_pay_lin_det_amo_payable_amount',
            'data_payment_pay_details.mes_lis_pay_lin_det_verification_result_code'
        )
            ->join('data_payment_pays as dpp', 'data_payment_pay_details.data_payment_pay_id', '=', 'dpp.data_payment_pay_id')
            ->where(['dpp.data_payment_id' => $payment_id])
            ->where([
                'dpp.mes_lis_pay_pay_code'  => $pay_code,
                'dpp.mes_lis_pay_per_end_date'   => $end_date,
                'data_payment_pay_details.mes_lis_pay_lin_det_pay_out_date' => $out_date
            ])
            ->whereIn('data_payment_pay_details.mes_lis_pay_lin_det_pay_code', $pay_code_list);
        if ($from_date && $to_date) {
            $result1=$result1->whereBetween('data_payment_pay_details.mes_lis_pay_lin_det_transfer_of_ownership_date', [$from_date, $to_date]);
        }
        if ($mes_lis_pay_lin_tra_code != null) {
            $result1 = $result1->where('data_payment_pay_details.mes_lis_pay_lin_tra_code', $mes_lis_pay_lin_tra_code);
        }
        if ($mes_lis_pay_lin_sel_code != null) {
            $result1 = $result1->where('data_payment_pay_details.mes_lis_pay_lin_sel_code', $mes_lis_pay_lin_sel_code);
        }
        if ($mes_lis_pay_lin_lin_trade_number_reference != null) {
            $result1 = $result1->where('data_payment_pay_details.mes_lis_pay_lin_lin_trade_number_reference', $mes_lis_pay_lin_lin_trade_number_reference);
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
        // $data_payment_id=$request->data_payment_id?$request->data_payment_id:1;
        $downloadType = $request->downloadType;
        $new_file_name ='';
        $csv_data_count = 0;
        if ($downloadType == 1) {
            // CSV Download
            $new_file_name = $this->all_used_fun->downloadFileName($request, 'csv', '支払');
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
                config('const.CSV_FILE_ENCODE')
            );
        }

        return response()->json(['message' => 'Success', 'status' => 1, 'new_file_name' => $new_file_name, 'url' => $download_file_url, 'csv_data_count' => $csv_data_count]);
    }

    public function get_payment_customer_code_list(Request $request)
    {
        // return $request->all();
        // $adm_user_id=$request->adm_user_id;
        $buyer_info = Auth::User()->ByrInfo;
        $byr_buyer_id =$buyer_info->byr_buyer_id;
        //$slr_seller_id = Auth::User()->SlrInfo->slr_seller_id;
        // $cmn_connect_id = $this->all_used_fun->getCmnConnectId($adm_user_id, $byr_buyer_id);
        $result = DB::select("SELECT
        dpp.mes_lis_buy_code,
        dpp.mes_lis_buy_name,
        dpp.mes_lis_pay_pay_code,
        dpp.mes_lis_pay_pay_name,
        dppd.mes_lis_pay_lin_sel_code,
        dppd.mes_lis_pay_lin_sel_name
        FROM
       data_payments AS dp
       INNER JOIN data_payment_pays AS dpp ON dp.data_payment_id=dpp.data_payment_id
       LEFT JOIN data_payment_pay_details AS dppd ON dpp.data_payment_pay_id=dppd.data_payment_pay_id
       INNER JOIN cmn_connects AS cc ON dp.cmn_connect_id=cc.cmn_connect_id
       WHERE cc.byr_buyer_id=$byr_buyer_id
       GROUP BY dppd.mes_lis_pay_lin_sel_code, dpp.mes_lis_pay_pay_code");
        return response()->json(['order_customer_code_lists' => $result]);
        // WHERE dp.cmn_connect_id='".$cmn_connect_id."'
    }

    public function get_payment_trade_code_list(Request $request)
    {
        $cmn_connect_id = $this->all_used_fun->getCmnConnectId($request->adm_user_id, $request->byr_buyer_id);
        $pay_code_list=implode(",", $request->pay_code_list);
        $result = DB::select("SELECT
        dppd.mes_lis_pay_lin_tra_code,
        -- dppd.mes_lis_pay_lin_tra_name,
        (CASE WHEN dppd.mes_lis_pay_lin_tra_name=''
        THEN dppd.mes_lis_pay_lin_tra_name_sbcs
        ELSE dppd.mes_lis_pay_lin_tra_name
        END) AS mes_lis_pay_lin_tra_name
        FROM
        data_payments AS dp
        INNER JOIN data_payment_pays AS dpp ON dp.data_payment_id=dpp.data_payment_id
        LEFT JOIN data_payment_pay_details AS dppd ON dpp.data_payment_pay_id=dppd.data_payment_pay_id
        WHERE dp.cmn_connect_id='".$cmn_connect_id."' and dp.data_payment_id = '".$request->payment_id."'
        AND dppd.mes_lis_pay_lin_det_pay_code IN ($pay_code_list)
        GROUP BY dppd.mes_lis_pay_lin_tra_code");
        return response()->json(['order_customer_code_lists' => $result]);
    }
    public function unpaidPaymentPist(Request $request)
    {
        $result = DataController::getUnpaidData($request)
        ->get();
        return response()->json(['unpaid_list' => $result]);
    }
    public function paymentUnpaidDataDownload(Request $request)
    {
        $new_file_name = $this->all_used_fun->downloadFileName($request, 'csv', '支払');
        $download_file_url = Config::get('app.url') . "storage/app" . config('const.PAYMENT_UNPAID_CSV_PATH') . "/" . $new_file_name;
        // get unpaid data query
        $unpaid_query = DataController::getUnpaidData($request);
        $csv_data_count = $unpaid_query->count();
        $unpaid_data = $unpaid_query->get()->toArray();
        // CSV create
        Csv::create(
            config('const.PAYMENT_UNPAID_CSV_PATH') . "/" . $new_file_name,
            $unpaid_data,
            DataController::paymentUnpaidCsvHeading(),
            config('const.CSV_FILE_ENCODE')
        );

        return response()->json(['message' => 'Success', 'status' => 1, 'new_file_name' => $new_file_name, 'url' => $download_file_url, 'csv_data_count' => $csv_data_count]);
    }
}
