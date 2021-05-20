<?php

namespace App\Http\Controllers\API\DATA\INVOICE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\CMN\CmnScenarioController;
use App\Models\ADM\User;
use App\Models\BYR\byr_order_detail;
use App\Models\DATA\INVOICE\data_invoice;
use App\Models\DATA\INVOICE\data_invoice_pay;
use App\Models\DATA\INVOICE\data_invoice_pay_detail;
use App\Models\BYR\byr_buyer;
use App\Http\Controllers\API\AllUsedFunction;
use App\Http\Controllers\API\DATA\INVOICE\InvoiceDataController;
use App\Exports\InvoiceCSVExport;
use App\Traits\Csv;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
use App\Console\Commands\InvoiceCommand;
class InvoiceController extends Controller
{
    private $request;
    private $all_used_fun;
    public function __construct()
    {
        $this->request = new \Illuminate\Http\Request();
        $this->request->setMethod('POST');
        $this->all_used_fun = new AllUsedFunction();
        $this->all_used_fun->folder_create('app/'.config('const.INVOICE_CSV_PATH'));
    }
    public function invoiceScheduler($request){
        $cs = new CmnScenarioController();

        $ret = $cs->exec($request);
        Log::info("======Count=======");
        Log::info($ret);
        return $ret;
        Log::debug($ret->getContent());
        $ret = json_decode($ret->getContent(), true);
        if (1 === $ret['status']) {
            // sceanario exec error
            Log::error($ret['message']);
            return $ret;
        }
        return response()->json($ret);
    }

    public function get_all_invoice_list(Request $request)
    {
        // return $request->all();
        $adm_user_id=$request->adm_user_id;
        $byr_buyer_id=$request->byr_buyer_id;
        $per_page = $request->select_field_per_page_num == null ? 10 : $request->select_field_per_page_num;
        $mes_lis_inv_pay_code=$request->mes_lis_inv_pay_code;
        $mes_lis_inv_per_begin_date=$request->mes_lis_inv_per_begin_date;
        $mes_lis_inv_per_end_date=$request->mes_lis_inv_per_end_date;
        $send_datetime_status=$request->send_datetime_status;
        // $mes_lis_inv_pay_id=$request->mes_lis_inv_pay_id;
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;

        $mes_lis_inv_per_begin_date = $mes_lis_inv_per_begin_date!=null? date('Y-m-d 00:00:00',strtotime($mes_lis_inv_per_begin_date)):$mes_lis_inv_per_begin_date; // 受信日時開始
        $mes_lis_inv_per_end_date = $mes_lis_inv_per_end_date!=null? date('Y-m-d 23:59:59',strtotime($mes_lis_inv_per_end_date)):$mes_lis_inv_per_end_date; // 受信日時終了
        $table_name='data_invoices.';
        if ($sort_by=="data_invoice_id") {
            $table_name='data_invoices.';
        }else if($sort_by=="mes_lis_inv_lin_det_amo_requested_amount"){
            $table_name='dipd.';
        }else{
            $table_name='dip.';
        }
        $authUser = User::find($adm_user_id);
        $slr_seller_id = Auth::User()->SlrInfo->slr_seller_id;
        $cmn_company_id = 0;
        if (!$authUser->hasRole(config('const.adm_role_name'))) {
            $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id,$byr_buyer_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            // $byr_buyer_id = $cmn_company_info['byr_buyer_id'];
            // $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }
        $result=data_invoice::select('data_invoices.data_invoice_id','dip.mes_lis_inv_per_end_date',
        'dip.mes_lis_inv_pay_code','dip.mes_lis_inv_pay_name','dip.mes_lis_buy_code',
        'dip.mes_lis_inv_pay_id',
        'dip.mes_lis_buy_name',
        // 'dip.status',
        'dipd.mes_lis_inv_lin_det_amo_requested_amount',
        DB::raw('sum(dipd.mes_lis_inv_lin_det_amo_requested_amount) as total_amount'),

        DB::raw('COUNT(distinct dipd.data_invoice_pay_id) AS cnt'),
        DB::raw('COUNT( isnull( dipd.decision_datetime) OR NULL) AS decision_cnt'),
        DB::raw('COUNT( isnull( dipd.send_datetime)  OR NULL) AS send_cnt'),
        )
        ->join('data_invoice_pays as dip','data_invoices.data_invoice_id','=','dip.data_invoice_id')
        ->join('data_invoice_pay_details as dipd','dip.data_invoice_pay_id','=','dipd.data_invoice_pay_id')
        ->join('cmn_connects as cc', 'cc.cmn_connect_id', '=', 'data_invoices.cmn_connect_id')
        ->where('cc.byr_buyer_id', $byr_buyer_id)
        ->where('cc.slr_seller_id', $slr_seller_id);

        // ->where('data_invoices.cmn_connect_id','=',$cmn_connect_id);
        if ($mes_lis_inv_pay_code!=null) {
            $result=$result->where('dip.mes_lis_inv_pay_code','=',$mes_lis_inv_pay_code);
        }
        if ($mes_lis_inv_per_begin_date && $mes_lis_inv_per_end_date) {
            $result=$result->whereBetween('dip.mes_lis_inv_per_end_date',[$mes_lis_inv_per_begin_date,$mes_lis_inv_per_end_date]);
        }
        if ($send_datetime_status=='未請求'){
            $result=$result->where('dipd.send_datetime','=',null);
        }else if ($send_datetime_status=='請求済'){
            $result=$result->where('dipd.send_datetime','!=',null);
        }else if ($send_datetime_status=='再請求あり'){
            $result=$result->where('dipd.send_datetime','!=',null);
        }
        // will confirm
        // $result=$result->groupBy('dipd.mes_lis_inv_lin_lin_trade_number_reference');
        $result=$result->groupBy('dip.mes_lis_inv_per_end_date')
        ->orderBy($table_name.$sort_by,$sort_type)
        ->paginate($per_page);
        $byr_buyer = $this->all_used_fun->get_company_list($cmn_company_id);

        return response()->json(['invoice_list' => $result, 'byr_buyer_list' => $byr_buyer]);
    }

    public function invoiceInsert(Request $request){
        $adm_user_id = $request->adm_user_id;
        $byr_buyer_id = $request->byr_buyer_id;
        $authUser = User::find($adm_user_id);
        $cmn_company_id = 0;
        if (!$authUser->hasRole(config('const.adm_role_name'))) {
            $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id,$byr_buyer_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }
        $invoice_id = data_invoice::insertGetId([
            'cmn_connect_id'=>$cmn_connect_id,
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
        $data_invoice_pay_id = data_invoice_pay::insertGetId([
            'data_invoice_id'=>$invoice_id,
            'mes_lis_inv_pay_code'=>$request->mes_lis_inv_pay_code,
            // 'mes_lis_inv_pay_id'=>$request->mes_lis_inv_pay_id,
            'mes_lis_inv_per_begin_date'=>$request->mes_lis_inv_per_begin_date,
            'mes_lis_inv_per_end_date'=>$request->mes_lis_inv_per_end_date
            ]);

            data_invoice_pay_detail::insert(['data_invoice_pay_id'=>$data_invoice_pay_id]);
        return response()->json(['success' => 1]);
    }

    public function update_invoice_detail(Request $request)
    {
        $updatedArray = array(
        'mes_lis_inv_lin_det_transfer_of_ownership_date'=>$request->mes_lis_inv_lin_det_transfer_of_ownership_date,
        'mes_lis_inv_lin_det_goo_major_category'=>$request->mes_lis_inv_lin_det_goo_major_category,
        'mes_lis_inv_lin_tra_code'=>$request->mes_lis_inv_lin_tra_code,
        'mes_lis_inv_lin_lin_trade_number_reference'=>$request->mes_lis_inv_lin_lin_trade_number_reference,
        'mes_lis_inv_lin_det_pay_code'=>$request->mes_lis_inv_lin_det_pay_code,
        'mes_lis_inv_lin_det_balance_carried_code'=>$request->mes_lis_inv_lin_det_balance_carried_code,
        'mes_lis_inv_lin_det_amo_requested_amount'=>$request->mes_lis_inv_lin_det_amo_requested_amount
        );
        if($request->data_invoice_pay_detail_id!=''){
            data_invoice_pay_detail::where(['data_invoice_pay_detail_id'=>$request->data_invoice_pay_detail_id])->update($updatedArray);
            return response()->json(['success' => 1,'update_success'=>1]);
        }else{
            $data_invoice_id = data_invoice_pay::where('data_invoice_id',$request->data_invoice_id)->first();
            $updatedArray['data_invoice_pay_id']=$data_invoice_id->data_invoice_pay_id;
            data_invoice_pay_detail::insert($updatedArray);
            return response()->json(['success' => 1,'insert_success'=>1]);
        }
    }
    public function delete_invoice_detail(Request $request)
    {
        data_invoice_pay_detail::where('data_invoice_pay_detail_id',$request->data_invoice_pay_detail_id)->delete();
        return response()->json(['status' => 1,'message'=>'削除しました。']);
    }

    public function execInvoiceSchedular(Request $request)
    {
        $adm_user_id=$request->adm_user_id;
        $byr_buyer_id=$request->byr_buyer_id;
        $Invoice_command = new InvoiceCommand();
            $aaa=$Invoice_command->invoiceSchedulerCode(1,1);
            // $aaa=$Invoice_command->invoiceSchedulerCode(1, 1);
            return $aaa;
            return response()->json(['message' => "Success",'status'=>1,'class'=>'success']);
        // try {
        //     // Artisan::call('optimize', [], $this->getOutput());
        //     // Artisan::call('invoice:scheduler 1 '.$adm_user_id.' '.$byr_buyer_id);
        //     // return Artisan::call('invoice:scheduler 1 '.$adm_user_id.' '.$byr_buyer_id,[], $this->getOutput());
        // } catch (\Throwable $th) {
        //     return response()->json(['message' => $th->getMessage(),'status'=>0,'class'=>'error']);
        //     // return response()->json(['message' => "エラー",'status'=>0,'class'=>'error']);
        // }
        return response()->json(['message' => "締め処理実行",'status'=>1,'class'=>'success']);
    }

    public function invoiceDetailsList(Request $request)
    {
        // return $request->all();
        $data_invoice_id=$request->data_invoice_id;
        $per_page = $request->select_field_per_page_num == null ? 10 : $request->select_field_per_page_num;


        $number_reference=$request->mes_lis_inv_lin_lin_trade_number_reference;
        $decision_datetime_status=$request->decision_datetime_status;
        $send_datetime_status=$request->send_datetime_status;
        $mes_lis_inv_lin_tra_code=$request->mes_lis_inv_lin_tra_code;
        $category_code = $request->category_code;
        $category_code =$category_code['category_code'];
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;

        $param_data = $request->param_data;
        $adm_user_id=$request->adm_user_id;
        $byr_buyer_id=$request->byr_buyer_id;
        // $authUser = User::find($adm_user_id);
        $slr_seller_id = Auth::User()->SlrInfo->slr_seller_id;

        // $cmn_connect_id = '';
        // if (!$authUser->hasRole(config('const.adm_role_name'))) {
        //     $cmn_company_info=$this->all_used_fun->get_user_info($adm_user_id,$byr_buyer_id);
        //     $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        // }

        $result=data_invoice::select('data_invoices.data_invoice_id','dipd.data_invoice_pay_detail_id','dip.mes_lis_inv_per_end_date',
        'dipd.data_shipment_voucher_id','dipd.mes_lis_inv_lin_det_transfer_of_ownership_date','dipd.mes_lis_inv_lin_tra_code',
        'dipd.mes_lis_inv_lin_tra_name','dipd.mes_lis_inv_lin_lin_trade_number_reference',
        'dipd.mes_lis_inv_lin_det_amo_requested_amount','dipd.mes_lis_inv_lin_det_pay_code',
        'dipd.mes_lis_inv_lin_det_balance_carried_code','dipd.send_datetime','dipd.decision_datetime','dipd.mes_lis_inv_lin_det_goo_major_category'
        )
        ->join('data_invoice_pays as dip','data_invoices.data_invoice_id','=','dip.data_invoice_id')
        ->join('data_invoice_pay_details as dipd','dip.data_invoice_pay_id','=','dipd.data_invoice_pay_id')
        ->join('cmn_connects as cc', 'cc.cmn_connect_id', '=', 'data_invoices.cmn_connect_id')
        ->where('cc.byr_buyer_id', $byr_buyer_id)
        ->where('cc.slr_seller_id', $slr_seller_id)
        ->where('data_invoices.data_invoice_id','=',$data_invoice_id);
        // ->where('data_invoices.cmn_connect_id','=',$cmn_connect_id);
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

        if($from_date!=''){
            $result=$result->where('dipd.mes_lis_inv_lin_det_transfer_of_ownership_date','>=',$from_date);
        }

        if($to_date!=''){
            $result=$result->where('dipd.mes_lis_inv_lin_det_transfer_of_ownership_date','<=',$to_date);
        }

        if($number_reference!=null){
            $result=$result->where('dipd.mes_lis_inv_lin_lin_trade_number_reference','=',$number_reference);
        }

        if($category_code!='*'){
            $result=$result->where('dipd.mes_lis_inv_lin_det_goo_major_category','=',$category_code);
        }

        if($mes_lis_inv_lin_tra_code!=''){
            $result=$result->where('dipd.mes_lis_inv_lin_tra_code','=',$mes_lis_inv_lin_tra_code);
        }
        $result=$result->where('dip.mes_lis_inv_per_end_date',$param_data['end_date'])
            ->where('dip.mes_lis_inv_pay_code',$param_data['pay_code']);
            // ->where('dip.mes_lis_inv_pay_name',$param_data['pay_name'])
            // ->where('dip.mes_lis_buy_code',$param_data['buy_code'])
            // ->where('dip.mes_lis_buy_name',$param_data['buy_name'])
            // ->where('dip.status',$param_data['status']);
        $result = $result->orderBy('dipd.'.$sort_by,$sort_type);
        $result=$result->paginate($per_page);
        return response()->json(['invoice_details_list' => $result]);
    }

    public function sendInvoiceData(Request $request){
        // return $request->all();
        $data_count=$request->data_count;
        $data_invoice_id=$request->data_invoice_id;
        $param_data=$request->param_data;
        $download_file_url='';
        $adm_user_id=$request->adm_user_id;
        $byr_buyer_id=$request->byr_buyer_id;
        $slr_seller_id = Auth::User()->SlrInfo->slr_seller_id;
        // $authUser = User::find($adm_user_id);

        // $cmn_connect_id = '';
        // if (!$authUser->hasRole(config('const.adm_role_name'))) {
        //     $cmn_company_info=$this->all_used_fun->get_user_info($adm_user_id,$byr_buyer_id);
        //     $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        // }
        // $csv_data_count = InvoiceDataController::get_invoice_data($request)->get()->count();
        $csv_data_count = data_invoice::join('data_invoice_pays as dip','dip.data_invoice_id','=','data_invoices.data_invoice_id')
            ->join('data_invoice_pay_details as dipd','dipd.data_invoice_pay_id','=','dip.data_invoice_pay_id')
            ->join('cmn_connects as cc', 'cc.cmn_connect_id', '=', 'data_invoices.cmn_connect_id')
            ->where('cc.byr_buyer_id', $byr_buyer_id)
            ->where('cc.slr_seller_id', $slr_seller_id)
            // ->where('data_invoices.cmn_connect_id',$cmn_connect_id)
            ->where('data_invoices.data_invoice_id',$data_invoice_id)
            ->whereNotNull('dipd.decision_datetime')
            ->whereNull('dipd.send_datetime')
            ->where('dip.mes_lis_inv_per_end_date',$param_data['end_date'])
            ->where('dip.mes_lis_inv_pay_code',$param_data['pay_code'])
            // ->where('dip.mes_lis_inv_pay_name',$param_data['pay_name'])
            // ->where('dip.mes_lis_buy_code',$param_data['buy_code'])
            // ->where('dip.mes_lis_buy_name',$param_data['buy_name'])
            // ->where('dip.status',$param_data['status'])
            ->get()->count();
        if (!$data_count) {
            $dateTime = date('Y-m-d H:i:s');
            $new_file_name = $this->all_used_fun->downloadFileName($request, 'csv','請求');
            // self::invoiceFileName($data_invoice_id,'csv');
            data_invoice::where('data_invoice_id',$data_invoice_id)->update(['mes_mes_number_of_trading_documents'=>$csv_data_count]);
            $download_file_url = Config::get('app.url')."storage/app".config('const.INVOICE_CSV_PATH')."/". $new_file_name;
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
        // return $request->all();
        $data_invoice_id=$request->data_invoice_id?$request->data_invoice_id:1;
        $downloadType=$request->downloadType;
        $csv_data_count =0;
        if ($downloadType==1) {
            // CSV Download
            $new_file_name = $this->all_used_fun->downloadFileName($request, 'csv','請求');
            $download_file_url = Config::get('app.url')."storage/app".config('const.INVOICE_CSV_PATH')."/". $new_file_name;

            // get shipment data query
            $invoice_query = InvoiceDataController::get_invoice_data($request);
            $csv_data_count = $invoice_query->count();
            $shipment_data = $invoice_query->get()->toArray();

            // CSV create
            Csv::create(
                config('const.INVOICE_CSV_PATH')."/". $new_file_name,
                $shipment_data,
                InvoiceDataController::invoiceCsvHeading(),
                config('const.CSV_FILE_ENCODE')
            );
        } elseif ($downloadType==2) {
            // $request->request->add(['scenario_id' => 6]);
            // $request->request->add(['data_order_id' => 1]);
            // $request->request->add(['email' => 'user@jacos.co.jp']);
            // $request->request->add(['password' => 'Qe75ymSr']);
            // $new_file_name = self::invoiceFileName($data_order_id, 'txt');
            // $download_file_url = \Config::get('app.url')."storage/".config('const.FIXED_LENGTH_FILE_PATH')."/". $new_file_name;
            // $request->request->add(['file_name' => $new_file_name]);
            // $cs = new CmnScenarioController();
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
                if (!$date_null) {
                    data_invoice_pay_detail::where('data_invoice_pay_detail_id', $id)->update(['decision_datetime' => $dateTime]);
                }else{
                    data_invoice_pay_detail::where('data_invoice_pay_detail_id', $id)
                ->whereNull('send_datetime')
                ->update(['decision_datetime' => $dateTime]);
                }
            }
        }
        return response()->json(['message' => 'success','status'=>1]);
    }

    public function invoiceCompareData(Request $request){
        // return $request->all();
        $adm_user_id=$request->adm_user_id;
        $byr_buyer_id=$request->byr_buyer_id;
        $shipment_ids=$request->shipment_ids;
        $shipment_ids= implode(', ', $shipment_ids);
        $cmn_connect_id =null;
        $authUser = User::find($adm_user_id);
            if (!$authUser->hasRole(config('const.adm_role_name'))) {
                $cmn_company_info=$this->all_used_fun->get_user_info($adm_user_id,$byr_buyer_id);
                $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
            }
        $result = DB::select(" SELECT
            dsv.data_shipment_voucher_id,
            drv.data_receive_voucher_id,
            dsv.mes_lis_shi_par_sel_code,
            dsv.mes_lis_shi_tra_trade_number,
            dsv.mes_lis_shi_par_shi_code,
            dsv.mes_lis_shi_par_shi_name,
            case when dsv.mes_lis_shi_tra_dat_revised_delivery_date IS NULL then
            dsv.mes_lis_shi_tra_dat_delivery_date
            else
            dsv.mes_lis_shi_tra_dat_revised_delivery_date
            END AS shipment_delivery_date,
            drv.mes_lis_acc_tra_dat_transfer_of_ownership_date,
            case when dsv.mes_lis_shi_tot_tot_net_price_total IS NULL then
            0
            else
            dsv.mes_lis_shi_tot_tot_net_price_total
            END AS mes_lis_shi_tot_tot_net_price_total,
            case when drv.mes_lis_acc_tot_tot_net_price_total IS NULL then
            0
            else
            drv.mes_lis_acc_tot_tot_net_price_total
            END AS mes_lis_acc_tot_tot_net_price_total

            FROM
            data_shipment_vouchers AS dsv
            INNER JOIN data_shipments AS ds ON ds.data_shipment_id=dsv.data_shipment_id
            INNER JOIN data_receive_vouchers AS drv ON dsv.mes_lis_shi_tra_trade_number = drv.mes_lis_acc_tra_trade_number
            INNER JOIN data_receives AS dr ON dr.data_receive_id=drv.data_receive_id
            WHERE
            dr.cmn_connect_id=$cmn_connect_id
            AND ds.cmn_connect_id = $cmn_connect_id
            AND dsv.data_shipment_voucher_id IN ($shipment_ids)
            AND (
            dsv.mes_lis_shi_tot_tot_net_price_total != drv.mes_lis_acc_tot_tot_net_price_total
            OR
            (
            case when dsv.mes_lis_shi_tra_dat_revised_delivery_date IS NULL then
            dsv.mes_lis_shi_tra_dat_delivery_date
            else
            dsv.mes_lis_shi_tra_dat_revised_delivery_date
            END
            )
            != drv.mes_lis_acc_tra_dat_transfer_of_ownership_date
            )
        ");
        return response()->json(['voucherList'=>$result]);
    }
    public function invoiceCompareDataDownload(Request $request){
        // return $request->all();
        $adm_user_id=$request->adm_user_id;
        $byr_buyer_id=$request->byr_buyer_id;
        $shipment_ids=$request->shipment_ids;
        $shipment_ids= implode(', ', $shipment_ids);
        $cmn_connect_id =null;
        $authUser = User::find($adm_user_id);
            if (!$authUser->hasRole(config('const.adm_role_name'))) {
                $cmn_company_info=$this->all_used_fun->get_user_info($adm_user_id,$byr_buyer_id);
                $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
            }
        $result = DB::select("SELECT
        dsv.mes_lis_shi_par_sel_code,
        dsv.mes_lis_shi_tra_trade_number,
        dsv.mes_lis_shi_par_shi_code,
        dsv.mes_lis_shi_par_shi_name,
        case when dsv.mes_lis_shi_tra_dat_revised_delivery_date IS NULL then
        dsv.mes_lis_shi_tra_dat_delivery_date
        else
        dsv.mes_lis_shi_tra_dat_revised_delivery_date
        END AS shipment_delivery_date,
        drv.mes_lis_acc_tra_dat_transfer_of_ownership_date,
        dsv.mes_lis_shi_tot_tot_net_price_total,
        drv.mes_lis_acc_tot_tot_net_price_total,
        dsi.mes_lis_shi_lin_lin_line_number,
        dsi.mes_lis_shi_lin_ite_order_item_code,
        dsi.mes_lis_shi_lin_ite_name,
        dsi.mes_lis_shi_lin_qua_shi_quantity,
        dri.mes_lis_acc_lin_qua_rec_quantity,
        dsi.mes_lis_shi_lin_amo_item_net_price,
        dri.mes_lis_acc_lin_amo_item_net_price

        FROM
        data_shipment_vouchers AS dsv
        INNER JOIN data_shipments AS ds ON ds.data_shipment_id=dsv.data_shipment_id
        INNER JOIN data_receive_vouchers AS drv ON dsv.mes_lis_shi_tra_trade_number = drv.mes_lis_acc_tra_trade_number
        INNER JOIN data_receives AS dr ON dr.data_receive_id=drv.data_receive_id
        INNER join data_shipment_items AS dsi ON dsi.data_shipment_voucher_id=dsv.data_shipment_voucher_id
        INNER JOIN data_receive_items AS dri ON dsi.mes_lis_shi_lin_lin_line_number=dri.mes_lis_acc_lin_lin_line_number AND dri.data_receive_voucher_id=drv.data_receive_voucher_id

        WHERE
        dr.cmn_connect_id=$cmn_connect_id
        AND ds.cmn_connect_id = $cmn_connect_id
        AND dsv.data_shipment_voucher_id IN($shipment_ids)
        AND (
        dsv.mes_lis_shi_tot_tot_net_price_total != drv.mes_lis_acc_tot_tot_net_price_total
        OR
        (
        case when dsv.mes_lis_shi_tra_dat_revised_delivery_date IS NULL then
        dsv.mes_lis_shi_tra_dat_delivery_date
        else
        dsv.mes_lis_shi_tra_dat_revised_delivery_date
        END
        )
         != drv.mes_lis_acc_tra_dat_transfer_of_ownership_date
        )
        ORDER BY
        dsv.mes_lis_shi_par_sel_code,
        dsv.mes_lis_shi_tra_trade_number,
        dsi.mes_lis_shi_lin_lin_line_number");
        // return $result;
        $new_file_name = $this->all_used_fun->downloadFileName($request, 'csv','請求');
        $download_file_url = Config::get('app.url')."storage/app".config('const.INVOICE_COMPARE_CSV_PATH')."/". $new_file_name;

        // CSV create
        Csv::create(
            config('const.INVOICE_COMPARE_CSV_PATH')."/". $new_file_name,
            $result,
            InvoiceDataController::invoiceCompareCsvHeading(),
            config('const.CSV_FILE_ENCODE')
        );
        return response()->json(['message' => 'Success','status'=>1,'new_file_name'=>$new_file_name, 'url' => $download_file_url]);
    }
    public function invoiceCompareItem(Request $request){
        // return $request->all();
        $data_shipment_voucher_id=$request->data_shipment_voucher_id;
        $data_receive_voucher_id=$request->data_receive_voucher_id;
        // $adm_user_id=$request->adm_user_id;
        // $byr_buyer_id=$request->byr_buyer_id;
        // $cmn_connect_id =null;
        // $authUser = User::find($adm_user_id);
        //     if (!$authUser->hasRole(config('const.adm_role_name'))) {
        //         $cmn_company_info=$this->all_used_fun->get_user_info($adm_user_id,$byr_buyer_id);
        //         $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        //     }
        $result = DB::select(" SELECT
        dsi.mes_lis_shi_lin_lin_line_number,
        dsi.mes_lis_shi_lin_ite_order_item_code,
        dsi.mes_lis_shi_lin_ite_name,
        dsi.mes_lis_shi_lin_qua_shi_quantity,
        dri.mes_lis_acc_lin_qua_rec_quantity,
        case when dsi.mes_lis_shi_lin_amo_item_net_price IS NULL then
        0
        else
        dsi.mes_lis_shi_lin_amo_item_net_price
        END AS mes_lis_shi_lin_amo_item_net_price,

        case when dri.mes_lis_acc_lin_amo_item_net_price IS NULL then
        0
        else
        dri.mes_lis_acc_lin_amo_item_net_price
        END AS mes_lis_acc_lin_amo_item_net_price

        FROM
        data_shipment_items AS dsi
        INNER JOIN data_receive_items AS dri ON dsi.mes_lis_shi_lin_lin_line_number=dri.mes_lis_acc_lin_lin_line_number
        WHERE
        dsi.data_shipment_voucher_id= $data_shipment_voucher_id AND dri.data_receive_voucher_id=$data_receive_voucher_id
        ORDER BY dsi.mes_lis_shi_lin_lin_line_number
        ");
        return response()->json(['compareItemList'=>$result]);
    }

    public function get_invoice_customer_code_list(Request $request)
    {

        $cmn_connect_id = $this->all_used_fun->getCmnConnectId($request->adm_user_id,$request->byr_buyer_id);

       $result = DB::select("SELECT
        dip.mes_lis_buy_code,
        dip.mes_lis_buy_name,
        dip.mes_lis_inv_pay_code,
        dip.mes_lis_inv_pay_name
        FROM
       data_invoices AS di
       INNER JOIN data_invoice_pays AS dip ON di.data_invoice_id=dip.data_invoice_id
       WHERE di.cmn_connect_id='".$cmn_connect_id."'
       GROUP BY
       dip.mes_lis_buy_code,
       dip.mes_lis_inv_pay_code");
        return response()->json(['order_customer_code_lists' => $result]);

    }
}
