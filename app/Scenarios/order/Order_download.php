<?php

namespace App\Scenarios\order;

use App\Scenarios\Common;
use Illuminate\Database\Eloquent\Model;
use App\Models\BYR\byr_shop;
use App\Models\BYR\byr_item_class;
use App\Models\CMN\cmn_maker;
use App\Models\CMN\cmn_category;
use App\Models\CMN\cmn_category_description;
use App\Models\CMN\cmn_category_path;
use App\Models\DATA\ORD\data_order;
use App\Models\DATA\ORD\data_order_voucher;
use App\Models\DATA\ORD\data_order_item;
use App\Models\DATA\SHIPMENT\data_shipment;
use App\Models\DATA\SHIPMENT\data_shipment_voucher;
use App\Models\DATA\SHIPMENT\data_shipment_item;
use App\Models\DATA\SHIPMENT\data_shipment_item_detail;
use App\Http\Controllers\API\AllUsedFunction;
use DB;
use App\Traits\Csv;

class Order_download extends Model
{
    private $all_functions;
    private $common_class_obj;
    public function __construct()
    {
        $this->common_class_obj = new Common();
        $this->all_functions = new AllUsedFunction();
    }

    //
    public function exec($request, $sc)
    {
        \Log::debug(get_class().' exec start  ---------------');

        // ダウンロード形式取得
        // cmn_connectsより[order_download]のjob_idを取得
        // 取得できない場合、標準BMS基準CSVダウンロード
        // job_id指定の場合はjob_id実行
        // ダウンロードデータ取得




        $fileName = '_'.date('YmdHis').'.csv';
        $filePath = 'app/temp/'.$fileName;
        $filePath = Csv::createCsv($filePath);
        Csv::write($filePath, ['a','b','c']);
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$fileName .'"'
        ];
        \Log::debug(get_class().' exec end    ---------------');
        \Log::debug($filePath);
        \Log::debug(file_get_contents($filePath));
        // return response()->streamDownload(function () {
        //     file_get_contents('C:\\mylog.log');
        // }, 200, $headers);
        return response()->download($filePath, $fileName, $headers);
        // return response()->download($filePath);
    }
}
