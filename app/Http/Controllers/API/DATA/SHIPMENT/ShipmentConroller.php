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

class ShipmentConroller extends Controller
{
    private $all_functions;
    public function __construct()
    {
        $this->all_functions = new AllUsedFunction();
    }
    public function shipmentConfirm(Request $request)
    {
        //return $request->all();
        // return "Hi";
        // $downloadType=$request->downloadType;
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
            $csv_data_count = Data_Controller::get_shipment_data_download($request)->count();
            (new ShipmentCSVExportAllData($request))->store(config('const.SHIPMENT_CSV_PATH').'/'.$new_file_name);
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
}
