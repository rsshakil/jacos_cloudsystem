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

        // if ($downloadType==1) {
            $new_file_name = "Shipment_csv_".date('Y-m-d')."_".time().".csv";
            $download_file_url = \Config::get('app.url')."storage/app".config('const.SHIPMENT_CSV_PATH')."/". $new_file_name;
            $csv_data_count = Data_Controller::get_shipment_data($request)->count();
            (new ShipmentCSVExport($request))->store(config('const.SHIPMENT_CSV_PATH').'/'.$new_file_name);
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
}
