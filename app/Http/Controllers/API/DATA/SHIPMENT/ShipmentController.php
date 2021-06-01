<?php

namespace App\Http\Controllers\API\DATA\SHIPMENT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AllUsedFunction;
use App\Http\Controllers\API\DATA\Data_Controller;
use App\Models\BYR\byr_buyer;
// use App\Exports\ShipmentCSVExport;
use App\Models\DATA\SHIPMENT\data_shipment;
use App\Models\DATA\SHIPMENT\data_shipment_item;
use App\Models\DATA\SHIPMENT\data_shipment_voucher;
use App\Http\Controllers\API\CMN\CmnScenarioController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Traits\Csv;
use App\Models\ADM\User;
use App\Scenarios\byr\OUK\data_csv_order;
use setasign\Fpdi\Tcpdf\Fpdi;
require_once base_path('vendor/tecnickcom/tcpdf/tcpdf.php');
use Symfony\Component\HttpFoundation\Response;
use tecnickcom\tcpdf\TCPDF_FONTS;

class ShipmentController extends Controller
{
    private $all_functions;
    private $data_controller;
    private $data_csv_order;
    public function __construct()
    {
        $this->all_functions = new AllUsedFunction();
        $this->data_csv_order = new data_csv_order();
        $this->data_controller = new Data_Controller();
        $this->all_functions->folder_create('app/'.config('const.SHIPMENT_CSV_PATH'));
    }
    public function sendShipmentData(Request $request)
    {
        Log::debug(__METHOD__.':start---');
        // return $request->all();
        $data_count=$request->data_count;
        $data_order_id=$request->data_order_id;
        $download_file_url='';
        $adm_user_id=$request->adm_user_id;
        $byr_buyer_id=$request->byr_buyer_id;
        $authUser = User::find($adm_user_id);
        $order_info=$request->order_info;
        $cmn_connect_id = '';
        if (!$authUser->hasRole(config('const.adm_role_name'))) {
            $cmn_company_info=$this->all_functions->get_user_info($adm_user_id, $byr_buyer_id);
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }

        $csv_data_count = data_shipment_voucher::join('data_shipments as ds', 'ds.data_shipment_id', '=', 'data_shipment_vouchers.data_shipment_id')
            ->whereNotNull('data_shipment_vouchers.decision_datetime')
            ->whereNull('data_shipment_vouchers.send_datetime')
            ->where('ds.cmn_connect_id', $cmn_connect_id)
            ->where('ds.data_order_id', $data_order_id)
            ->where('data_shipment_vouchers.mes_lis_shi_log_del_delivery_service_code', $order_info['mes_lis_shi_log_del_delivery_service_code'])
            ->where('data_shipment_vouchers.mes_lis_shi_par_sel_code', $order_info['mes_lis_shi_par_sel_code'])
            ->where('data_shipment_vouchers.mes_lis_shi_par_sel_name', $order_info['mes_lis_shi_par_sel_name'])
            ->where('data_shipment_vouchers.mes_lis_shi_tra_dat_delivery_date', $order_info['mes_lis_shi_tra_dat_delivery_date'])
            ->where('data_shipment_vouchers.mes_lis_shi_tra_goo_major_category', $order_info['mes_lis_shi_tra_goo_major_category'])
            ->where('data_shipment_vouchers.mes_lis_shi_tra_ins_temperature_code', $order_info['mes_lis_shi_tra_ins_temperature_code'])->get()->count();

        if (!$data_count) {
            $request->request->add(['cmn_connect_id' => $cmn_connect_id]);
            $dateTime = date('Y-m-d H:i:s');
            // $new_file_name = $this->all_functions->downloadFileName($request, 'csv', '受注');
            $new_file_name = $this->all_functions->sendFileName($request, 'csv', 'shipment');

            data_shipment::where('data_order_id', $data_order_id)->update(['mes_mes_number_of_trading_documents'=>$csv_data_count]);
            $download_file_url = Config::get('app.url')."storage/app".config('const.SHIPMENT_CSV_PATH')."/". $new_file_name;
            // ==============
            $shipment_query = Data_Controller::get_shipment_data($request);
            // $csv_data_count = $shipment_query->count();
            $shipment_data = $shipment_query->get()->toArray();
            // \Log::debug($shipment_data);

            // CSV create
            Csv::create(
                config('const.SHIPMENT_CSV_PATH')."/". $new_file_name,
                $shipment_data,
                Data_Controller::shipmentCsvHeading(),
                config('const.CSV_FILE_ENCODE')
            );
            // ==============
            // (new ShipmentCSVExport($request))->store(config('const.SHIPMENT_CSV_PATH').'/'.$new_file_name);
            data_shipment_voucher::whereNotNull('decision_datetime')
            ->whereNull('send_datetime')
            ->update(['send_datetime'=>$dateTime]);
        }
        Log::debug(__METHOD__.':end---');

        return response()->json(['message' => 'Success','status'=>1, 'url' => $download_file_url,'csv_data_count'=>$csv_data_count]);
    }
    public function downloadShipmentCsv(Request $request)
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
            $new_file_name = $this->all_functions->downloadFileName($request, 'csv', '受注');
            $download_file_url = Config::get('app.url')."storage/app".config('const.SHIPMENT_CSV_PATH')."/". $new_file_name;

            // get shipment data query
            $shipment_query = Data_Controller::get_shipment_data($request);
            $csv_data_count = $shipment_query->count();
            $shipment_data = $shipment_query->get()->toArray();
            // \Log::debug($shipment_data);

            // CSV create
            Csv::create(
                config('const.SHIPMENT_CSV_PATH')."/". $new_file_name,
                $shipment_data,
                Data_Controller::shipmentCsvHeading(),
                config('const.CSV_FILE_ENCODE')
            );
        } elseif ($downloadType==2) {
            // JCA Download
            // $request = new \Illuminate\Http\Request();
            // $request->setMethod('POST');
            // $request=$this->request;
            $request->request->add(['scenario_id' => 6]);
            $request->request->add(['data_order_id' => $data_order_id]);
            $request->request->add(['email' => 'user@jacos.co.jp']);
            $request->request->add(['password' => 'Qe75ymSr']);
            $new_file_name =$this->all_functions->downloadFileName($request, 'txt', '受注');
            $download_file_url = Config::get('app.url')."storage/".config('const.FIXED_LENGTH_FILE_PATH')."/". $new_file_name;
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
    public function sipmentPdfDownload(Request $request)
    {
        Log::debug(__METHOD__.':start---');
        // return $request->all();
        $shipment_download_type=$request->shipment_download_type;
        $csv_data_count =0;
        $download_file_url=null;
        if ($shipment_download_type=='pdf') {
            // CSV Download
            $new_file_name = $this->all_functions->downloadFileName($request, 'pdf', '受注');
            $download_file_url = Config::get('app.url')."storage/app".config('const.PDF_SAVE_PATH')."/". $new_file_name;

            // get shipment data query
            $pdf_datas = Data_Controller::getShipmentPdfData($request);
            $download_files=$this->pdfGenerate($pdf_datas);
            $download_file_url=$download_files[0]['pdf_file_path'];
            $pdf_file_names=$download_files[0]['pdf_file_name'];
        }
        Log::debug(__METHOD__.':end---');

        return response()->json(['message' => 'Success','status'=>1,'new_file_name'=>$pdf_file_names, 'url' => $download_file_url,'csv_data_count'=>$csv_data_count]);
    }

    // PDF Function
    public function pdfGenerate($pdf_datas=[])
    {
        Log::debug(__METHOD__.':start---');

        $pdf_file_paths=array();
        $x = 0;
        $y = 0;
        $odd_even=0;
        $data_count=0;

        $receipt=$this->fpdfRet();
        foreach ($pdf_datas as $key => $pdf_data) {
            $receipt->AddPage();
            foreach ($pdf_data as $key => $value) {
                if ($data_count==0) {
                    $receipt=$this->headerData($receipt, $value, $x, $y);
                }
                if ($odd_even==0) {
                    if ($data_count!=0 && $data_count%2==0) {
                        $receipt->AddPage();
                        $receipt=$this->headerData($receipt, $value, $x, $y);
                    }
                    $this->coordinateText($receipt, $value, 0, 50.7, 103.4);
                }else{
                    $this->coordinateText($receipt, $value, 0, 117, 170);
                }

                if ($odd_even==0) {
                    $odd_even=1;
                }else{
                    $odd_even=0;
                }
                $data_count+=1;
            }

            $data_count=0;
            $odd_even=0;
        }
        $pdf_file_path= $this->file_save($receipt, 0);
        array_push($pdf_file_paths, $pdf_file_path);
        // return 0;
        Log::debug(__METHOD__.':end---');
        return $pdf_file_paths;
        // return $response;
    }
    // PDF Function End
    public function fpdfRet()
    {
        Log::debug(__METHOD__.':start---');
        Log::info("FPDI");
        $receipt = new Fpdi();
        // Set PDF margins (top left and right)
        $receipt->SetMargins(0, 0, 0);

        // Disable header output
        $receipt->setPrintHeader(false);

        // Disable footer output
        $receipt->setPrintFooter(false);
        // $receipt->UseTemplate($tplIdx, null, null, null, null, true);
        $receipt->setFontSubsetting(true);
        // font declared
        $fontPathRegular = storage_path(config('const.MIGMIX_FONT_PATH'));
        $receipt->SetFont(\TCPDF_FONTS::addTTFfont($fontPathRegular), '', 8, '', true);

        Log::debug(__METHOD__.':end---');

        return $receipt;
    }
    public function headerData($receipt, $pdf_data, $x, $y)
    {
        Log::debug(__METHOD__.':start---');
        $receipt->setSourceFile(storage_path(config('const.BLANK_PDF_PATH')));
        $tplIdx = $receipt->importPage(1);
        $receipt->UseTemplate($tplIdx, null, null, null, null, true);
        $receipt->SetXY($x + 23, $y + 33.5);
        $receipt->Write(0, $pdf_data[0]->fax_number);
        $receipt->SetXY($x + 15, $y + 37.8);
        $receipt->Write(0, $pdf_data[0]->mes_lis_ord_par_sel_name_sbcs);
        $receipt->SetXY($x + 26.5, $y + 41.8);
        $receipt->Write(0, $pdf_data[0]->mes_lis_ord_par_sel_code);
        $receipt->SetXY($x + 122, $y + 33);
        $receipt->Write(0, $pdf_data[0]->mes_lis_ord_par_shi_name);
        Log::debug(__METHOD__.':end---');
        return $receipt;
    }
    public function coordinateText($receipt, $pdf_data, $x = 0, $y = 50.7, $sum_of_y=103.4)
    {
        Log::debug(__METHOD__.':start---');
        //Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
        $receipt->SetXY($x + 29.6, $y);
        $receipt->Cell(14.8, 0, $pdf_data[0]->mes_lis_ord_par_rec_name_sbcs, 0, 1, 'L', 0, '', 0);
        $receipt->SetXY($x + 62.5, $y);
        $receipt->Cell(20, 0, str_pad($pdf_data[0]->mes_lis_ord_par_rec_code, 4, "0", STR_PAD_LEFT), 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 100.5, $y);
        $receipt->Cell(11.5, 0, '50', 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 121.5, $y);
        $receipt->Cell(11.5, 0, str_pad($pdf_data[0]->mes_lis_ord_tra_goo_major_category, 4, "0", STR_PAD_LEFT), 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 147.5, $y);
        $receipt->Cell(4.5, 0, $pdf_data[0]->mes_lis_ord_log_del_delivery_service_code, 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 170.2, $y);
        $receipt->Cell(22, 0, $pdf_data[0]->mes_lis_ord_tra_trade_number, 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 207, $y);
        $receipt->Cell(21.6, 0, date('y/m/d', strtotime($pdf_data[0]->mes_lis_ord_tra_dat_order_date)), 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 243, $y);
        $receipt->Cell(21.6, 0, date('y/m/d', strtotime($pdf_data[0]->mes_lis_ord_tra_dat_delivery_date)), 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 29.6, $y += 4.5);
        $receipt->Cell(14.8, 0, $pdf_data[0]->mes_lis_ord_tra_ins_goods_classification_code, 0, 1, 'C', 0, '', 0);
        $y += 8.3;
        foreach ($pdf_data as $key1 => $value) {
            $receipt->SetXY($x += 14.7, $y);
            $receipt->Cell(14.8, 4.5, str_pad($value->mes_lis_ord_lin_lin_line_number, 2, "0", STR_PAD_LEFT), 0, 1, 'C', 0, '', 0);
            $receipt->SetXY($x += 15, $y);
            $receipt->Cell(52.5, 4.5, $value->mes_lis_ord_lin_ite_name_sbcs, 0, 1, 'L', 0, '', 0);
            $receipt->SetXY($x += 52.5, $y);
            $receipt->Cell(30, 4.5, $value->mes_lis_ord_lin_ite_order_item_code, 0, 1, 'L', 0, '', 0);
            $receipt->SetXY($x += 30, $y);
            $receipt->Cell(21, 4.5, intVal($value->mes_lis_ord_lin_qua_ord_quantity), 0, 1, 'R', 0, '', 0);
            $receipt->SetXY($x += 21, $y);
            $receipt->Cell(37, 4.5, number_format($value->mes_lis_ord_lin_amo_item_net_price_unit_price, 2), 0, 1, 'R', 0, '', 0);
            $receipt->SetXY($x += 37, $y);
            $receipt->Cell(36.8, 4.5, number_format($value->mes_lis_ord_lin_amo_item_net_price), 0, 1, 'R', 0, '', 0);
            $receipt->SetXY($x += 36.8, $y);
            $receipt->Cell(21.5, 4.5, number_format($value->mes_lis_ord_lin_amo_item_selling_price_unit_price), 0, 1, 'R', 0, '', 0);
            $receipt->SetXY($x += 21.5, $y);
            $receipt->Cell(36, 4.5, number_format($value->mes_lis_ord_lin_amo_item_selling_price), 0, 1, 'R', 0, '', 0);
            $x = 0;
            $y += 4.5;
        }
        $x = 0;
        // if ($i%2==0) {
        //     $y=103.4;
        // }else{
        //     $y=170;
        // }
        // $y += 33.7;
        $receipt->SetXY($x + 170.5, $sum_of_y);
        $receipt->Cell(36.5, 4.5, number_format($value->mes_lis_ord_tot_tot_net_price_total), 0, 1, 'R', 0, '', 0);
        $receipt->SetXY($x + 228.2, $sum_of_y);
        $receipt->Cell(36.5, 4.5, number_format($value->mes_lis_ord_tot_tot_selling_price_total), 0, 1, 'R', 0, '', 0);
        $y=0;
        Log::debug(__METHOD__.':end---');
        return $receipt;
    }
    public function file_save($receipt, $file_number)
    {
        Log::debug(__METHOD__.':start---');

        $pdf_file_name=date('YmdHis').'_'.$file_number.'_receipt.pdf';
        $this->all_functions->folder_create(config('const.PDF_SAVE_PATH'));
        $response = new Response(
            $receipt->Output(storage_path(config('const.PDF_SAVE_PATH').$pdf_file_name), 'F'),
            200,
            array('content-type' => 'application / pdf')
        );
        $pdf_file_path = \Config::get('app.url').'storage/'.config('const.PDF_SAVE_PATH').$pdf_file_name;
        $file_info=array(
            'pdf_file_path'=>$pdf_file_path,
            'pdf_file_name'=>$pdf_file_name
        );
        // $pdf_file_path = storage_path(config('const.PDF_SAVE_PATH').$pdf_file_name);
        // $receipt = new Fpdi();
        // $pagecount = $receipt->setSourceFile($pdf_file_path);
        // Log::info("Counted".$pagecount);
        Log::debug(__METHOD__.':end---');
        return $file_info;
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
        $buter_info=byr_buyer::select('setting_information')->where('byr_buyer_id', $byr_buyer_id)->first();
        // return $buter_info;
        $shipment_reason_code_array=json_decode($buter_info->setting_information, true)['shipments']['mes_lis_shi_lin_qua_sto_reason_code'];
        $file_name = time().'-'.$request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs(config('const.SHIPMENT_CSV_UPDATE_PATH'), $file_name);
        Log::debug('save path:'.$path);

        $received_path = storage_path().'/app//'.config('const.SHIPMENT_CSV_UPDATE_PATH').'/'.$file_name;
        // フォーマット変換

        $dataArr = $this->all_functions->csvReader($received_path, 1);
        $update_status=$this->data_controller->shipmentUpdateArray($dataArr, $file_name, $shipment_reason_code_array);
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
        $mes_lis_shi_tot_tot_net_price_total_sum=0;
        $mes_lis_shi_tot_tot_selling_price_total_sum=0;
        $mes_lis_shi_tot_tot_tax_total_sum=0;
        $mes_lis_shi_tot_tot_item_total_sum=0;
        $mes_lis_shi_tot_tot_unit_total_sum=0;
        foreach ($items as $item) {
            $mes_lis_shi_tot_tot_net_price_total_sum +=$item['mes_lis_shi_lin_amo_item_net_price'];
            $mes_lis_shi_tot_tot_selling_price_total_sum +=$item['mes_lis_shi_lin_amo_item_selling_price'];
            $mes_lis_shi_tot_tot_tax_total_sum +=$item['mes_lis_shi_lin_amo_item_tax'];
            $mes_lis_shi_tot_tot_item_total_sum +=$item['mes_lis_shi_lin_qua_shi_quantity'];
            $mes_lis_shi_tot_tot_unit_total_sum +=$item['mes_lis_shi_lin_qua_shi_num_of_order_units'];
            data_shipment_item::where('data_shipment_item_id', $item['data_shipment_item_id'])->update([
               // 'mes_lis_shi_tra_dat_revised_delivery_date'=>$item->mes_lis_shi_tra_dat_revised_delivery_date,
                // 'mes_lis_shi_tot_tot_net_price_total'=>$item->mes_lis_shi_tot_tot_net_price_total,
                // 'mes_lis_shi_tot_tot_selling_price_total'=>$item->mes_lis_shi_tot_tot_selling_price_total,
                // 'mes_lis_shi_tot_tot_tax_total'=>$item->mes_lis_shi_tot_tot_tax_total,
                // 'mes_lis_shi_tot_tot_item_total'=>$item->mes_lis_shi_tot_tot_item_total,
                // 'mes_lis_shi_tot_tot_unit_total'=>$item->mes_lis_shi_tot_tot_unit_total,
                // 'mes_lis_shi_tot_fre_unit_weight_total'=>$item->mes_lis_shi_tot_fre_unit_weight_total,
                'mes_lis_shi_lin_qua_shi_num_of_order_units'=>$item['mes_lis_shi_lin_qua_shi_num_of_order_units'],
                'mes_lis_shi_lin_qua_shi_quantity'=>$item['mes_lis_shi_lin_qua_shi_quantity'],
                'mes_lis_shi_lin_qua_sto_quantity'=>$item['mes_lis_shi_lin_qua_ord_quantity']-$item['mes_lis_shi_lin_qua_shi_quantity'],
                'mes_lis_shi_lin_qua_sto_num_of_order_units'=>$item['mes_lis_shi_lin_qua_ord_num_of_order_units']-$item['mes_lis_shi_lin_qua_shi_num_of_order_units'],
                'mes_lis_shi_lin_qua_sto_reason_code'=>$item['mes_lis_shi_lin_qua_sto_reason_code'],
               // 'mes_lis_shi_lin_amo_item_net_price'=>$total_cost_price,
                'mes_lis_shi_lin_amo_item_net_price'=>$item['mes_lis_shi_lin_qua_shi_quantity']*$item['mes_lis_shi_lin_amo_item_net_price_unit_price'],
                'mes_lis_shi_lin_amo_item_net_price_unit_price'=>$item['mes_lis_shi_lin_amo_item_net_price_unit_price'],
                //'mes_lis_shi_lin_amo_item_selling_price'=>$total_selling_price,
                'mes_lis_shi_lin_amo_item_selling_price'=>$item['mes_lis_shi_lin_qua_shi_quantity']*$item['mes_lis_shi_lin_amo_item_selling_price_unit_price'],
                'mes_lis_shi_lin_amo_item_tax'=>($item['mes_lis_shi_lin_amo_item_net_price']*$item['mes_lis_shi_tra_tax_tax_rate'])/100,
                'mes_lis_shi_lin_amo_item_selling_price_unit_price'=>$item['mes_lis_shi_lin_amo_item_selling_price_unit_price'],
            ]);
        }
        data_shipment_voucher::where('data_shipment_voucher_id', $items[0]['data_shipment_voucher_id'])->update([
            'mes_lis_shi_tra_dat_revised_delivery_date'=>$updated_date,
            'mes_lis_shi_tot_tot_net_price_total'=>$mes_lis_shi_tot_tot_net_price_total_sum,
            'mes_lis_shi_tot_tot_selling_price_total'=>$mes_lis_shi_tot_tot_selling_price_total_sum,
            'mes_lis_shi_tot_tot_tax_total'=>$mes_lis_shi_tot_tot_tax_total_sum,
            'mes_lis_shi_tot_tot_item_total'=>$mes_lis_shi_tot_tot_item_total_sum,
            'mes_lis_shi_tot_tot_unit_total'=>$mes_lis_shi_tot_tot_unit_total_sum,
            'status'=>$status
            ]);

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
        //$url_q = $request->url_q;

        $major_category = $request->major_category;
        $delivery_service_code = $request->delivery_service_code;
        $delivery_date = $request->delivery_date;
        $temperature_code = $request->temperature_code;
        $mes_lis_shi_lin_ite_order_item_code = $request->order_item_code;

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
            ->where('ds.data_order_id', $data_order_id)
            ->where('dsv.mes_lis_shi_log_del_delivery_service_code', $delivery_service_code)
            // ->where('dsv.mes_lis_shi_par_sel_code', $mes_lis_shi_par_sel_code)
            // ->where('dsv.mes_lis_shi_par_sel_name', $mes_lis_shi_par_sel_name)
            ->where('dsv.mes_lis_shi_tra_dat_delivery_date', $delivery_date)
            ->where('dsv.mes_lis_shi_tra_goo_major_category', $major_category)
            ->where('dsv.mes_lis_shi_tra_ins_temperature_code', $temperature_code);
        // ->where('dsv.mes_lis_shi_tra_trade_number', $mes_lis_shi_tra_trade_number);
        // ->where('ds.receive_datetime', $receive_datetime);

        if ($mes_lis_shi_lin_ite_gtin) {
            $result=$result->where('dsi.mes_lis_shi_lin_ite_gtin', $mes_lis_shi_lin_ite_gtin);
        }
        if ($mes_lis_shi_lin_ite_order_item_code) {
            $result=$result->where('dsi.mes_lis_shi_lin_ite_order_item_code', $mes_lis_shi_lin_ite_order_item_code);
        }
        $result=$result->whereNull('dsv.decision_datetime');

        // $result=$result->groupBy('dsv.mes_lis_shi_tra_trade_number');
        $result=$result->groupBy('dsi.mes_lis_shi_lin_ite_order_item_code');
        $result=$result->orderBy('dsi.'.$sort_by, $sort_type)
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
                } else {
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
