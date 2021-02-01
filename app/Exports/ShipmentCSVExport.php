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
    private $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    // private $writerType = Excel::CSV;
    // private $headers = [
    //     'Content-Type' => 'text/csv',
    // ];
    public function headings(): array
    {
        return Data_Controller::shipmentCsvHeading();
    }
    public function query()
    {
        $shipment_csv_data = Data_Controller::get_shipment_data($this->request);
        return $shipment_csv_data;
    }
    // public function map($shipment_csv_data): array
    // {
    //     return [
    //         $shipment_csv_data->byr_shipment_id,
    //         $shipment_csv_data->byr_order_id,
    //         $shipment_csv_data->cmn_connect_id,
    //         // Date::dateTimeToExcel($shipment_csv_data->created_at),
    //         // Date::dateTimeToExcel($shipment_csv_data->updated_at),
    //     ];
    // }
}
