<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Http\Controllers\API\DATA\Data_Controller;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

// class ShipmentCSVExport implements FromQuery,WithHeadings,WithMapping,ShouldAutoSize
class ShipmentCSVExport implements WithStrictNullComparison, FromQuery,WithHeadings,ShouldAutoSize
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

}
