<?php

namespace App\Http\Controllers\API\DATA\INVOICE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\Cmn_ScenarioController;
use App\Models\ADM\User;
use App\Models\BYR\byr_order_detail;
use App\Models\DATA\INVOICE\data_invoice;
use App\Models\DATA\INVOICE\data_invoice_pay;
use App\Models\DATA\INVOICE\data_invoice_pay_detail;
use App\Http\Controllers\API\AllUsedFunction;
use App\Http\Controllers\API\DATA\INVOICE\InvoiceDataController;
use App\Exports\InvoiceCSVExport;
use App\Traits\Csv;
use DB;

class InvoiceController extends Controller
{
    private $request;
    private $all_used_fun;
    public function __construct()
    {
        $this->request = new \Illuminate\Http\Request();
        $this->request->setMethod('POST');
        $this->all_used_fun = new AllUsedFunction();
    }
    public function invoiceScheduler($start_date,$end_date){
        // $request = new \Illuminate\Http\Request();
        // $request->setMethod('POST');
        $request=$this->request;
        $request->request->add(['scenario_id' => 15]);
        $request->request->add(['data_order_id' => 1]);
        $request->request->add(['email' => 'user@jacos.co.jp']);
        $request->request->add(['password' => 'Qe75ymSr']);
        $request->request->add(['start_date' => $start_date]);
        $request->request->add(['end_date' => $end_date]);
        // return $request->all();
        // \Log::info($request->all());
        $cs = new Cmn_ScenarioController();
        return $ret = $cs->exec($request);
        \Log::debug($ret->getContent());
        $ret = json_decode($ret->getContent(), true);
        if (1 === $ret['status']) {
            // sceanario exec error
            \Log::error($ret['message']);
            return $ret;
        }
        return response()->json($ret);
    }

    public function get_all_invoice_list(Request $request)
    {
        // return $request->all();
        $adm_user_id=$request->adm_user_id;
        $per_page = $request->select_field_per_page_num == null ? 10 : $request->select_field_per_page_num;
        $mes_lis_inv_pay_code=$request->mes_lis_inv_pay_code;
        $mes_lis_inv_per_begin_date=$request->mes_lis_inv_per_begin_date;
        $mes_lis_inv_per_end_date=$request->mes_lis_inv_per_end_date;
        $send_datetime_status=$request->send_datetime_status;

        $mes_lis_inv_per_begin_date = $mes_lis_inv_per_begin_date!=null? date('Y-m-d 00:00:00',strtotime($mes_lis_inv_per_begin_date)):$mes_lis_inv_per_begin_date; // 受信日時開始
        $mes_lis_inv_per_end_date = $mes_lis_inv_per_end_date!=null? date('Y-m-d 23:59:59',strtotime($mes_lis_inv_per_end_date)):$mes_lis_inv_per_end_date; // 受信日時終了

        $authUser = User::find($adm_user_id);
        $cmn_company_id = 0;
        if (!$authUser->hasRole(config('const.adm_role_name'))) {
            $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            // $byr_buyer_id = $cmn_company_info['byr_buyer_id'];
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }
        $result=data_invoice::select('data_invoices.data_invoice_id','dip.mes_lis_inv_per_end_date',
        'dip.mes_lis_inv_pay_code','dip.mes_lis_inv_pay_name','dip.mes_lis_buy_code','dip.mes_lis_buy_name',
        'dip.status','dipd.mes_lis_inv_lin_det_amo_requested_amount'
        )
        ->join('data_invoice_pays as dip','data_invoices.data_invoice_id','=','dip.data_invoice_id')
        ->join('data_invoice_pay_details as dipd','dip.data_invoice_pay_id','=','dipd.data_invoice_pay_id')
        ->where('data_invoices.cmn_connect_id','=',$cmn_connect_id);
        if ($mes_lis_inv_pay_code!=null) {
            $result=$result->where('dip.mes_lis_inv_pay_code','=',$mes_lis_inv_pay_code);
        }
        if ($mes_lis_inv_per_begin_date && $mes_lis_inv_per_end_date) {
            $result=$result->whereBetween('dip.mes_lis_inv_per_end_date', [$mes_lis_inv_per_begin_date, $mes_lis_inv_per_end_date]);
        }
        // will confirm
        if ($send_datetime_status=='未請求'){
            $result=$result->where('dipd.send_datetime','=',null);
        }else if ($send_datetime_status=='請求済'){
            $result=$result->where('dipd.send_datetime','!=',null);
        }else if ($send_datetime_status=='再請求あり'){
            $result=$result->where('dipd.send_datetime','!=',null);
        }
        // will confirm
        $result=$result->groupBy('dip.mes_lis_inv_per_end_date')
        ->paginate($per_page);
        $byr_buyer = $this->all_used_fun->get_company_list($cmn_company_id);

        return response()->json(['invoice_list' => $result, 'byr_buyer_list' => $byr_buyer]);
    }
    public function invoiceInsert(Request $request){

        $invoice_id = data_invoice::insertGetId([
            'sta_sen_identifier'=>'',
            'sta_sen_ide_authority'=>'',
            'sta_rec_identifier'=>'',
            'sta_rec_ide_authority'=>'',
            'sta_doc_standard'=>'',
            'sta_doc_type_version'=>'',
            'sta_doc_instance_identifier'=>'',
            'sta_doc_type'=>'',
            'sta_doc_creation_date_and_time'=>'',
            'sta_bus_scope_instance_identifier'=>'',
            'sta_bus_scope_type'=>'',
            'sta_bus_scope_identifier'=>'',
            'mes_ent_unique_creator_identification'=>'',
            'mes_mes_sender_station_address'=>'',
            'mes_mes_ultimate_receiver_station_address'=>'',
            'mes_mes_immediate_receiver_station_addres'=>'',
            'mes_mes_number_of_trading_documents'=>'',
            'mes_mes_sys_key'=>'',
            'mes_mes_sys_value'=>'',
            'mes_lis_con_version'=>'',
            'mes_lis_doc_version'=>'',
            'mes_lis_ext_namespace'=>'',
            'mes_lis_ext_version'=>'',
            'mes_lis_pay_code'=>'',
            'mes_lis_pay_gln'=>'',
            'mes_lis_pay_name'=>'',
            'mes_lis_pay_name_sbcs'=>'',
        ]);
        $request['data_invoice_id'] = $invoice_id;
        data_invoice_pay::insert($request->all());


        return response()->json(['success' => 1]);
    }
    public function invoiceDetailsList(Request $request)
    {
        // return $request->all();
        $data_invoice_id=$request->data_invoice_id;
        $per_page = $request->select_field_per_page_num == null ? 10 : $request->select_field_per_page_num;

        $ownership_date=$request->mes_lis_inv_lin_det_transfer_of_ownership_date;
        $number_reference=$request->mes_lis_inv_lin_lin_trade_number_reference;
        $decision_datetime_status=$request->decision_datetime_status;
        $send_datetime_status=$request->send_datetime_status;


        $result=data_invoice::select('data_invoices.data_invoice_id','dipd.data_invoice_pay_detail_id','dip.mes_lis_inv_per_end_date',
        'dipd.mes_lis_inv_lin_det_transfer_of_ownership_date','dipd.mes_lis_inv_lin_tra_code',
        'dipd.mes_lis_inv_lin_tra_name','dipd.mes_lis_inv_lin_lin_trade_number_reference',
        'dipd.mes_lis_inv_lin_det_amo_requested_amount','dipd.mes_lis_inv_lin_det_pay_code',
        'dipd.mes_lis_inv_lin_det_balance_carried_code','dipd.send_datetime','dipd.decision_datetime'
        )
        ->join('data_invoice_pays as dip','data_invoices.data_invoice_id','=','dip.data_invoice_id')
        ->join('data_invoice_pay_details as dipd','dip.data_invoice_pay_id','=','dipd.data_invoice_pay_id')
        ->where('data_invoices.data_invoice_id','=',$data_invoice_id);
        if ($decision_datetime_status=='未確定あり'){
            $result=$result->where('dipd.decision_datetime','=',null);
        }else if ($decision_datetime_status=='確定済'){
            $result=$result->where('dipd.decision_datetime','!=',null);
        }
        if ($send_datetime_status=='未確定あり'){
            $result=$result->where('dipd.send_datetime','=',null);
        }else if ($send_datetime_status=='確定済'){
            $result=$result->where('dipd.send_datetime','!=',null);
        }

        if($ownership_date!=null){
            $result=$result->where('dipd.mes_lis_inv_lin_det_transfer_of_ownership_date','=',$ownership_date);
        }
        if($number_reference!=null){
            $result=$result->where('dipd.mes_lis_inv_lin_lin_trade_number_reference','=',$number_reference);
        }
        $result=$result->paginate($per_page);

        return response()->json(['invoice_details_list' => $result]);
    }

    public function sendInvoiceData(Request $request){
        $data_count=$request->data_count;
        $data_invoice_id=$request->data_invoice_id;
        $download_file_url='';
        $csv_data_count = InvoiceDataController::get_invoice_data($request)->get()->count();
        if (!$data_count) {
            $dateTime = date('Y-m-d H:i:s');
            $new_file_name = self::invoiceFileName($data_invoice_id,'csv');
            data_invoice::where('data_invoice_id',$data_invoice_id)->update(['mes_mes_number_of_trading_documents'=>$csv_data_count]);
            $download_file_url = \Config::get('app.url')."storage/app".config('const.INVOICE_CSV_PATH')."/". $new_file_name;
            (new InvoiceCSVExport($request))->store(config('const.INVOICE_CSV_PATH').'/'.$new_file_name);
            data_invoice_pay_detail::where('decision_datetime','!=',null)
            ->where('send_datetime','=',null)
            ->update(['send_datetime'=>$dateTime]);
        }

        return response()->json(['message' => 'Success','status'=>1, 'url' => $download_file_url,'csv_data_count'=>$csv_data_count]);
    }
    public function downloadInvoice(Request $request){
        // downloadType=1 for Csv
        // downloadType=2 for Fixed length
        $data_invoice_id=$request->data_invoice_id;
        $downloadType=$request->downloadType;
        $csv_data_count =0;
        if ($downloadType==1) {
            // CSV Download
            $new_file_name = $new_file_name = self::invoiceFileName($data_invoice_id, 'csv');
            $download_file_url = \Config::get('app.url')."storage/app".config('const.INVOICE_CSV_PATH')."/". $new_file_name;

            // get shipment data query
            $invoice_query = InvoiceDataController::get_invoice_data($request);
            $csv_data_count = $invoice_query->count();
            $shipment_data = $invoice_query->get()->toArray();

            // CSV create
            Csv::create(
                config('const.INVOICE_CSV_PATH')."/". $new_file_name,
                $shipment_data,
                InvoiceDataController::invoiceCsvHeading(),
                'shift-jis'
            );
        } elseif ($downloadType==2) {
            // $request->request->add(['scenario_id' => 6]);
            // $request->request->add(['data_order_id' => 1]);
            // $request->request->add(['email' => 'user@jacos.co.jp']);
            // $request->request->add(['password' => 'Qe75ymSr']);
            // $new_file_name = self::invoiceFileName($data_order_id, 'txt');
            // $download_file_url = \Config::get('app.url')."storage/".config('const.FIXED_LENGTH_FILE_PATH')."/". $new_file_name;
            // $request->request->add(['file_name' => $new_file_name]);
            // $cs = new Cmn_ScenarioController();
            // $ret = $cs->exec($request);
        }

        return response()->json(['message' => 'Success','status'=>1,'new_file_name'=>$new_file_name, 'url' => $download_file_url,'csv_data_count'=>$csv_data_count]);
    }
    public function get_all_invoice_by_voucher_number($voucher_number)
    {

        $result = byr_order_detail::select('byr_order_details.*', 'byr_shipment_details.*')
            ->join('byr_shipment_details', 'byr_shipment_details.byr_order_detail_id', '=', 'byr_order_details.byr_order_detail_id')
            ->where('voucher_number', $voucher_number)->get();
        $shop_list = array();
        $voucher_list = array();
        $byr_buyer = array();
        return response()->json(['invoice_list' => $result, 'byr_buyer_list' => $byr_buyer, 'shop_list' => $shop_list, 'voucher_list' => $voucher_list]);
    }
    public function decessionData(Request $request)
    {
        $dateTime = date('Y-m-d H:i:s');
       $date_null = $request->date_null;
        if ($date_null) {
            $dateTime = null;
        }else{
            $dateTime = date('Y-m-d H:i:s');
        }
        // return $dateTime;
        $data_invoice_pay_detail_ids = $request->update_id;
        if ($data_invoice_pay_detail_ids) {
            foreach ($data_invoice_pay_detail_ids as $id) {
                data_invoice_pay_detail::where('data_invoice_pay_detail_id', $id)->update(['decision_datetime' => $dateTime]);
            }
        }
        return response()->json(['success' => '1','status'=>1]);
    }
    private static function invoiceFileName($data_invoice_id, $file_type="csv")
    {
        $file_name_info=data_invoice::select('cmn_connects.partner_code', 'byr_buyers.super_code', 'cmn_companies.jcode')
            ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'data_invoices.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
            ->join('slr_sellers', 'slr_sellers.slr_seller_id', '=', 'cmn_connects.slr_seller_id')
            ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'slr_sellers.cmn_company_id')
            ->where('data_invoices.data_invoice_id', $data_invoice_id)
            ->first();
        $file_name = $file_name_info->super_code.'-'."invoice_".$file_name_info->super_code.'-'.$file_name_info->partner_code."-".$file_name_info->jcode.'_invoice_'.date('YmdHis').'.'.$file_type;
        return $file_name;
    }
}
