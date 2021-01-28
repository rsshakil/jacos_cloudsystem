<?php

namespace App\Scenarios;
use App\Models\BYR\byr_shipment;
use App\Exports\ShipmentCSVExport;
use Maatwebsite\Excel\Excel;

class shipment_csv_generate
{
    //
    public function exec($request,$sc)
    {
        $byr_order_id=$request->order_id;
        $new_file_name = "Shipment_csv_".date('Y-m-d')."_".time().".csv";
        $download_file_url = \Config::get('app.url')."storage/app".config('const.SHIPMENT_CSV_PATH')."/". $new_file_name;

        (new ShipmentCSVExport($byr_order_id))->store(config('const.SHIPMENT_CSV_PATH').'/'.$new_file_name);
        return response()->json(['message' => 'Success', 'url' => $download_file_url]);
    }


}
