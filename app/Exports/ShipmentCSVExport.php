<?php

namespace App\Exports;

use App\Models\BYR\byr_shipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\API\DATA\Data_Controller;

// class ShipmentCSVExport implements FromQuery,WithHeadings,WithMapping,ShouldAutoSize
class ShipmentCSVExport implements FromQuery,WithHeadings,ShouldAutoSize
{
    use Exportable;
    private $data_order_id;
    private $request;
    public function __construct($request)
    {
        $this->data_order_id = $request->data_order_id;
        $this->request = $request;
    }
    
    // private $writerType = Excel::CSV;
    // private $headers = [
    //     'Content-Type' => 'text/csv',
    // ];
    public function headings(): array
    {
        return [
            'Buyer Shipment ID', 'Buyer Order ID',
            'Cmn COnnect ID', 'Buyer Shipment Voucher ID', 
            'Buyer Order Voucher ID','Buyer Shipment Item ID',
            'Buyer Order Item ID','Category',
            'Send Date','Upload Date',
            'Revised Delivery Date', 'Confirm Date',
            'Printout Date', 'Last Updated Date',
            'Data Count','Revised Total Cost Price',
            'Order Quantity', 'Confirm Quantity',
            'Confirm Unit Quantity', 'Delivery Quantity',
            'Stock Out Quantity','Damage Quantity',
            'Lack Reason', 'Revised Cost Unit Price',
            'Revised Cost Price', 'Revised Selling Unit Price',
            'Revised Selling Price','Send File Path',
            'Update By', 'Ship Status',
            'Created At','Updated At'
        ];
    }
    public function query()
    {
        $shipment_csv_data = Data_Controller::get_shipment_data($this->request);
        // $shipment_csv_data=byr_shipment::select('byr_shipments.*','bsv.*','bsi.*')
        // ->join('byr_shipment_vouchers as bsv','bsv.byr_shipment_id','=','byr_shipments.byr_shipment_id')
        // ->join('byr_shipment_items as bsi','bsi.byr_shipment_voucher_id','=','bsv.byr_shipment_voucher_id')
        // ->where('byr_shipments.byr_order_id',$this->order_id)
        // ->orderBy("byr_shipments.byr_shipment_id");
        return $shipment_csv_data;
    }
    // public function map($shipment_csv_data): array
    // {
    //     return [
    //         $shipment_csv_data->byr_shipment_id,
    //         $shipment_csv_data->byr_order_id,
    //         $shipment_csv_data->cmn_connect_id,
    //         $shipment_csv_data->byr_shipment_voucher_id,
    //         $shipment_csv_data->byr_order_voucher_id,
    //         $shipment_csv_data->byr_shipment_item_id,
    //         $shipment_csv_data->byr_order_item_id,
    //         $shipment_csv_data->category,
    //         $shipment_csv_data->send_date,
    //         $shipment_csv_data->upload_date,
    //         $shipment_csv_data->revised_delivery_date,
    //         $shipment_csv_data->confirm_date,
    //         $shipment_csv_data->print_out_date,
    //         $shipment_csv_data->last_updated_date,
    //         $shipment_csv_data->data_count,
    //         $shipment_csv_data->revised_total_cost_price,
    //         $shipment_csv_data->order_quantity,
    //         $shipment_csv_data->confirm_quantity,
    //         $shipment_csv_data->confirm_unit_quantity,
    //         $shipment_csv_data->delivery_quantity,
    //         $shipment_csv_data->stock_out_quantity,
    //         $shipment_csv_data->damage_quantity,
    //         $shipment_csv_data->lack_reason,
    //         $shipment_csv_data->revised_cost_unit_price,
    //         $shipment_csv_data->revised_cost_price,
    //         $shipment_csv_data->revised_selling_unit_price,
    //         $shipment_csv_data->revised_selling_price,
    //         $shipment_csv_data->send_file_path,
    //         $shipment_csv_data->update_by,
    //         $shipment_csv_data->ship_status,
    //         $shipment_csv_data->created_at,
    //         $shipment_csv_data->updated_at
    //         // Date::dateTimeToExcel($shipment_csv_data->created_at),
    //         // Date::dateTimeToExcel($shipment_csv_data->updated_at),
    //     ];
    // }
}
