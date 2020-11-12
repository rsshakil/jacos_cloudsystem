<?php

namespace App\Exports;

use App\Models\BYR\byr_order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Http\Controllers\API\AllUsedFunction;
use Maatwebsite\Excel\Excel;

class IndepenCSVExport implements FromQuery,WithHeadings,WithMapping,ShouldAutoSize
{
    use Exportable;
    private $byr_order_id;
    private $all_functions;
    public function __construct($byr_order_id)
    {
        $this->byr_order_id = $byr_order_id;
        $this->all_functions = new AllUsedFunction();
    }
    public function headings(): array
    {
        return [
            'Partner Code', 'Buyer Name Kana',
            'Saler Name KAna', 'Receive Date', 
            'Voucher Number','Shop Code',
            'Shop Name','Receiver Code',
            'Sale Category','Voucher Category',
            'Order Date', 'Expected Delivery Date',
            'Delivery Service Code', 'Route Code',
            'Tax Rate','Total Cost Price',
            'Total Selling Price','List Number',
            'Jan','Item Name Kana',
            'Spec Kana','Color',
            'Size','Inputs',
            'Order Inputs','Order Quantity',
            'Cost Price','Selling Price',
        ];
    }
    public function query()
    {
        $all_indepen_data=byr_order::select(
            'byr_orders.partner_code',
            'byr_orders.byr_name_kana',
            // 'byr_orders.slr_name',
            'byr_orders.slr_name_kana',
            'byr_orders.receive_date',

            'byr_order_vouchers.voucher_number',
            'byr_order_vouchers.shop_name',
            'byr_order_vouchers.shop_code',
            'byr_order_vouchers.receiver_code',
            'byr_order_vouchers.sale_category',
            'byr_order_vouchers.voucher_category',
            'byr_order_vouchers.order_date',
            'byr_order_vouchers.expected_delivery_date',
            'byr_order_vouchers.delivery_service_code',
            'byr_order_vouchers.route_code',
            // 'byr_order_vouchers.receiver_name',
            // 'byr_order_vouchers.sale_category',
            'byr_order_vouchers.tax_rate',
            'byr_order_vouchers.total_cost_price',
            'byr_order_vouchers.total_selling_price',

            'byr_order_items.list_number',
            'byr_order_items.jan',
            'byr_order_items.item_name_kana',
            'byr_order_items.spec_kana',
            'byr_order_items.color',
            'byr_order_items.size',
            'byr_order_items.inputs',
            // 'byr_order_items.order_unit_quantity',
            'byr_order_items.order_inputs',
            'byr_order_items.order_quantity',

            // 'byr_order_items.cost_unit_price',
            // 'byr_order_items.selling_unit_price',
            'byr_order_items.cost_price',
            'byr_order_items.selling_price',
        )
        ->join('byr_order_vouchers','byr_order_vouchers.byr_order_id','=','byr_orders.byr_order_id')
        ->join('byr_order_items','byr_order_items.byr_order_voucher_id','=','byr_order_vouchers.byr_order_voucher_id')
        ->where('byr_orders.byr_order_id', $this->byr_order_id)
        ->orderBy("byr_orders.byr_order_id");
        return $all_indepen_data;
    }
    public function map($all_indepen_data): array
    {
        return [
            $all_indepen_data->partner_code,
            $this->all_functions->mb_str_pad($all_indepen_data->byr_name_kana, 20),
            $this->all_functions->mb_str_pad($all_indepen_data->slr_name_kana, 20),
            date('ymd', strtotime($all_indepen_data->receive_date)),
            $all_indepen_data->voucher_number,
            $all_indepen_data->shop_name,
            str_pad($all_indepen_data->shop_code, 6, '0', STR_PAD_LEFT),
            str_pad($all_indepen_data->receiver_code, 6, '0', STR_PAD_LEFT),
            $this->all_functions->mb_str_pad($all_indepen_data->sale_category, 2),
            $all_indepen_data->voucher_category,
            date('ymd', strtotime($all_indepen_data->order_date)),
            date('ymd', strtotime($all_indepen_data->expected_delivery_date)),
            str_pad($all_indepen_data->delivery_service_code, 3, '0', STR_PAD_LEFT),
            $all_indepen_data->route_code,
            $all_indepen_data->tax_rate,
            $all_indepen_data->total_cost_price,
            $all_indepen_data->total_selling_price,
            str_pad($all_indepen_data->list_number, 2, '0', STR_PAD_LEFT),
            str_pad($all_indepen_data->jan, 13, '0', STR_PAD_LEFT),
            $this->all_functions->mb_str_pad($all_indepen_data->item_name_kana, 25),
            str_pad($all_indepen_data->spec_kana, 5, '0', STR_PAD_LEFT),
            str_pad($all_indepen_data->color, 7, '0', STR_PAD_LEFT),
            str_pad($all_indepen_data->size, 5, '0', STR_PAD_LEFT),
            str_pad($all_indepen_data->inputs, 7, '0', STR_PAD_LEFT),
            $all_indepen_data->order_inputs=='ケース'?'CS':($all_indepen_data->order_inputs=='ボール'?'BL':str_repeat(" ",2)),
            str_pad(str_replace(".", "", $all_indepen_data->order_quantity), 6, '0', STR_PAD_LEFT),
            $all_indepen_data->cost_price,
            $all_indepen_data->selling_price,
            
        ];
    }
}
