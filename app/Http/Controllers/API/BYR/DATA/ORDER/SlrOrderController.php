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
use App\Http\Controllers\API\BYR\DATA\ORDER\DataController;
use App\Http\Controllers\API\BYR\DATA\DFLT\DefaultFunctions;
use App\Traits\Csv;
use App\Http\Controllers\API\CMN\CmnScenarioController;
// use App\Http\Controllers\API\AllUsedFunction;

class SlrOrderController extends Controller
{
    private $default_functions;
    // private $all_used_fun;
    public function __construct()
    {
        $this->default_functions = new DefaultFunctions();
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

    public function slrShipmentDownload(Request $request)
    {
        Log::debug(__METHOD__.':start---');
        // return $request->all();
        // return $request->all();
        //ownloadType=2 for Fixed length
        $data_order_id=$request->data_order_id?$request->data_order_id:1;
        // \Log::info("Download ".$data_order_id);
        $downloadType=$request->downloadType;
        $csv_data_count =0;
        if ($downloadType==1) {
            // CSV Download
            $new_file_name = $this->default_functions->downloadFileName($request, 'csv', '受注');
            $download_file_url = Config::get('app.url')."storage/app".config('const.SLR_SHIPMENT_CSV_PATH')."/". $new_file_name;

            // get shipment data query
            $shipment_query = DataController::get_shipment_data($request);
            $csv_data_count = $shipment_query->count();
            $shipment_data = $shipment_query->get()->toArray();
            // \Log::debug($shipment_data);

            // CSV create
            Csv::create(
                config('const.SLR_SHIPMENT_CSV_PATH')."/". $new_file_name,
                $shipment_data,
                DataController::shipmentCsvHeading(),
                config('const.CSV_FILE_ENCODE')
            );
        } elseif ($downloadType==2) {
            // JCA Download
            // $request = new \Illuminate\Http\Request();
            // $request->setMethod('POST');
            // $request=$this->request;
            $request->request->add(['scenario_id' => 17]);
            $request->request->add(['data_order_id' => $data_order_id]);
            $request->request->add(['email' => 'user@jacos.co.jp']);
            $request->request->add(['password' => 'Qe75ymSr']);
            $new_file_name =$this->default_functions->downloadFileName($request, 'txt', '受注');
            $download_file_url = Config::get('app.url')."storage/".config('const.SLR_FIXED_LENGTH_FILE_PATH')."/". $new_file_name;
            $request->request->add(['file_name' => $new_file_name]);
            // $request->request->remove('downloadType');
            // return $request->all();
            $cs = new CmnScenarioController();
            $ret = $cs->exec($request);
            //  return collect($ret)->toJson();
            // \Log::debug($ret->getContent());
            // return $ret = json_decode($ret->getContent(), true);
            // if (1 === $ret['status']) {
            //     // sceanario exec error
            //     \Log::error($ret['message']);
            //     return $ret;
            // }
            // return response()->json($ret);
        }
        Log::debug(__METHOD__.':end---');

        return response()->json(['message' => 'Success','status'=>1,'new_file_name'=>$new_file_name, 'url' => $download_file_url,'csv_data_count'=>$csv_data_count]);
    }
}
