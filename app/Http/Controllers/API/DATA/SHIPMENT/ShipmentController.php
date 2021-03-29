<?php

namespace App\Http\Controllers\API\DATA\SHIPMENT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AllUsedFunction;
use App\Http\Controllers\API\DATA\Data_Controller;
use App\Models\BYR\byr_buyer;
use App\Exports\ShipmentCSVExport;
use App\Models\DATA\SHIPMENT\data_shipment;
use App\Models\DATA\SHIPMENT\data_shipment_item;
use App\Models\DATA\SHIPMENT\data_shipment_voucher;
use App\Http\Controllers\API\CMN\CmnScenarioController;
use DB;
use App\Traits\Csv;

class ShipmentController extends Controller
{
    private $all_functions;
    private $data_controller;
    public function __construct()
    {
        $this->all_functions = new AllUsedFunction();
        $this->data_controller = new Data_Controller();
        $this->all_functions->folder_create('app/'.config('const.SHIPMENT_CSV_PATH'));
    }
    public function shipmentConfirm(Request $request)
    {
        $data_count=$request->data_count;
        $data_order_id=$request->data_order_id;
        $download_file_url='';
        // return $csv_data_count = Data_Controller::get_shipment_data($request)->get();
        $csv_data_count = Data_Controller::get_shipment_data($request)->get()->count();
        if (!$data_count) {
            $dateTime = date('Y-m-d H:i:s');
            $new_file_name = self::shipmentFileName($data_order_id, 'csv');
            data_shipment::where('data_order_id', $data_order_id)->update(['mes_mes_number_of_trading_documents'=>$csv_data_count]);
            $download_file_url = \Config::get('app.url')."storage/app".config('const.SHIPMENT_CSV_PATH')."/". $new_file_name;
            (new ShipmentCSVExport($request))->store(config('const.SHIPMENT_CSV_PATH').'/'.$new_file_name);
            data_shipment_voucher::where('decision_datetime', '!=', null)
            ->where('send_datetime', '=', null)
            ->update(['send_datetime'=>$dateTime]);
        }

        return response()->json(['message' => 'Success','status'=>1, 'url' => $download_file_url,'csv_data_count'=>$csv_data_count]);
    }
    public function downloadShipmentCsv(Request $request)
    {
        // return $request->all();
        // return $request->all();
        //ownloadType=2 for Fixed length
        $data_order_id=$request->data_order_id;
        $downloadType=$request->downloadType;
        $csv_data_count =0;
        if ($downloadType==1) {
            // CSV Download
            $new_file_name = $new_file_name = self::shipmentFileName($data_order_id, 'csv');
            $download_file_url = \Config::get('app.url')."storage/app".config('const.SHIPMENT_CSV_PATH')."/". $new_file_name;

            // get shipment data query
            $shipment_query = Data_Controller::get_shipment_data($request);
            $csv_data_count = $shipment_query->count();
            $shipment_data = $shipment_query->get()->toArray();

            // CSV create
            Csv::create(
                config('const.SHIPMENT_CSV_PATH')."/". $new_file_name,
                $shipment_data,
                Data_Controller::shipmentCsvHeading(),
                'shift-jis'
            );
        } elseif ($downloadType==2) {
            // JCA Download
            // $request = new \Illuminate\Http\Request();
            // $request->setMethod('POST');
            // $request=$this->request;
            $request->request->add(['scenario_id' => 6]);
            $request->request->add(['data_order_id' => 1]);
            $request->request->add(['email' => 'user@jacos.co.jp']);
            $request->request->add(['password' => 'Qe75ymSr']);
            $new_file_name = self::shipmentFileName($data_order_id, 'txt');
            $download_file_url = \Config::get('app.url')."storage/".config('const.FIXED_LENGTH_FILE_PATH')."/". $new_file_name;
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

        return response()->json(['message' => 'Success','status'=>1,'new_file_name'=>$new_file_name, 'url' => $download_file_url,'csv_data_count'=>$csv_data_count]);
    }
    private static function shipmentFileName($data_order_id, $file_type="csv")
    {
        $file_name_info=data_shipment::select('cmn_connects.partner_code', 'byr_buyers.super_code', 'cmn_companies.jcode','cmn_companies.company_name')
            ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'data_shipments.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
            ->join('slr_sellers', 'slr_sellers.slr_seller_id', '=', 'cmn_connects.slr_seller_id')
            ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'slr_sellers.cmn_company_id')
            ->where('data_shipments.data_order_id', $data_order_id)
            ->first();
            $file_name = '受注'.'_'.$file_name_info->company_name.'_'.date('YmdHis').'.'.$file_type;
        // $file_name = $file_name_info->super_code.'-'."shipment_".$file_name_info->super_code.'-'.$file_name_info->partner_code."-".$file_name_info->jcode.'_shipment_'.date('YmdHis').'.'.$file_type;
        return $file_name;
    }
    public function deletedownloadedshipmentCsv($fileUrl)
    {
        $path = storage_path().'/app'.config('const.SHIPMENT_CSV_PATH')."/". $fileUrl;
        unlink($path);
        return response()->json(['message' => 'Success','status'=>1]);
    }
    public function shipmentUpdate(Request $request)
    {
        // return $request->all();
        $byr_buyer_id=$request->byr_buyer_id;
        $buter_info=byr_buyer::select('setting_information')->where('byr_buyer_id',$byr_buyer_id)->first();
        // return $buter_info;
        $shipment_reason_code_array=json_decode($buter_info->setting_information,true)['shipments']['mes_lis_shi_lin_qua_sto_reason_code'];
        $file_name = time().'-'.$request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs(config('const.SHIPMENT_CSV_UPDATE_PATH'), $file_name);
        \Log::debug('save path:'.$path);

        $received_path = storage_path().'/app//'.config('const.SHIPMENT_CSV_UPDATE_PATH').'/'.$file_name;
        // フォーマット変換

        $dataArr = $this->all_functions->csvReader($received_path, 1);
        $update_status=$this->data_controller->shipmentUpdateArray($dataArr, $file_name,$shipment_reason_code_array);
        $ret = json_decode($update_status->getContent(), true);
        if ($ret['status']===$this->error) {
            unlink(storage_path().'/app/'.$path);
        }
        return $update_status;
    }

    public function update_shipment_item_details(Request $request)
    {
        //return $request->all();
        $items = $request->items;
        // print_r($items[0]['data_shipment_voucher_id']);exit;
        // echo $items[0]->data_shipment_voucher_id;exit;
        $updated_date = $request->updated_date;
        $total_selling_price = $request->total_selling_price;
        $total_cost_price = $request->total_cost_price;
        $updated_date = $request->updated_date;
        $status = $request->order_status;
        data_shipment_voucher::where('data_shipment_voucher_id', $items[0]['data_shipment_voucher_id'])->update(['mes_lis_shi_tra_dat_revised_delivery_date'=>$updated_date,'status'=>$status]);
        foreach ($items as $item) {
            data_shipment_item::where('data_shipment_item_id', $item['data_shipment_item_id'])->update([
               // 'mes_lis_shi_tra_dat_revised_delivery_date'=>$item->mes_lis_shi_tra_dat_revised_delivery_date,
                // 'mes_lis_shi_tot_tot_net_price_total'=>$item->mes_lis_shi_tot_tot_net_price_total,
                // 'mes_lis_shi_tot_tot_selling_price_total'=>$item->mes_lis_shi_tot_tot_selling_price_total,
                // 'mes_lis_shi_tot_tot_tax_total'=>$item->mes_lis_shi_tot_tot_tax_total,
                // 'mes_lis_shi_tot_tot_item_total'=>$item->mes_lis_shi_tot_tot_item_total,
                // 'mes_lis_shi_tot_tot_unit_total'=>$item->mes_lis_shi_tot_tot_unit_total,
                // 'mes_lis_shi_tot_fre_unit_weight_total'=>$item->mes_lis_shi_tot_fre_unit_weight_total,

                'mes_lis_shi_lin_qua_shi_quantity'=>$item['mes_lis_shi_lin_qua_shi_quantity'],
                'mes_lis_shi_lin_qua_shi_num_of_order_units'=>$item['mes_lis_shi_lin_qua_shi_num_of_order_units'],
                'mes_lis_shi_lin_qua_sto_quantity'=>$item['mes_lis_shi_lin_qua_sto_quantity'],
                'mes_lis_shi_lin_qua_sto_num_of_order_units'=>$item['mes_lis_shi_lin_qua_sto_num_of_order_units'],
                'mes_lis_shi_lin_qua_sto_reason_code'=>$item['mes_lis_shi_lin_qua_sto_reason_code'],
                'mes_lis_shi_lin_amo_item_net_price'=>$total_cost_price,
                'mes_lis_shi_lin_amo_item_net_price_unit_price'=>$item['mes_lis_shi_lin_amo_item_net_price_unit_price'],
                'mes_lis_shi_lin_amo_item_selling_price'=>$total_selling_price,
                'mes_lis_shi_lin_amo_item_selling_price_unit_price'=>$item['mes_lis_shi_lin_amo_item_selling_price_unit_price'],
            ]);
        }

        return response()->json(['success' => '1']);
    }

    public function update_shipment_item_detail_form_data(Request $request)
    {
        $items = $request->items;
        $updateArry = array(
            'mes_lis_shi_lin_qua_shi_quantity'=>$items['mes_lis_shi_lin_qua_shi_quantity'],
            'mes_lis_shi_lin_qua_shi_num_of_order_units'=>$items['mes_lis_shi_lin_qua_shi_num_of_order_units'],
            'mes_lis_shi_lin_fre_order_weight'=>$items['mes_lis_shi_lin_fre_order_weight'],
            'mes_lis_shi_lin_amo_item_net_price_unit_price'=>$items['mes_lis_shi_lin_amo_item_net_price_unit_price'],
            'mes_lis_shi_lin_amo_item_net_price'=>$items['mes_lis_shi_lin_amo_item_net_price'],
            'mes_lis_shi_lin_qua_sto_reason_code'=>$items['mes_lis_shi_lin_qua_sto_reason_code']
        );
        data_shipment_item::where('mes_lis_shi_lin_ite_supplier_item_code', $items['mes_lis_shi_lin_ite_supplier_item_code'])->update($updateArry);
        return response()->json(['success' => '1']);
    }
    public function get_all_shipment_item_by_search(Request $request)
    {
        $data_order_id = $request->data_order_id;
        $mes_lis_shi_lin_ite_gtin = $request->mes_lis_shi_lin_ite_gtin;
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;
        $per_page = $request->select_field_per_page_num == null ? 10 : $request->select_field_per_page_num;

        $mes_lis_shi_log_del_delivery_service_code = $request->mes_lis_shi_log_del_delivery_service_code;
        $mes_lis_shi_par_sel_code = $request->mes_lis_shi_par_sel_code;
        $mes_lis_shi_par_sel_name = $request->mes_lis_shi_par_sel_name;
        $mes_lis_shi_tra_dat_delivery_date = $request->mes_lis_shi_tra_dat_delivery_date;
        $mes_lis_shi_tra_goo_major_category = $request->mes_lis_shi_tra_goo_major_category;
        $mes_lis_shi_tra_ins_temperature_code = $request->mes_lis_shi_tra_ins_temperature_code;
        $mes_lis_shi_tra_trade_number = $request->mes_lis_shi_tra_trade_number;
        $receive_datetime = $request->receive_datetime;

        $result = DB::table('data_shipment_items as dsi')
            ->select(
                'dsi.mes_lis_shi_lin_ite_order_item_code',
                'dsi.mes_lis_shi_lin_ite_gtin',
                'dsi.mes_lis_shi_lin_ite_name',
                'dsi.mes_lis_shi_lin_ite_ite_spec',
                'dsi.mes_lis_shi_lin_fre_field_name'
            )
            ->leftJoin('data_shipment_vouchers as dsv', 'dsv.data_shipment_voucher_id', '=', 'dsi.data_shipment_voucher_id')
            ->join('data_shipments as ds', 'ds.data_shipment_id', '=', 'dsv.data_shipment_id')
            ->where('ds.data_order_id', $data_order_id);
            // ->where('dsv.mes_lis_shi_log_del_delivery_service_code', $mes_lis_shi_log_del_delivery_service_code)
            // ->where('dsv.mes_lis_shi_par_sel_code', $mes_lis_shi_par_sel_code)
            // ->where('dsv.mes_lis_shi_par_sel_name', $mes_lis_shi_par_sel_name)
            // ->where('dsv.mes_lis_shi_tra_dat_delivery_date', $mes_lis_shi_tra_dat_delivery_date)
            // ->where('dsv.mes_lis_shi_tra_goo_major_category', $mes_lis_shi_tra_goo_major_category)
            // ->where('dsv.mes_lis_shi_tra_ins_temperature_code', $mes_lis_shi_tra_ins_temperature_code)
            // ->where('dsv.mes_lis_shi_tra_trade_number', $mes_lis_shi_tra_trade_number);
            // ->where('ds.receive_datetime', $receive_datetime);

            if ($mes_lis_shi_lin_ite_gtin) {
                $result=$result->where('dsi.mes_lis_shi_lin_ite_gtin', $mes_lis_shi_lin_ite_gtin);
            }
            $result=$result->whereNull('dsv.decision_datetime');

        $result=$result->groupBy('dsv.mes_lis_shi_tra_trade_number');
        $result=$result->groupBy('dsi.mes_lis_shi_lin_ite_order_item_code');
        $result=$result->orderBy('dsi.'.$sort_by,$sort_type)
        ->paginate($per_page);


        return response()->json(['order_item_lists' => $result]);
    }
    public function decessionData(Request $request)
    {
        $dateTime = null;
       $date_null = $request->date_null;
        if (!$date_null) {
            $dateTime = date('Y-m-d H:i:s');
        }
        $data_shipment_voucher_ids = $request->update_id;
        if ($data_shipment_voucher_ids) {
            foreach ($data_shipment_voucher_ids as $id) {
                if (!$date_null) {
                    data_shipment_voucher::where('data_shipment_voucher_id', $id)
                    ->update([
                        'decision_datetime' => $dateTime,
                        // 'mes_lis_shi_tra_dat_transfer_of_ownership_date' => $dateTime
                        ]);
                }else{
                    data_shipment_voucher::where('data_shipment_voucher_id', $id)
                    ->whereNull('send_datetime')
                    ->update([
                        'decision_datetime' => null,
                        // 'mes_lis_shi_tra_dat_transfer_of_ownership_date' => null
                        ]);
                }

            }
        }
        return response()->json(['success' => '1','status'=>1]);
    }
}
