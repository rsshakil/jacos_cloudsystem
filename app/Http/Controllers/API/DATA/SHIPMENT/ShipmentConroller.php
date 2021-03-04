<?php

namespace App\Http\Controllers\API\DATA\SHIPMENT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AllUsedFunction;
use App\Http\Controllers\API\DATA\Data_Controller;
use App\Exports\ShipmentCSVExport;
use App\Models\DATA\SHIPMENT\data_shipment;
use App\Models\DATA\SHIPMENT\data_shipment_item;
use App\Models\DATA\SHIPMENT\data_shipment_voucher;
use App\Http\Controllers\API\Cmn_ScenarioController;
use DB;
use App\Traits\Csv;

class ShipmentConroller extends Controller
{
    private $all_functions;
    public function __construct()
    {
        $this->all_functions = new AllUsedFunction();
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
        // downloadType=1 for Csv
        // downloadType=2 for Fixed length
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
            $cs = new Cmn_ScenarioController();
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
        $file_name_info=data_shipment::select('cmn_connects.partner_code', 'byr_buyers.super_code', 'cmn_companies.jcode')
            ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'data_shipments.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
            ->join('slr_sellers', 'slr_sellers.slr_seller_id', '=', 'cmn_connects.slr_seller_id')
            ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'slr_sellers.cmn_company_id')
            ->where('data_shipments.data_order_id', $data_order_id)
            ->first();
        $file_name = $file_name_info->super_code.'-'."shipment_".$file_name_info->super_code.'-'.$file_name_info->partner_code."-".$file_name_info->jcode.'_shipment_'.date('YmdHis').'.'.$file_type;
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
        $file_name = time().'-'.$request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs(config('const.SHIPMENT_CSV_UPDATE_PATH'), $file_name);
        \Log::debug('save path:'.$path);

        $received_path = storage_path().'/app//'.config('const.SHIPMENT_CSV_UPDATE_PATH').'/'.$file_name;
        // フォーマット変換

        $dataArr = $this->all_functions->csvReader($received_path, 1);
        $update_status=Data_Controller::shipmentUpdateArray($dataArr, $file_name);
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
        $delivery_date = $request->delivery_date;
        $delivery_service_code = $request->delivery_service_code;
        $major_category = $request->major_category;
        $temperature_code = $request->temperature_code;
        $per_page = $request->per_page == null ? 10 : $request->per_page;
        $temperature_code = $temperature_code == null ? '' : $temperature_code;
        $form_search = $request->form_search;

        $order_info = DB::table('data_shipment_items as dsi')
        ->select(
            'dor.receive_datetime',
            'dsv.mes_lis_shi_par_sel_code',
            'dsv.mes_lis_shi_par_sel_name',
            'dsv.mes_lis_shi_tra_dat_delivery_date',
            'dsv.mes_lis_shi_tra_goo_major_category',
            'dsv.mes_lis_shi_log_del_delivery_service_code',
            'dsv.mes_lis_shi_tra_ins_temperature_code',
            'dsv.mes_lis_shi_tra_trade_number'
        )
        ->leftJoin('data_shipment_vouchers as dsv', 'dsv.data_shipment_voucher_id', '=', 'dsi.data_shipment_voucher_id')
        ->join('data_shipments as ds', 'ds.data_shipment_id', '=', 'dsv.data_shipment_id')
        ->join('data_orders as dor', 'dor.data_order_id', '=', 'ds.data_order_id')
        ->where('ds.data_order_id', $data_order_id)
        ->where('dsv.mes_lis_shi_tra_dat_delivery_date', $delivery_date)
        ->where('dsv.mes_lis_shi_tra_goo_major_category', $major_category)
        ->where('dsv.mes_lis_shi_log_del_delivery_service_code', $delivery_service_code)
        ->where('dsv.mes_lis_shi_tra_ins_temperature_code', $temperature_code)
        ->whereNull('dsv.decision_datetime')
        ->groupBy('dsv.mes_lis_shi_tra_trade_number')
        ->first();

        $result = DB::table('data_shipment_items as dsi')
            ->select(
                'dor.receive_datetime',
                'dsv.mes_lis_shi_par_sel_code',
                'dsv.mes_lis_shi_par_sel_name',
                'dsv.data_shipment_voucher_id',
                'dsv.mes_lis_shi_tra_dat_delivery_date',
                'dsv.mes_lis_shi_tra_goo_major_category',
                'dsv.mes_lis_shi_log_del_delivery_service_code',
                'dsv.mes_lis_shi_tra_ins_temperature_code',
                'dsv.decision_datetime',
                'dsv.mes_lis_shi_par_shi_code',
                'dsv.mes_lis_shi_par_rec_code',
                'dsv.mes_lis_shi_par_rec_name',
                'dsv.mes_lis_shi_tra_trade_number',
                'dsv.mes_lis_shi_tra_ins_goods_classification_code',
                'dsv.mes_lis_shi_tot_tot_net_price_total',
                'dsv.status',
                'dsv.updated_at',
                'dsv.print_datetime',
                'dsv.send_datetime',
                'dsi.mes_lis_shi_lin_ite_supplier_item_code',
                'dsi.mes_lis_shi_lin_ite_gtin',
                'dsi.mes_lis_shi_lin_ite_name',
                'dsi.mes_lis_shi_lin_ite_ite_spec',
                'dsv.mes_lis_shi_tra_fre_variable_measure_item_code'
            )
            ->leftJoin('data_shipment_vouchers as dsv', 'dsv.data_shipment_voucher_id', '=', 'dsi.data_shipment_voucher_id')
            ->join('data_shipments as ds', 'ds.data_shipment_id', '=', 'dsv.data_shipment_id')
            ->join('data_orders as dor', 'dor.data_order_id', '=', 'ds.data_order_id')
            ->where('ds.data_order_id', $data_order_id)
            ->where('dsv.mes_lis_shi_tra_dat_delivery_date', $delivery_date)
            ->where('dsv.mes_lis_shi_tra_goo_major_category', $major_category)
            ->where('dsv.mes_lis_shi_log_del_delivery_service_code', $delivery_service_code)
            ->whereNull('dsv.decision_datetime')
            ->where('dsv.mes_lis_shi_tra_ins_temperature_code', $temperature_code);
        if ($form_search['mes_lis_shi_lin_ite_supplier_item_code']!="") {
            $result->where('dsi.mes_lis_shi_lin_ite_supplier_item_code', $form_search['mes_lis_shi_lin_ite_supplier_item_code']);
        }
        if ($form_search['mes_lis_shi_lin_ite_gtin']!="") {
            $result->where('dsi.mes_lis_shi_lin_ite_gtin', $form_search['mes_lis_shi_lin_ite_gtin']);
        }
        if ($form_search['mes_lis_shi_lin_ite_name']!="") {
            $result->where('dsi.mes_lis_shi_lin_ite_name', $form_search['mes_lis_shi_lin_ite_name']);
        }
        if ($form_search['mes_lis_shi_lin_ite_ite_spec']!="") {
            $result->where('dsi.mes_lis_shi_lin_ite_ite_spec', $form_search['mes_lis_shi_lin_ite_ite_spec']);
        }
        if ($form_search['mes_lis_shi_tra_fre_variable_measure_item_code']!="*") {
            $result->where('dsv.mes_lis_shi_tra_fre_variable_measure_item_code', $form_search['mes_lis_shi_tra_fre_variable_measure_item_code']);
        }

        $result->groupBy('dsv.mes_lis_shi_tra_trade_number');
        $result->groupBy('dsi.mes_lis_shi_lin_ite_supplier_item_code');
        $result = $result->paginate($per_page);


        return response()->json(['order_list_detail' => $result, 'order_info' => $order_info]);
    }
}
