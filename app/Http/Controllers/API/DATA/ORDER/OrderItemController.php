<?php

namespace App\Http\Controllers\API\DATA\ORDER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMN\cmn_tbl_col_setting;
use App\Http\Controllers\API\AllUsedFunction;
use DB;

class OrderItemController extends Controller
{
    private $all_used_fun;

    public function __construct()
    {
        $this->all_used_fun = new AllUsedFunction();
    }
    public function orderItemDetails($data_shipment_voucher_id)
    {
        $orderItem = collect(\DB::select("
        SELECT data_shipment_vouchers.*,data_orders.* FROM data_order_items
        inner join data_order_vouchers on data_order_vouchers.data_order_voucher_id=data_order_items.data_order_voucher_id
        inner join data_shipment_vouchers on data_shipment_vouchers.data_order_voucher_id=data_order_items.data_order_voucher_id
        inner join data_orders on data_orders.data_order_id=data_order_vouchers.data_order_id
        where data_order_items.data_order_voucher_id = '$data_shipment_voucher_id'
        "))->first();
        //shipment
        $result = DB::select("
        SELECT data_shipment_items.*,data_shipment_vouchers.*,data_order_vouchers.*,data_order_items.* FROM data_shipment_items
        inner join data_shipment_vouchers on data_shipment_vouchers.data_shipment_voucher_id=data_shipment_items.data_shipment_voucher_id
        inner join data_shipments on data_shipments.data_shipment_id=data_shipment_vouchers.data_shipment_id
        inner join data_orders on data_orders.data_order_id=data_shipments.data_order_id
        inner join data_order_vouchers on data_order_vouchers.data_order_id=data_orders.data_order_id
        inner join data_order_items on data_order_items.data_order_voucher_id=data_shipment_vouchers.data_order_voucher_id
        where data_shipment_items.data_shipment_voucher_id = '$data_shipment_voucher_id'
        group by data_shipment_items.mes_lis_shi_lin_ite_order_item_code
        ");
        $slected_list = array();
        $result_data = cmn_tbl_col_setting::where('url_slug', 'order_item_list_detail')->first();
        if ($result_data) {
            $header_list = json_decode($result_data->content_setting);
            foreach ($header_list as $header) {
                if ($header->header_status == true) {
                    $slected_list[] = $header->header_field;
                }
            }
        }
        /*coll setting*/
        return response()->json(['order_item_list_detail' => $result, 'orderItem' => $orderItem, 'slected_list' => $slected_list]);
    }
    public function shipmentItemDetailSearch($item_code)
    {
        $orderItem = DB::table('data_shipment_items as dsi')
        ->select(
            'dor.receive_datetime',
            'dsv.mes_lis_shi_par_sel_code',
            'dsv.mes_lis_shi_par_sel_name',
            'dsv.data_shipment_voucher_id',
            'dsv.mes_lis_shi_tra_dat_delivery_date',
            'dsv.mes_lis_shi_tra_goo_major_category',
            'dsv.mes_lis_shi_log_del_delivery_service_code',
            'dsv.mes_lis_shi_tra_ins_temperature_code',
            'dsv.decision_datetime',
            'dsv.mes_lis_shi_par_shi_code',
            'dsv.mes_lis_shi_par_rec_code',
            'dsv.mes_lis_shi_par_rec_name',
            'dsv.mes_lis_shi_tra_trade_number',
            'dsv.mes_lis_shi_tra_ins_goods_classification_code',
            'dsv.mes_lis_shi_tot_tot_net_price_total',
            'dsv.status',
            'dsv.updated_at',
            'dsv.print_datetime',
            'dsv.send_datetime',
            'dsi.*'

        )
        ->leftJoin('data_shipment_vouchers as dsv', 'dsv.data_shipment_voucher_id', '=', 'dsi.data_shipment_voucher_id')
        ->join('data_shipments as ds', 'ds.data_shipment_id', '=', 'dsv.data_shipment_id')
        ->join('data_orders as dor', 'dor.data_order_id', '=', 'ds.data_order_id')
        ->where('dsi.mes_lis_shi_lin_ite_supplier_item_code', $item_code)
        ->whereNull('dsv.decision_datetime')
        ->groupBy('dsv.mes_lis_shi_tra_trade_number')->first();
        //shipment

        $result = DB::table('data_shipment_items as dsi')
            ->select(
                'dor.receive_datetime',
                'dsv.mes_lis_shi_par_sel_code',
                'dsv.mes_lis_shi_par_sel_name',
                'dsv.data_shipment_voucher_id',
                'dsv.mes_lis_shi_tra_dat_delivery_date',
                'dsv.mes_lis_shi_tra_goo_major_category',
                'dsv.mes_lis_shi_log_del_delivery_service_code',
                'dsv.mes_lis_shi_tra_ins_temperature_code',
                'dsv.decision_datetime',
                'dsv.mes_lis_shi_par_shi_code',
                'dsv.mes_lis_shi_par_rec_code',
                'dsv.mes_lis_shi_par_rec_name',
                'dsv.mes_lis_shi_tra_trade_number',
                'dsv.mes_lis_shi_tra_ins_goods_classification_code',
                'dsv.mes_lis_shi_tot_tot_net_price_total',
                'dsv.status',
                'dsv.updated_at',
                'dsv.print_datetime',
                'dsv.send_datetime',
                'dsi.*',
                'doi.*'

            )
            //inner join data_order_items on data_order_items.data_order_voucher_id=data_shipment_vouchers.data_order_voucher_id

            ->leftJoin('data_shipment_vouchers as dsv', 'dsv.data_shipment_voucher_id', '=', 'dsi.data_shipment_voucher_id')
            ->join('data_shipments as ds', 'ds.data_shipment_id', '=', 'dsv.data_shipment_id')
            ->join('data_orders as dor', 'dor.data_order_id', '=', 'ds.data_order_id')
            ->join('data_order_items as doi', 'doi.data_order_voucher_id', '=', 'dsv.data_order_voucher_id')

            ->where('dsi.mes_lis_shi_lin_ite_supplier_item_code', $item_code)
            ->whereNull('dsv.decision_datetime')
            ->groupBy('dsv.mes_lis_shi_tra_trade_number')->get();


        $slected_list = array();
        $result_data = cmn_tbl_col_setting::where('url_slug', 'order_item_list_detail')->first();
        if ($result_data) {
            $header_list = json_decode($result_data->content_setting);
            foreach ($header_list as $header) {
                if ($header->header_status == true) {
                    $slected_list[] = $header->header_field;
                }
            }
        }
        /*coll setting*/
        return response()->json(['order_item_list_detail' => $result, 'orderItem' => $orderItem, 'slected_list' => $slected_list]);
    }
}
