<?php

namespace App\Http\Controllers\API\BYR\DATA\SHIPMENT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AllUsedFunction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\DATA\SHIPMENT\data_shipment_voucher;
use App\Http\Controllers\API\BYR\DATA\SHIPMENT\DataController;
use App\Traits\Csv;
use App\Http\Controllers\API\CMN\CmnScenarioController;
use App\Http\Controllers\API\BYR\DATA\DFLT\DefaultFunctions;


class SlrShipmentController extends Controller
{
    private $default_functions;
    private $all_functions;
    public function __construct()
    {
        $this->default_functions = new DefaultFunctions();
        $this->all_functions = new AllUsedFunction();
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
    public function slrSipmentPdfDownload(Request $request)
    {
        Log::debug(__METHOD__.':start---');
        // return $request->all();
        // $byr_buyer_id =Auth::User()->ByrInfo->byr_buyer_id;
        $shipment_download_type=$request->shipment_download_type;
        $order_info=$request->order_info;
        // $request->request->add(['byr_buyer_id'=>$byr_buyer_id]);
        // return $request->all();
        $csv_data_count =0;
        $download_file_url=null;
        if ($shipment_download_type=='pdf') {
            $cur_datetime=date('y-m-d H:i:s');
            // CSV Download
            // $new_file_name = $this->all_functions->downloadFileName($request, 'pdf', '受注');
            // $download_file_url = Config::get('app.url')."storage/app".config('const.PDF_SAVE_PATH')."/". $new_file_name;
            $new_file_name = $this->all_functions->downloadPdfFileName($order_info, 'pdf', '発注明細書');
            // get shipment data query
            $pdf_data_json = DataController::getShipmentPdfData($request);
            $pdf_datas=$pdf_data_json['report_arr_final'];
            $voucher_id_array=$pdf_data_json['voucher_id_array'];

            $download_files=$this->pdfGenerate($pdf_datas,$new_file_name);
            $download_file_url=$download_files[0]['pdf_file_url'];
            $pdf_file_names=$download_files[0]['pdf_file_name'];

            foreach ($voucher_id_array as $key => $voucher_id) {
                data_shipment_voucher::where('data_order_voucher_id', $voucher_id)->update(
                    ['print_datetime'=>$cur_datetime]
                );
            }
        }
        Log::debug(__METHOD__.':end---');

        return response()->json(['message' => 'Success','status'=>1,'new_file_name'=>$pdf_file_names, 'url' => $download_file_url,'csv_data_count'=>$csv_data_count]);
    }

    // PDF Function
    public function pdfGenerate($pdf_datas=[],$new_file_name)
    {
        Log::debug(__METHOD__.':start---');

        $pdf_file_paths=array();
        $x = 0;
        $y = 0;
        $odd_even=0;
        $data_count=0;
        $first_page=0;
        $shipment_pdf_save_path=config('const.SLR_SHIPMENT_PDF_SAVE_PATH');

        $receipt=$this->all_functions->fpdfRet();
        foreach ($pdf_datas as $key => $sel_data) {
            if ($first_page!=0) {
                $receipt->AddPage();
                $first_page+=1;
            }

            foreach ($sel_data as $key => $rec_data) {
                if ($first_page==0) {
                    $receipt->AddPage();
                }

                foreach ($rec_data as $key => $trade_data) {
                    if ($data_count==0) {
                        $receipt=$this->all_functions->pdfHeaderData($receipt, $trade_data, $x, $y);
                    }
                    if ($odd_even==0) {
                        if ($data_count!=0 && $data_count%2==0) {
                            $receipt->AddPage();
                            $receipt=$this->all_functions->pdfHeaderData($receipt, $trade_data, $x, $y);
                        }
                        $this->all_functions->coordinateText($receipt, $trade_data, 0, 50.7, 103.4);
                    } else {
                        $this->all_functions->coordinateText($receipt, $trade_data, 0, 117, 170);
                    }

                    if ($odd_even==0) {
                        $odd_even=1;
                    } else {
                        $odd_even=0;
                    }
                    $data_count+=1;
                }
                $data_count=0;
                $odd_even=0;
            }
            $first_page=0;
        }
        $pdf_file_path= $this->all_functions->pdfFileSave($receipt, $new_file_name, $shipment_pdf_save_path);
        array_push($pdf_file_paths, $pdf_file_path);
        // return 0;
        Log::debug(__METHOD__.':end---');
        return $pdf_file_paths;
        // return $response;
    }
}
