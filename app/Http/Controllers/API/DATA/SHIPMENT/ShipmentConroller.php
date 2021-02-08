<?php

namespace App\Http\Controllers\API\DATA\SHIPMENT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\AllUsedFunction;
use App\Models\ADM\User;
use App\Models\CMN\cmn_scenario;
use App\Http\Controllers\API\DATA\Data_Controller;
use App\Exports\ShipmentCSVExport;
use App\Exports\ShipmentCSVExportAllData;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use App\Models\BYR\byr_shipment_item;
use App\Models\DATA\SHIPMENT\data_shipment_item;
use App\Models\DATA\SHIPMENT\data_shipment_voucher;
use DB;
class ShipmentConroller extends Controller
{
    private $all_functions;
    public function __construct()
    {
        $this->all_functions = new AllUsedFunction();
    }
    public function shipmentConfirm(Request $request)
    {
        // downloadType=1 for Csv
        // downloadType=2 for Fixed length
        $dateTime = date('Y-m-d H:i:s');
        // \Log::debug(Data_Controller::get_shipment_data($request)->get());

        // if ($downloadType==1) {
            $new_file_name = "Shipment_csv_".date('Y-m-d')."_".time().".csv";
            $download_file_url = \Config::get('app.url')."storage/app".config('const.SHIPMENT_CSV_PATH')."/". $new_file_name;
            $csv_data_count = Data_Controller::get_shipment_data($request)->get()->count();
            (new ShipmentCSVExport($request))->store(config('const.SHIPMENT_CSV_PATH').'/'.$new_file_name);
            data_shipment_voucher::where('decision_datetime','!=',null)->update(array('send_datetime'=>$dateTime));
            return response()->json(['message' => 'Success','status'=>1, 'url' => $download_file_url,'csv_data_count'=>$csv_data_count]);
        // }
    }
    public function downloadShipmentCsv(Request $request)
    {
        $downloadType=$request->downloadType;
        if ($downloadType==1) {
            $new_file_name = "Shipment_csv_".date('Y-m-d')."_".time().".csv";
            $download_file_url = \Config::get('app.url')."storage/app".config('const.SHIPMENT_CSV_PATH')."/". $new_file_name;
            $csv_data_count = Data_Controller::get_shipment_data($request)->count();
            (new ShipmentCSVExport($request))->store(config('const.SHIPMENT_CSV_PATH').'/'.$new_file_name);
        }

        return response()->json(['message' => 'Success','status'=>1,'new_file_name'=>$new_file_name, 'url' => $download_file_url,'csv_data_count'=>$csv_data_count]);
    }
    public function deletedownloadedshipmentCsv($fileUrl){
        $path = storage_path().'/app'.config('const.SHIPMENT_CSV_PATH')."/". $fileUrl;
        unlink($path);
        return response()->json(['message' => 'Success','status'=>1]);
    }
    public function shipmentUpdate(Request $request){
        $file_name = time().'-'.$request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs(config('const.SHIPMENT_CSV_UPDATE_PATH'), $file_name);
        \Log::debug('save path:'.$path);

        $received_path = storage_path().'/app//'.config('const.SHIPMENT_CSV_UPDATE_PATH').'/'.$file_name;
        // フォーマット変換

        $dataArr = $this->all_functions->csvReader($received_path, 1);
        $update_status=Data_Controller::shipmentUpdateArray($dataArr,$file_name);
        $ret = json_decode($update_status->getContent(), true);
        if ($ret['status']===$this->error) {
            unlink(storage_path().'/app/'.$path);
        }
        return $update_status;
    }

    public function update_shipment_item_details(Request $request){
        //return $request->all();
        $items = $request->items;
        // print_r($items[0]['data_shipment_voucher_id']);exit;
        // echo $items[0]->data_shipment_voucher_id;exit;
        $updated_date = $request->updated_date;
        $total_selling_price = $request->total_selling_price;
        $total_cost_price = $request->total_cost_price;
        $updated_date = $request->updated_date;
        data_shipment_voucher::where('data_shipment_voucher_id', $items[0]['data_shipment_voucher_id'])->update(['mes_lis_shi_tra_dat_revised_delivery_date'=>$updated_date]);
        foreach($items as $item){
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
    public function get_all_shipment_item_by_search(Request $request){
        $data_order_id = $request->data_order_id;
        $delivery_date = $request->delivery_date;
        $delivery_service_code = $request->delivery_service_code;
        $major_category = $request->major_category;
        $temperature_code = $request->temperature_code;
        $per_page = $request->per_page == null ? 10 : $request->per_page;
        $temperature_code = $temperature_code == null ? '' : $temperature_code;
        $form_search = $request->form_search;

        $order_info = DB::table('data_shipments as ds')
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
        ->join('data_shipment_vouchers as dsv', 'dsv.data_shipment_id', '=', 'ds.data_shipment_id')
        ->join('data_shipment_items as dsi', 'dsi.data_shipment_voucher_id', '=', 'dsv.data_shipment_voucher_id')
        ->join('data_orders as dor', 'dor.data_order_id', '=', 'ds.data_order_id')
        ->where('ds.data_order_id', $data_order_id)
        ->where('dsv.mes_lis_shi_tra_dat_delivery_date', $delivery_date)
        ->where('dsv.mes_lis_shi_tra_goo_major_category', $major_category)
        ->where('dsv.mes_lis_shi_log_del_delivery_service_code', $delivery_service_code)
        ->where('dsv.mes_lis_shi_tra_ins_temperature_code', $temperature_code)
        ->groupBy('dsv.mes_lis_shi_tra_trade_number')
        ->first();

        $result = DB::table('data_shipments as ds')
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
            ->join('data_shipment_vouchers as dsv', 'dsv.data_shipment_id', '=', 'ds.data_shipment_id')
            ->join('data_shipment_items as dsi', 'dsi.data_shipment_voucher_id', '=', 'dsv.data_shipment_voucher_id')
            ->join('data_orders as dor', 'dor.data_order_id', '=', 'ds.data_order_id')
            ->where('ds.data_order_id', $data_order_id)
            ->where('dsv.mes_lis_shi_tra_dat_delivery_date', $delivery_date)
            ->where('dsv.mes_lis_shi_tra_goo_major_category', $major_category)
            ->where('dsv.mes_lis_shi_log_del_delivery_service_code', $delivery_service_code)
            ->where('dsv.mes_lis_shi_tra_ins_temperature_code', $temperature_code);
                if($form_search['mes_lis_shi_lin_ite_supplier_item_code']!=""){
                    $result->where('dsi.mes_lis_shi_lin_ite_supplier_item_code', $form_search['mes_lis_shi_lin_ite_supplier_item_code']);
                }
                if($form_search['mes_lis_shi_lin_ite_gtin']!=""){
                    $result->where('dsi.mes_lis_shi_lin_ite_gtin', $form_search['mes_lis_shi_lin_ite_gtin']);
                }
                if($form_search['mes_lis_shi_lin_ite_name']!=""){
                    $result->where('dsi.mes_lis_shi_lin_ite_name', $form_search['mes_lis_shi_lin_ite_name']);
                }
                if($form_search['mes_lis_shi_lin_ite_ite_spec']!=""){
                    $result->where('dsi.mes_lis_shi_lin_ite_ite_spec', $form_search['mes_lis_shi_lin_ite_ite_spec']);
                }
                if($form_search['mes_lis_shi_tra_fre_variable_measure_item_code']!="*"){

                    $result->where('dsv.mes_lis_shi_tra_fre_variable_measure_item_code', $form_search['mes_lis_shi_tra_fre_variable_measure_item_code']);
                }

                $result->groupBy('dsv.mes_lis_shi_tra_trade_number');
                $result = $result->paginate($per_page);


        return response()->json(['order_list_detail' => $result, 'order_info' => $order_info]);
    }
}
