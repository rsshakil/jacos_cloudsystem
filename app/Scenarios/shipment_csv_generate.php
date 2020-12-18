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
        // return $request;
        // $cmn_scenario_id=$request->scenario_id;
        $byr_order_id=$request->order_id;
        $new_file_name = "Shipment_csv_".date('Y-m-d')."_".time().".csv";
        $download_file_url = \Config::get('app.url')."storage/app".config('const.SHIPMENT_CSV_PATH')."/". $new_file_name;

        (new ShipmentCSVExport($byr_order_id))->store(config('const.SHIPMENT_CSV_PATH').'/'.$new_file_name);
        return response()->json(['message' => 'Success', 'url' => $download_file_url]);
        // return (new ShipmentCSVExport($byr_order_id))->download('shipment.xlsx');
        // $shipment_csv_data=byr_shipment::select('byr_shipments.*','bsv.*','bsi.*')
        // ->join('byr_shipment_vouchers as bsv','bsv.byr_shipment_id','=','byr_shipments.byr_shipment_id')
        // ->join('byr_shipment_items as bsi','bsi.byr_shipment_voucher_id','=','bsv.byr_shipment_voucher_id')
        // ->where('byr_shipments.byr_order_id',$byr_order_id)
        // ->get();
        // // return $shipment_csv_data;

        // $columns = array(
        //     'Buyer Shipment ID', 'Buyer Order ID',
        //     'Cmn COnnect ID', 'Buyer Shipment Voucher ID', 
        //     'Buyer Order Voucher ID','Buyer Shipment Item ID',
        //     'Buyer Order Item ID','Category',
        //     'Send Date','Upload Date',
        //     'Revised Delivery Date', 'Confirm Date',
        //     'Printout Date', 'Last Updated Date',
        //     'Data Count','Revised Total Cost Price',
        //     'Order Quantity', 'Confirm Quantity',
        //     'Confirm Unit Quantity', 'Delivery Quantity',
        //     'Stock Out Quantity','Damage Quantity',
        //     'Lack Reason', 'Revised Cost Unit Price',
        //     'Revised Cost Price', 'Revised Selling Unit Price',
        //     'Revised Selling Price','Send File Path',
        //     'Update By', 'Ship Status',
        //     'Created At','Updated At'
        // );
        // //Csv Create
        // $csv = implode(",",$columns)."\n";//Column headers
        // foreach ($shipment_csv_data as $record) {
        //     $csv .=
        //         $record['byr_shipment_id'] . ','. $record['byr_order_id']. ','
        //         . $record['cmn_connect_id'] . ',' . $record['byr_shipment_voucher_id'] . ','
        //         . $record['byr_order_voucher_id'] . ','. $record['byr_shipment_item_id'] . ',' 
        //         . $record['byr_order_item_id'] . ','. $record['category'] . ','
        //         . $record['send_date'] . ',' . $record['upload_date'] . ','
        //         . $record['revised_delivery_date'] . ',' . $record['confirm_date'] . ','
        //         // . date("ymd", strtotime($record['changed_shipment_date'])) . ','
        //         // . date("ymd", strtotime($record['changed_delivery_date'])) . ','
        //         . $record['print_out_date'] . ',' . $record['last_updated_date'] . ','
        //         . $record['data_count'] . ',' . $record['revised_total_cost_price'] . ','
        //         . $record['order_quantity'] . ',' . $record['confirm_quantity'] . ','
        //         . $record['confirm_unit_quantity'] . ',' . $record['delivery_quantity'] . ','
        //         . $record['stock_out_quantity'] . ',' . $record['damage_quantity'] . ','
        //         . $record['lack_reason'] . ',' . $record['revised_cost_unit_price'] . ','
        //         . $record['revised_cost_price'] . ',' . $record['revised_selling_unit_price']. ','
        //         . $record['revised_selling_price'] . ',' . $record['send_file_path']. ','
        //         . $record['update_by'] . ','. $record['ship_status'] . ',' 
        //         . $record['created_at'] . ',' . $record['updated_at'] . "\n"; //Append data to csv
        // }
        // $new_file_name = "Shipment_csv_".date('Y-m-d')."_".time().".csv";
        // $new_file_url = storage_path().'/app'.config('const.SHIPMENT_CSV_PATH').'/'.$new_file_name;
        // // $file_path = \Config::get('app.url') .'storage/app/public/All_Report/'.$new_file_name;
        // $download_file_url = \Config::get('app.url')."storage/app".config('const.SHIPMENT_CSV_PATH')."/". $new_file_name;
        // // $csv_handler = fopen(public_path('finet_order_files/') . $new_file_name, 'w');
        // $csv_handler = fopen($new_file_url, 'w');
        // fwrite($csv_handler, mb_convert_encoding($csv, 'sjis-win', 'utf-8'));
        // fclose($csv_handler);

        // $result = response()->json(['message' => 'Success', 'url' => $download_file_url,'shipment_csv_data'=>$shipment_csv_data]);

        // \Log::debug('----- fileStore end -----');
        // return $result;

        // return $shipment_csv_data;
    }

    
}
