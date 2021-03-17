<?php

namespace App\Http\Controllers\API\DATA;

use App\Http\Controllers\Controller;
use App\Models\DATA\ORD\data_order;
use App\Models\DATA\SHIPMENT\data_shipment;
use App\Models\DATA\SHIPMENT\data_shipment_voucher;
use App\Models\DATA\SHIPMENT\data_shipment_item;
use App\Models\DATA\SHIPMENT\data_shipment_item_detail;

class Data_Controller extends Controller
{
    public function __construct()
    {
    }

    public static function get_order_data($request)
    {
        // 対象データ取得
        $do = data_order::select(
            'sta_sen_identifier',
            'sta_sen_ide_authority',
            'sta_rec_identifier',
            'sta_rec_ide_authority',
            'sta_doc_standard',
            'sta_doc_type_version',
            'sta_doc_instance_identifier',
            'sta_doc_type',
            'sta_doc_creation_date_and_time',
            'sta_bus_scope_type',
            'sta_bus_scope_instance_identifier',
            'sta_bus_scope_identifier',
            'mes_ent_unique_creator_identification',
            'mes_mes_sender_station_address',
            'mes_mes_ultimate_receiver_station_address',
            'mes_mes_immediate_receiver_station_addres',
            'mes_mes_number_of_trading_documents',
            'mes_mes_sys_key',
            'mes_mes_sys_value',
            'mes_lis_con_version',
            'mes_lis_doc_version',
            'mes_lis_ext_namespace',
            'mes_lis_ext_version',
            'mes_lis_pay_code',
            'mes_lis_pay_gln',
            'mes_lis_pay_name',
            'mes_lis_pay_name_sbcs',
            'mes_lis_buy_code',
            'mes_lis_buy_gln',
            'mes_lis_buy_name',
            'mes_lis_buy_name_sbcs',
            'mes_lis_ord_tra_trade_number',
            'mes_lis_ord_tra_additional_trade_number',
            'mes_lis_ord_par_shi_code',
            'mes_lis_ord_par_shi_gln',
            'mes_lis_ord_par_shi_name',
            'mes_lis_ord_par_shi_name_sbcs',
            'mes_lis_ord_par_rec_code',
            'mes_lis_ord_par_rec_gln',
            'mes_lis_ord_par_rec_name',
            'mes_lis_ord_par_rec_name_sbcs',
            'mes_lis_ord_par_tra_code',
            'mes_lis_ord_par_tra_gln',
            'mes_lis_ord_par_tra_name',
            'mes_lis_ord_par_tra_name_sbcs',
            'mes_lis_ord_par_dis_code',
            'mes_lis_ord_par_dis_name',
            'mes_lis_ord_par_dis_name_sbcs',
            'mes_lis_ord_par_pay_code',
            'mes_lis_ord_par_pay_gln',
            'mes_lis_ord_par_pay_name',
            'mes_lis_ord_par_pay_name_sbcs',
            'mes_lis_ord_par_sel_code',
            'mes_lis_ord_par_sel_gln',
            'mes_lis_ord_par_sel_name',
            'mes_lis_ord_par_sel_name_sbcs',
            'mes_lis_ord_par_sel_branch_number',
            'mes_lis_ord_par_sel_ship_location_code',
            'mes_lis_ord_log_shi_gln',
            'mes_lis_ord_log_del_route_code',
            'mes_lis_ord_log_del_delivery_service_code',
            'mes_lis_ord_log_del_stock_transfer_code',
            'mes_lis_ord_log_del_delivery_code',
            'mes_lis_ord_log_del_delivery_time',
            'mes_lis_ord_log_del_transportation_code',
            'mes_lis_ord_log_log_barcode_print',
            'mes_lis_ord_log_log_category_name_print1',
            'mes_lis_ord_log_log_category_name_print2',
            'mes_lis_ord_log_log_receiver_abbr_name',
            'mes_lis_ord_log_log_text',
            'mes_lis_ord_log_log_text_sbcs',
            'mes_lis_ord_tra_goo_major_category',
            'mes_lis_ord_tra_goo_sub_major_category',
            'mes_lis_ord_tra_dat_order_date',
            'mes_lis_ord_tra_dat_delivery_date',
            'mes_lis_ord_tra_dat_delivery_date_to_receiver',
            'mes_lis_ord_tra_dat_transfer_of_ownership_date',
            'mes_lis_ord_tra_dat_campaign_start_date',
            'mes_lis_ord_tra_dat_campaign_end_date',
            'mes_lis_ord_tra_dat_valid_until_date',
            'mes_lis_ord_tra_ins_goods_classification_code',
            'mes_lis_ord_tra_ins_order_classification_code',
            'mes_lis_ord_tra_ins_ship_notification_request_code',
            'mes_lis_ord_tra_ins_private_brand_code',
            'mes_lis_ord_tra_ins_temperature_code',
            'mes_lis_ord_tra_ins_liquor_code',
            'mes_lis_ord_tra_ins_trade_type_code',
            'mes_lis_ord_tra_ins_paper_form_less_code',
            'mes_lis_ord_tra_fre_trade_number_request_code',
            'mes_lis_ord_tra_fre_package_code',
            'mes_lis_ord_tra_fre_variable_measure_item_code',
            'mes_lis_ord_tra_tax_tax_type_code',
            'mes_lis_ord_tra_tax_tax_rate',
            'mes_lis_ord_tra_not_text',
            'mes_lis_ord_tra_not_text_sbcs',
            'mes_lis_ord_tot_tot_net_price_total',
            'mes_lis_ord_tot_tot_selling_price_total',
            'mes_lis_ord_tot_tot_tax_total',
            'mes_lis_ord_tot_tot_item_total',
            'mes_lis_ord_tot_tot_unit_total',
            'mes_lis_ord_tot_fre_unit_weight_total',
            'mes_lis_ord_lin_lin_line_number',
            'mes_lis_ord_lin_lin_additional_line_number',
            'mes_lis_ord_lin_fre_trade_number',
            'mes_lis_ord_lin_fre_line_number',
            'mes_lis_ord_lin_goo_minor_category',
            'mes_lis_ord_lin_goo_detailed_category',
            'mes_lis_ord_lin_ite_scheduled_date',
            'mes_lis_ord_lin_ite_deadline_date',
            'mes_lis_ord_lin_ite_center_delivery_instruction_code',
            'mes_lis_ord_lin_ite_maker_code',
            'mes_lis_ord_lin_ite_gtin',
            'mes_lis_ord_lin_ite_order_item_code',
            'mes_lis_ord_lin_ite_ord_code_type',
            'mes_lis_ord_lin_ite_supplier_item_code',
            'mes_lis_ord_lin_ite_name',
            'mes_lis_ord_lin_ite_name_sbcs',
            'mes_lis_ord_lin_ite_ite_spec',
            'mes_lis_ord_lin_ite_ite_spec_sbcs',
            'mes_lis_ord_lin_ite_col_color_code',
            'mes_lis_ord_lin_ite_col_description',
            'mes_lis_ord_lin_ite_col_description_sbcs',
            'mes_lis_ord_lin_ite_siz_size_code',
            'mes_lis_ord_lin_ite_siz_description',
            'mes_lis_ord_lin_ite_siz_description_sbcs',
            'mes_lis_ord_lin_fre_packing_quantity',
            'mes_lis_ord_lin_fre_prefecture_code',
            'mes_lis_ord_lin_fre_country_code',
            'mes_lis_ord_lin_fre_field_name',
            'mes_lis_ord_lin_fre_water_area_code',
            'mes_lis_ord_lin_fre_water_area_name',
            'mes_lis_ord_lin_fre_area_of_origin',
            'mes_lis_ord_lin_fre_item_grade',
            'mes_lis_ord_lin_fre_item_class',
            'mes_lis_ord_lin_fre_brand',
            'mes_lis_ord_lin_fre_item_pr',
            'mes_lis_ord_lin_fre_bio_code',
            'mes_lis_ord_lin_fre_breed_code',
            'mes_lis_ord_lin_fre_cultivation_code',
            'mes_lis_ord_lin_fre_defrost_code',
            'mes_lis_ord_lin_fre_item_preservation_code',
            'mes_lis_ord_lin_fre_item_shape_code',
            'mes_lis_ord_lin_fre_use',
            'mes_lis_ord_lin_sta_statutory_classification_code',
            'mes_lis_ord_lin_amo_item_net_price',
            'mes_lis_ord_lin_amo_item_net_price_unit_price',
            'mes_lis_ord_lin_amo_item_selling_price',
            'mes_lis_ord_lin_amo_item_selling_price_unit_price',
            'mes_lis_ord_lin_amo_item_tax',
            'mes_lis_ord_lin_qua_unit_multiple',
            'mes_lis_ord_lin_qua_unit_of_measure',
            'mes_lis_ord_lin_qua_package_indicator',
            'mes_lis_ord_lin_qua_ord_quantity',
            'mes_lis_ord_lin_qua_ord_num_of_order_units',
            'mes_lis_ord_lin_fre_unit_weight',
            'mes_lis_ord_lin_fre_unit_weight_code',
            'mes_lis_ord_lin_fre_item_weight',
            'mes_lis_ord_lin_fre_order_weight'
        )
            ->join('data_order_vouchers', 'data_order_vouchers.data_order_id', '=', 'data_orders.data_order_id')
            ->join('data_order_items', 'data_order_items.data_order_voucher_id', '=', 'data_order_vouchers.data_order_voucher_id')
            ->join('data_shipment_vouchers', 'data_shipment_vouchers.data_order_voucher_id', '=', 'data_order_vouchers.data_order_voucher_id');

        // 受信日(開始)
        $receive_date_from = $request->get('receive_date_from');
        if ($receive_date_from) {
            $do->where('data_orders.receive_datetime', '>=', $receive_date_from);
        }
        // 受信日(終了)
        $receive_date_to = $request->get('receive_date_to');
        if ($receive_date_to) {
            $do->where('data_orders.receive_datetime', '<=', $receive_date_to);
        }
        // 納品日(開始)
        $delivery_date_from = $request->get('delivery_date_from');
        if ($delivery_date_from) {
            $do->where('data_order_vouchers.mes_lis_ord_tra_dat_delivery_date', '>=', $delivery_date_from);
        }
        // 納品日(終了)
        $delivery_date_to = $request->get('delivery_date_to');
        if ($delivery_date_to) {
            $do->where('data_order_vouchers.mes_lis_ord_tra_dat_delivery_date', '<=', $delivery_date_to);
        }
        // 便
        $delivery_service_code = $request->get('delivery_service_code');
        if ($delivery_service_code) {
            $do->where('data_order_vouchers.mes_lis_ord_log_del_delivery_service_code', $delivery_service_code);
        }
        // 配達温度区分
        $temperature = $request->get('temperature');
        if ($temperature) {
            $do->where('data_order_vouchers.mes_lis_ord_tra_ins_temperature_code', $temperature);
        }

        // TODO 取引先コード
        // TODO 部門

        // 参照状況
        $confirmation_status = $request->get('confirmation_status');
        if ($confirmation_status) {
            $do->whereNotNull('data_order_vouchers.check_datetime');
        }
        // 確定状況
        $decision_status = $request->get('decision_status');
        if ($decision_status) {
            $do->whereNotNull('data_shipment_vouchers.decision_datetime');
        }
        // 印刷状況
        $print_status = $request->get('print_status');
        if ($print_status) {
            $do->whereNotNull('data_shipment_vouchers.print_datetime');
        }
        // 送信状況
        $send_status = $request->get('send_status');
        if ($send_status) {
            $do->whereNotNull('data_shipment_vouchers.print_datetime');
        }

        // 検索
        $do = $do->limit(100000)->get()->toArray();
        return $do;
    }
    public static function get_shipment_data($request)
    {
        // 対象データ取得
        $data_order_id=$request->data_order_id;
        $order_info=$request->order_info;
        $request_all=$request->all();

        $csv_data=data_shipment::select(
            // data_shipments
            'data_shipments.sta_sen_identifier',
            'data_shipments.sta_sen_ide_authority',
            'data_shipments.sta_rec_identifier',
            'data_shipments.sta_rec_ide_authority',
            'data_shipments.sta_doc_standard',
            'data_shipments.sta_doc_type_version',
            'data_shipments.sta_doc_instance_identifier',
            'data_shipments.sta_doc_type',
            'data_shipments.sta_doc_creation_date_and_time',
            // 'data_shipments.sta_bus_scope_type',
            // 'data_shipments.sta_bus_scope_instance_identifier',
            // 'data_shipments.sta_bus_scope_identifier',
            'data_shipments.mes_ent_unique_creator_identification',
            // 'data_shipments.mes_mes_sender_station_address',
            // 'data_shipments.mes_mes_ultimate_receiver_station_address',
            // 'data_shipments.mes_mes_immediate_receiver_station_addres',
            // 'data_shipments.mes_mes_number_of_trading_documents',
            // 'data_shipments.mes_mes_sys_key',
            // 'data_shipments.mes_mes_sys_value',
            // 'data_shipments.mes_lis_con_version',
            // 'data_shipments.mes_lis_doc_version',
            // 'data_shipments.mes_lis_ext_namespace',
            // 'data_shipments.mes_lis_ext_version',
            'data_shipments.mes_lis_pay_code',
            'data_shipments.mes_lis_pay_gln',
            // 'data_shipments.mes_lis_pay_name',
            // 'data_shipments.mes_lis_pay_name_sbcs',
            'data_shipments.mes_lis_buy_code',
            'data_shipments.mes_lis_buy_gln',
            'data_shipments.mes_lis_buy_name',
            'data_shipments.mes_lis_buy_name_sbcs',
            // data_shipment_vouchers
            'data_shipment_vouchers.mes_lis_shi_tra_trade_number',
            'data_shipment_vouchers.mes_lis_shi_tra_additional_trade_number',
            'data_shipment_vouchers.mes_lis_shi_fre_shipment_number',
            'data_shipment_vouchers.mes_lis_shi_par_shi_code',
            'data_shipment_vouchers.mes_lis_shi_par_shi_gln',
            'data_shipment_vouchers.mes_lis_shi_par_shi_name',
            'data_shipment_vouchers.mes_lis_shi_par_shi_name_sbcs',
            'data_shipment_vouchers.mes_lis_shi_par_rec_code',
            'data_shipment_vouchers.mes_lis_shi_par_rec_gln',
            'data_shipment_vouchers.mes_lis_shi_par_rec_name',
            'data_shipment_vouchers.mes_lis_shi_par_rec_name_sbcs',
            'data_shipment_vouchers.mes_lis_shi_par_tra_code',
            'data_shipment_vouchers.mes_lis_shi_par_tra_gln',
            'data_shipment_vouchers.mes_lis_shi_par_tra_name',
            'data_shipment_vouchers.mes_lis_shi_par_tra_name_sbcs',
            // 'data_shipment_vouchers.mes_lis_shi_par_dis_code',
            // 'data_shipment_vouchers.mes_lis_shi_par_dis_name',
            // 'data_shipment_vouchers.mes_lis_shi_par_dis_name_sbcs',
            'data_shipment_vouchers.mes_lis_shi_par_pay_code',
            'data_shipment_vouchers.mes_lis_shi_par_pay_gln',
            'data_shipment_vouchers.mes_lis_shi_par_pay_name',
            'data_shipment_vouchers.mes_lis_shi_par_pay_name_sbcs',
            'data_shipment_vouchers.mes_lis_shi_par_sel_code',
            'data_shipment_vouchers.mes_lis_shi_par_sel_gln',
            'data_shipment_vouchers.mes_lis_shi_par_sel_name',
            'data_shipment_vouchers.mes_lis_shi_par_sel_name_sbcs',
            'data_shipment_vouchers.mes_lis_shi_par_sel_branch_number',
            'data_shipment_vouchers.mes_lis_shi_par_sel_ship_location_code',
            'data_shipment_vouchers.mes_lis_shi_log_shi_gln',
            'data_shipment_vouchers.mes_lis_shi_log_del_route_code',
            'data_shipment_vouchers.mes_lis_shi_log_del_delivery_service_code',
            'data_shipment_vouchers.mes_lis_shi_log_del_stock_transfer_code',
            'data_shipment_vouchers.mes_lis_shi_log_del_delivery_code',
            'data_shipment_vouchers.mes_lis_shi_log_del_delivery_time',
            'data_shipment_vouchers.mes_lis_shi_log_del_transportation_code',
            'data_shipment_vouchers.mes_lis_shi_log_log_barcode_print',
            'data_shipment_vouchers.mes_lis_shi_log_log_category_name_print1',
            'data_shipment_vouchers.mes_lis_shi_log_log_category_name_print2',
            'data_shipment_vouchers.mes_lis_shi_log_log_receiver_abbr_name',
            'data_shipment_vouchers.mes_lis_shi_log_log_text',
            'data_shipment_vouchers.mes_lis_shi_log_log_text_sbcs',
            'data_shipment_vouchers.mes_lis_shi_log_maker_code_for_receiving',
            'data_shipment_vouchers.mes_lis_shi_log_delivery_slip_number',
            'data_shipment_vouchers.mes_lis_shi_tra_goo_major_category',
            'data_shipment_vouchers.mes_lis_shi_tra_goo_sub_major_category',
            \DB::raw('CASE
            WHEN data_shipment_vouchers.mes_lis_shi_tra_dat_order_date="0000-00-00"
            THEN ""
            ELSE data_shipment_vouchers.mes_lis_shi_tra_dat_order_date  END'),
            \DB::raw('CASE
            WHEN data_shipment_vouchers.mes_lis_shi_tra_dat_delivery_date="0000-00-00"
            THEN ""
            ELSE data_shipment_vouchers.mes_lis_shi_tra_dat_delivery_date  END'),
            \DB::raw('CASE
            WHEN data_shipment_vouchers.mes_lis_shi_tra_dat_delivery_date_to_receiver="0000-00-00"
            THEN ""
            ELSE data_shipment_vouchers.mes_lis_shi_tra_dat_delivery_date_to_receiver  END'),
            \DB::raw('CASE
            WHEN data_shipment_vouchers.mes_lis_shi_tra_dat_revised_delivery_date="0000-00-00"
            THEN ""
            ELSE data_shipment_vouchers.mes_lis_shi_tra_dat_revised_delivery_date  END'),
            \DB::raw('CASE
            WHEN data_shipment_vouchers.mes_lis_shi_tra_dat_transfer_of_ownership_date="0000-00-00"
            THEN ""
            ELSE data_shipment_vouchers.mes_lis_shi_tra_dat_transfer_of_ownership_date  END'),
            \DB::raw('CASE
            WHEN data_shipment_vouchers.mes_lis_shi_tra_dat_campaign_start_date="0000-00-00"
            THEN ""
            ELSE data_shipment_vouchers.mes_lis_shi_tra_dat_campaign_start_date  END'),
            \DB::raw('CASE
            WHEN data_shipment_vouchers.mes_lis_shi_tra_dat_campaign_end_date="0000-00-00"
            THEN ""
            ELSE data_shipment_vouchers.mes_lis_shi_tra_dat_campaign_end_date  END'),

            'data_shipment_vouchers.mes_lis_shi_tra_ins_goods_classification_code',
            'data_shipment_vouchers.mes_lis_shi_tra_ins_order_classification_code',
            'data_shipment_vouchers.mes_lis_shi_tra_ins_ship_notification_request_code',

            \DB::raw('CASE
            WHEN data_shipment_vouchers.mes_lis_shi_tra_ins_eos_code=null
            THEN "01"
            WHEN data_shipment_vouchers.mes_lis_shi_tra_ins_eos_code=""
            THEN "01"
            ELSE data_shipment_vouchers.mes_lis_shi_tra_ins_eos_code  END'),

            // 'data_shipment_vouchers.mes_lis_shi_tra_ins_eos_code',
            'data_shipment_vouchers.mes_lis_shi_tra_ins_private_brand_code',
            'data_shipment_vouchers.mes_lis_shi_tra_ins_temperature_code',
            'data_shipment_vouchers.mes_lis_shi_tra_ins_liquor_code',
            'data_shipment_vouchers.mes_lis_shi_tra_ins_trade_type_code',
            'data_shipment_vouchers.mes_lis_shi_tra_ins_paper_form_less_code',
            'data_shipment_vouchers.mes_lis_shi_tra_fre_trade_number_request_code',
            'data_shipment_vouchers.mes_lis_shi_tra_fre_package_code',
            'data_shipment_vouchers.mes_lis_shi_tra_fre_variable_measure_item_code',
            'data_shipment_vouchers.mes_lis_shi_tra_tax_tax_type_code',
            'data_shipment_vouchers.mes_lis_shi_tra_tax_tax_rate',
            'data_shipment_vouchers.mes_lis_shi_tra_not_text',
            'data_shipment_vouchers.mes_lis_shi_tra_not_text_sbcs',
            'data_shipment_vouchers.mes_lis_shi_tot_tot_net_price_total',
            'data_shipment_vouchers.mes_lis_shi_tot_tot_selling_price_total',
            'data_shipment_vouchers.mes_lis_shi_tot_tot_tax_total',
            'data_shipment_vouchers.mes_lis_shi_tot_tot_item_total',
            'data_shipment_vouchers.mes_lis_shi_tot_tot_unit_total',
            \DB::raw('CASE
            WHEN data_shipment_vouchers.mes_lis_shi_tot_fre_unit_weight_total=null
            THEN "0"
            WHEN data_shipment_vouchers.mes_lis_shi_tot_fre_unit_weight_total=""
            THEN "0"
            ELSE data_shipment_vouchers.mes_lis_shi_tot_fre_unit_weight_total  END'),

            // data_shipment_items
            'data_shipment_items.mes_lis_shi_lin_lin_line_number',
            'data_shipment_items.mes_lis_shi_lin_lin_additional_line_number',
            'data_shipment_items.mes_lis_shi_lin_fre_trade_number',
            'data_shipment_items.mes_lis_shi_lin_fre_line_number',
            'data_shipment_items.mes_lis_shi_lin_fre_shipment_line_number',
            'data_shipment_items.mes_lis_shi_lin_goo_minor_category',
            'data_shipment_items.mes_lis_shi_lin_goo_detailed_category',
            \DB::raw('CASE
            WHEN data_shipment_items.mes_lis_shi_lin_ite_scheduled_date="0000-00-00"
            THEN ""
            ELSE data_shipment_items.mes_lis_shi_lin_ite_scheduled_date  END'),
            'data_shipment_items.mes_lis_shi_lin_ite_deadline_date',
            'data_shipment_items.mes_lis_shi_lin_ite_center_delivery_instruction_code',
            'data_shipment_items.mes_lis_shi_lin_fre_interim_price_code',
            'data_shipment_items.mes_lis_shi_lin_ite_maker_code',
            'data_shipment_items.mes_lis_shi_lin_ite_gtin',
            'data_shipment_items.mes_lis_shi_lin_ite_order_item_code',
            'data_shipment_items.mes_lis_shi_lin_ite_ord_code_type',
            'data_shipment_items.mes_lis_shi_lin_ite_supplier_item_code',
            'data_shipment_items.mes_lis_shi_lin_ite_name',
            'data_shipment_items.mes_lis_shi_lin_ite_name_sbcs',
            'data_shipment_items.mes_lis_shi_lin_fre_shipment_item_code',
            'data_shipment_items.mes_lis_shi_lin_ite_ite_spec',
            'data_shipment_items.mes_lis_shi_lin_ite_ite_spec_sbcs',
            'data_shipment_items.mes_lis_shi_lin_ite_col_color_code',
            'data_shipment_items.mes_lis_shi_lin_ite_col_description',
            'data_shipment_items.mes_lis_shi_lin_ite_col_description_sbcs',
            'data_shipment_items.mes_lis_shi_lin_ite_siz_size_code',
            'data_shipment_items.mes_lis_shi_lin_ite_siz_description',
            'data_shipment_items.mes_lis_shi_lin_ite_siz_description_sbcs',
            'data_shipment_items.mes_lis_shi_lin_fre_packing_quantity',
            'data_shipment_items.mes_lis_shi_lin_fre_prefecture_code',
            'data_shipment_items.mes_lis_shi_lin_fre_country_code',
            'data_shipment_items.mes_lis_shi_lin_fre_field_name',
            'data_shipment_items.mes_lis_shi_lin_fre_water_area_code',
            'data_shipment_items.mes_lis_shi_lin_fre_water_area_name',
            'data_shipment_items.mes_lis_shi_lin_fre_area_of_origin',
            'data_shipment_items.mes_lis_shi_lin_fre_item_grade',
            'data_shipment_items.mes_lis_shi_lin_fre_item_class',
            'data_shipment_items.mes_lis_shi_lin_fre_brand',
            'data_shipment_items.mes_lis_shi_lin_fre_item_pr',
            'data_shipment_items.mes_lis_shi_lin_fre_bio_code',
            'data_shipment_items.mes_lis_shi_lin_fre_breed_code',
            'data_shipment_items.mes_lis_shi_lin_fre_cultivation_code',
            'data_shipment_items.mes_lis_shi_lin_fre_defrost_code',
            'data_shipment_items.mes_lis_shi_lin_fre_item_preservation_code',
            'data_shipment_items.mes_lis_shi_lin_fre_item_shape_code',
            'data_shipment_items.mes_lis_shi_lin_fre_use',
            'data_shipment_items.mes_lis_shi_lin_sta_statutory_classification_code',
            'data_shipment_items.mes_lis_shi_lin_amo_item_net_price',
            'data_shipment_items.mes_lis_shi_lin_amo_item_net_price_unit_price',
            'data_shipment_items.mes_lis_shi_lin_amo_item_selling_price',
            'data_shipment_items.mes_lis_shi_lin_amo_item_selling_price_unit_price',
            'data_shipment_items.mes_lis_shi_lin_amo_item_tax',
            'data_shipment_items.mes_lis_shi_lin_qua_unit_multiple',
            'data_shipment_items.mes_lis_shi_lin_qua_unit_of_measure',
            'data_shipment_items.mes_lis_shi_lin_qua_package_indicator',
            'data_shipment_items.mes_lis_shi_lin_qua_ord_quantity',
            'data_shipment_items.mes_lis_shi_lin_qua_ord_num_of_order_units',
            'data_shipment_items.mes_lis_shi_lin_qua_shi_quantity',
            'data_shipment_items.mes_lis_shi_lin_qua_shi_num_of_order_units',
            'data_shipment_items.mes_lis_shi_lin_qua_sto_quantity',
            \DB::raw('CASE
            WHEN data_shipment_items.mes_lis_shi_lin_qua_sto_num_of_order_units=null
            THEN "0"
            WHEN data_shipment_items.mes_lis_shi_lin_qua_sto_num_of_order_units=""
            THEN "0"
            ELSE data_shipment_items.mes_lis_shi_lin_qua_sto_num_of_order_units  END'),
            'data_shipment_items.mes_lis_shi_lin_qua_sto_reason_code',
            \DB::raw('CASE
            WHEN data_shipment_items.mes_lis_shi_lin_fre_unit_weight=null
            THEN "0"
            WHEN data_shipment_items.mes_lis_shi_lin_fre_unit_weight=""
            THEN "0"
            ELSE data_shipment_items.mes_lis_shi_lin_fre_unit_weight  END'),
            // 'data_shipment_items.mes_lis_shi_lin_fre_unit_weight_code',
            \DB::raw('CASE
            WHEN data_shipment_items.mes_lis_shi_lin_fre_unit_weight_code=null
            THEN "0"
            WHEN data_shipment_items.mes_lis_shi_lin_fre_unit_weight_code=""
            THEN "0"
            ELSE data_shipment_items.mes_lis_shi_lin_fre_unit_weight_code  END'),
            \DB::raw('CASE
            WHEN data_shipment_items.mes_lis_shi_lin_fre_item_weight=null
            THEN "0"
            WHEN data_shipment_items.mes_lis_shi_lin_fre_item_weight=""
            THEN "0"
            ELSE data_shipment_items.mes_lis_shi_lin_fre_item_weight  END'),
            \DB::raw('CASE
            WHEN data_shipment_items.mes_lis_shi_lin_fre_order_weight=null
            THEN "0"
            WHEN data_shipment_items.mes_lis_shi_lin_fre_order_weight=""
            THEN "0"
            ELSE data_shipment_items.mes_lis_shi_lin_fre_order_weight  END'),
            \DB::raw('CASE
            WHEN data_shipment_items.mes_lis_shi_lin_fre_shipment_weight=null
            THEN "0"
            WHEN data_shipment_items.mes_lis_shi_lin_fre_shipment_weight=""
            THEN "0"
            ELSE data_shipment_items.mes_lis_shi_lin_fre_shipment_weight  END'),
            // data_shipment_item_details
            \DB::raw('CASE
            WHEN data_shipment_item_details.mes_lis_shi_lin_pac_itf_code=null
            THEN "0"
            WHEN data_shipment_item_details.mes_lis_shi_lin_pac_itf_code=""
            THEN "0"
            ELSE data_shipment_item_details.mes_lis_shi_lin_pac_itf_code  END'),
            \DB::raw('CASE
            WHEN data_shipment_item_details.mes_lis_shi_lin_pac_package_indicator=null
            THEN "00"
            WHEN data_shipment_item_details.mes_lis_shi_lin_pac_package_indicator=""
            THEN "00"
            ELSE data_shipment_item_details.mes_lis_shi_lin_pac_package_indicator  END'),
            \DB::raw('CASE
            WHEN data_shipment_item_details.mes_lis_shi_lin_pac_number_of_packages=null
            THEN "0"
            WHEN data_shipment_item_details.mes_lis_shi_lin_pac_number_of_packages=""
            THEN "0"
            ELSE data_shipment_item_details.mes_lis_shi_lin_pac_number_of_packages  END'),
            'data_shipment_item_details.mes_lis_shi_lin_pac_con_sell_by_date',
            'data_shipment_item_details.mes_lis_shi_lin_pac_con_production_date',
            'data_shipment_item_details.mes_lis_shi_lin_pac_con_lot_number'
            )
        ->join('data_shipment_vouchers','data_shipment_vouchers.data_shipment_id','=','data_shipments.data_shipment_id')
        ->join('data_shipment_items','data_shipment_vouchers.data_shipment_voucher_id','=','data_shipment_items.data_shipment_voucher_id')
        ->join('data_shipment_item_details','data_shipment_items.data_shipment_item_id','=','data_shipment_item_details.data_shipment_item_id')

        ->where('data_shipments.data_order_id',$data_order_id)
        // filtering
        ->where('data_shipment_vouchers.mes_lis_shi_log_del_delivery_service_code', $order_info['mes_lis_shi_log_del_delivery_service_code'])
        ->where('data_shipment_vouchers.mes_lis_shi_par_sel_code', $order_info['mes_lis_shi_par_sel_code'])
        ->where('data_shipment_vouchers.mes_lis_shi_par_sel_name', $order_info['mes_lis_shi_par_sel_name'])
        ->where('data_shipment_vouchers.mes_lis_shi_tra_dat_delivery_date', $order_info['mes_lis_shi_tra_dat_delivery_date'])
        ->where('data_shipment_vouchers.mes_lis_shi_tra_goo_major_category', $order_info['mes_lis_shi_tra_goo_major_category'])
        ->where('data_shipment_vouchers.mes_lis_shi_tra_ins_temperature_code', $order_info['mes_lis_shi_tra_ins_temperature_code']);
        // receive_datetime not found in shipment tables

        if (!(array_key_exists("downloadType", $request_all))) {
            $csv_data=$csv_data->where('data_shipment_vouchers.decision_datetime','!=',null);
            $csv_data=$csv_data->where('data_shipment_vouchers.send_datetime','=',null);
        }
        $csv_data=$csv_data->groupBy('data_shipment_vouchers.data_shipment_voucher_id');
        $csv_data=$csv_data->orderBy("data_shipments.data_shipment_id");
        // 検索
        // $csv_data = $csv_data->limit(100000)->get()->toArray();
        return $csv_data;
    }

    public static function shipmentCsvHeading(){
        return [
            '送信者ＩＤ',
            '送信者ID発行元',
            '受信者ＩＤ',
            '受信者ID発行元',
            '標準名称',
            'バージョン',
            'インスタンスＩＤ',
            'メッセージ種',
            '作成日時',
            // 'タイプ',
            // 'テスト区分・最終送信先',
            // 'テスト区分ＩＤ・最終送信先ＩＤ',
            'メッセージ識別ＩＤ',
            // '送信者ステーションアドレス',
            // '最終受信者ステーションアドレス',
            // '直接受信者ステーションアドレス',
            // '取引数',
            // 'システム情報：キー',
            // 'システム情報：値',
            // 'XML内容バージョン：バージョンID',
            // 'XML構造バージョン：バージョンID',
            // '拡張情報：ネームスペース',
            // '拡張情報：バージョン番号',
            '支払法人コード',
            '支払法人GLN',
            // '支払法人名称',
            // '支払法人名称カナ',
            '発注者コード',
            '発注者GLN',
            '発注者名称',
            '発注者名称カナ',
            '取引番号（発注・返品）',
            '取引付属番号',
            '出荷者管理番号',
            '直接納品先コード',
            '直接納品先GLN',
            '直接納品先名称',
            '直接納品先名称カナ',
            '最終納品先コード',
            '最終納品先GLN',
            '最終納品先名称',
            '最終納品先名称カナ',
            '計上部署コード',
            '計上部署GLN',
            '計上部署名称',
            '計上部署名称（カナ）',
            // '陳列場所コード',
            // '陳列場所名称',
            // '陳列場所名称カナ',
            '請求取引先コード',
            '請求取引先GLN',
            '請求取引先名',
            '請求取引先名カナ',
            '取引先コード',
            '取引先GLN',
            '取引先名称',
            '取引先名称カナ',
            '取引先：枝番',
            '出荷先コード',
            '出荷場所GLN',
            '納品経路',
            '便No',
            '通過在庫区分',
            '納品区分',
            '指定納品時刻',
            '輸送手段',
            'バーコード情報',
            'カテゴリー名称1（印字用）',
            'カテゴリー名称2（印字用）',
            '最終納品先略称（印字用）',
            'ラベル自由使用欄（印字用）',
            'ラベル自由使用欄半角カナ（印字用）',
            '入荷管理用メーカーコード',
            'センター納品書番号',
            '商品分類（大）',
            '商品分類（中）',
            '発注日',
            '直接納品先納品日',
            '最終納品先納品日',
            '訂正後直接納品先納品日',
            '計上日',
            '販促開始日',
            '販促終了日',
            '商品区分',
            '発注区分',
            '出荷データ有無区分',
            'EOS区分',
            'PB区分',
            '配送温度区分',
            '酒区分',
            '処理種別',
            '伝票レス区分',
            '取引番号区分',
            'パック区分',
            '不定貫区分',
            '税区分',
            '税率',
            '自由使用欄',
            '自由使用欄半角カナ',
            '原価金額合計',
            '売価金額合計',
            '税額合計金額',
            '数量合計',
            '発注単位数量合計',
            '重量合計',
            '取引明細番号（発注・返品）',
            '取引付属明細番号',
            '元取引番号',
            '元取引明細番号',
            '出荷者管理明細番号',
            '商品分類（小）',
            '商品分類（細）',
            '配達予定日',
            '納品期限',
            'センター納品詳細指示',
            '仮伝フラグ',
            'メーカーコード',
            '商品コード（ＧTIN）',
            '商品コード（発注用）',
            '商品コード区分',
            '商品コード（取引先）',
            '商品名',
            '商品名カナ',
            '商品コード（出荷元）',
            '商品規格：規格',
            '商品規格：規格カナ',
            'カラーコード',
            'カラー名称',
            'カラー名称カナ',
            'サイズコード',
            'サイズ名称',
            'サイズ名称カナ',
            '商品規格.生鮮：入数',
            '商品規格.生鮮：都道府県コード',
            '商品規格.生鮮：国コード',
            '商品規格.生鮮：産地名',
            '商品規格.生鮮：水域コード',
            '商品規格.生鮮：水域名',
            '商品規格.生鮮：原産エリア',
            '商品規格.生鮮：等級',
            '商品規格.生鮮：階級',
            '商品規格.生鮮：銘柄',
            '商品規格.生鮮：商品ＰＲ',
            '商品規格.生鮮：バイオ区分',
            '商品規格.生鮮：品種コード',
            '商品規格.生鮮：養殖区分',
            '商品規格.生鮮：解凍区分',
            '商品規格.生鮮：商品状態区分',
            '商品規格.生鮮：形状・部位',
            '商品規格.生鮮：用途',
            '法定管理義務商材区分',
            '原価金額',
            '原単価',
            '売価金額',
            '売単価',
            '税額',
            '発注単位',
            '発注単位コード',
            '発注荷姿コード',
            '発注数量（バラ）',
            '発注数量（発注単位数）',
            '出荷数量（バラ）',
            '出荷数量（発注単位数）',
            '欠品数量(バラ数)',
            '欠品数量(発注単位数)',
            '欠品区分',
            '取引単位重量',
            '単価登録単位',
            '商品重量',
            '発注重量',
            '出荷重量',
            'ITFコード(集合包装GTIN)',
            '出荷荷姿コード',
            '出荷数量（出荷荷姿数）',
            '賞味期限日',
            '製造日',
            '製造番号'
        ];
    }
    public static function shipmentUpdateArray($data_array,$file_name=""){
            foreach ($data_array as $key => $value) {
                $tmp_shipment['upload_datetime']=date('y-m-d H:i:s');
                $tmp_shipment['upload_file_path']=$file_name;
                $tmp_shipment['sta_sen_identifier']=$value[0];
                $tmp_shipment['sta_sen_ide_authority']=$value[1];
                $tmp_shipment['sta_rec_identifier']=$value[2];
                $tmp_shipment['sta_rec_ide_authority']=$value[3];
                $tmp_shipment['sta_doc_standard']=$value[4];
                $tmp_shipment['sta_doc_type_version']=$value[5];
                $tmp_shipment['sta_doc_instance_identifier']=$value[6];
                $tmp_shipment['sta_doc_type']=$value[7];
                $tmp_shipment['sta_doc_creation_date_and_time']=$value[8];
                $tmp_shipment['mes_ent_unique_creator_identification']=$value[9];
                $tmp_shipment['mes_lis_pay_code']=$value[10];
                $tmp_shipment['mes_lis_pay_gln']=$value[11];
                $tmp_shipment['mes_lis_buy_code']=$value[12];
                $tmp_shipment['mes_lis_buy_gln']=$value[13];
                $tmp_shipment['mes_lis_buy_name']=$value[14];
                $tmp_shipment['mes_lis_buy_name_sbcs']=$value[15];
                // data_shipment_vouchers
                $tmp_shipment_voucher['mes_lis_shi_tra_trade_number']=$value[16];
                $tmp_shipment_voucher['mes_lis_shi_tra_additional_trade_number']=$value[17];
                $tmp_shipment_voucher['mes_lis_shi_fre_shipment_number']=$value[18];
                $tmp_shipment_voucher['mes_lis_shi_par_shi_code']=$value[19];
                $tmp_shipment_voucher['mes_lis_shi_par_shi_gln']=$value[20];
                $tmp_shipment_voucher['mes_lis_shi_par_shi_name']=$value[21];
                $tmp_shipment_voucher['mes_lis_shi_par_shi_name_sbcs']=$value[22];
                $tmp_shipment_voucher['mes_lis_shi_par_rec_code']=$value[23];
                $tmp_shipment_voucher['mes_lis_shi_par_rec_gln']=$value[24];
                $tmp_shipment_voucher['mes_lis_shi_par_rec_name']=$value[25];
                $tmp_shipment_voucher['mes_lis_shi_par_rec_name_sbcs']=$value[26];
                $tmp_shipment_voucher['mes_lis_shi_par_tra_code']=$value[27];
                $tmp_shipment_voucher['mes_lis_shi_par_tra_gln']=$value[28];
                $tmp_shipment_voucher['mes_lis_shi_par_tra_name']=$value[29];
                $tmp_shipment_voucher['mes_lis_shi_par_tra_name_sbcs']=$value[30];
                $tmp_shipment_voucher['mes_lis_shi_par_pay_code']=$value[31];
                $tmp_shipment_voucher['mes_lis_shi_par_pay_gln']=$value[32];
                $tmp_shipment_voucher['mes_lis_shi_par_pay_name']=$value[33];
                $tmp_shipment_voucher['mes_lis_shi_par_pay_name_sbcs']=$value[34];
                $tmp_shipment_voucher['mes_lis_shi_par_sel_code']=$value[35];
                $tmp_shipment_voucher['mes_lis_shi_par_sel_gln']=$value[36];
                $tmp_shipment_voucher['mes_lis_shi_par_sel_name']=$value[37];
                $tmp_shipment_voucher['mes_lis_shi_par_sel_name_sbcs']=$value[38];
                $tmp_shipment_voucher['mes_lis_shi_par_sel_branch_number']=$value[39];
                $tmp_shipment_voucher['mes_lis_shi_par_sel_ship_location_code']=$value[40];
                $tmp_shipment_voucher['mes_lis_shi_log_shi_gln']=$value[41];
                $tmp_shipment_voucher['mes_lis_shi_log_del_route_code']=$value[42];
                $tmp_shipment_voucher['mes_lis_shi_log_del_delivery_service_code']=$value[43];
                $tmp_shipment_voucher['mes_lis_shi_log_del_stock_transfer_code']=$value[44];
                $tmp_shipment_voucher['mes_lis_shi_log_del_delivery_code']=$value[45];
                $tmp_shipment_voucher['mes_lis_shi_log_del_delivery_time']=$value[46];
                $tmp_shipment_voucher['mes_lis_shi_log_del_transportation_code']=$value[47];
                $tmp_shipment_voucher['mes_lis_shi_log_log_barcode_print']=$value[48];
                $tmp_shipment_voucher['mes_lis_shi_log_log_category_name_print1']=$value[49];
                $tmp_shipment_voucher['mes_lis_shi_log_log_category_name_print2']=$value[50];
                $tmp_shipment_voucher['mes_lis_shi_log_log_receiver_abbr_name']=$value[51];
                $tmp_shipment_voucher['mes_lis_shi_log_log_text']=$value[52];
                $tmp_shipment_voucher['mes_lis_shi_log_log_text_sbcs']=$value[53];
                $tmp_shipment_voucher['mes_lis_shi_log_maker_code_for_receiving']=$value[54];
                $tmp_shipment_voucher['mes_lis_shi_log_delivery_slip_number']=$value[55];
                $tmp_shipment_voucher['mes_lis_shi_tra_goo_major_category']=$value[56];
                $tmp_shipment_voucher['mes_lis_shi_tra_goo_sub_major_category']=$value[57];
                $tmp_shipment_voucher['mes_lis_shi_tra_dat_order_date']=$value[58];
                $tmp_shipment_voucher['mes_lis_shi_tra_dat_delivery_date']=$value[59];
                $tmp_shipment_voucher['mes_lis_shi_tra_dat_delivery_date_to_receiver']=$value[60];
                $tmp_shipment_voucher['mes_lis_shi_tra_dat_revised_delivery_date']=$value[61];
                $tmp_shipment_voucher['mes_lis_shi_tra_dat_transfer_of_ownership_date']=$value[62];
                $tmp_shipment_voucher['mes_lis_shi_tra_dat_campaign_start_date']=$value[63];
                $tmp_shipment_voucher['mes_lis_shi_tra_dat_campaign_end_date']=$value[64];
                $tmp_shipment_voucher['mes_lis_shi_tra_ins_goods_classification_code']=$value[65];
                $tmp_shipment_voucher['mes_lis_shi_tra_ins_order_classification_code']=$value[66];
                $tmp_shipment_voucher['mes_lis_shi_tra_ins_ship_notification_request_code']=$value[67];
                $tmp_shipment_voucher['mes_lis_shi_tra_ins_eos_code']=$value[68];
                $tmp_shipment_voucher['mes_lis_shi_tra_ins_private_brand_code']=$value[69];
                $tmp_shipment_voucher['mes_lis_shi_tra_ins_temperature_code']=$value[70];
                $tmp_shipment_voucher['mes_lis_shi_tra_ins_liquor_code']=$value[71];
                $tmp_shipment_voucher['mes_lis_shi_tra_ins_trade_type_code']=$value[72];
                $tmp_shipment_voucher['mes_lis_shi_tra_ins_paper_form_less_code']=$value[73];
                $tmp_shipment_voucher['mes_lis_shi_tra_fre_trade_number_request_code']=$value[74];
                $tmp_shipment_voucher['mes_lis_shi_tra_fre_package_code']=$value[75];
                $tmp_shipment_voucher['mes_lis_shi_tra_fre_variable_measure_item_code']=$value[76];
                $tmp_shipment_voucher['mes_lis_shi_tra_tax_tax_type_code']=$value[77];
                $tmp_shipment_voucher['mes_lis_shi_tra_tax_tax_rate']=$value[78];
                $tmp_shipment_voucher['mes_lis_shi_tra_not_text']=$value[79];
                $tmp_shipment_voucher['mes_lis_shi_tra_not_text_sbcs']=$value[80];
                $tmp_shipment_voucher['mes_lis_shi_tot_tot_net_price_total']=$value[81];
                $tmp_shipment_voucher['mes_lis_shi_tot_tot_selling_price_total']=$value[82];
                $tmp_shipment_voucher['mes_lis_shi_tot_tot_tax_total']=$value[83];
                $tmp_shipment_voucher['mes_lis_shi_tot_tot_item_total']=$value[84];
                $tmp_shipment_voucher['mes_lis_shi_tot_tot_unit_total']=$value[85];
                $tmp_shipment_voucher['mes_lis_shi_tot_fre_unit_weight_total']=$value[86];
                // data_shipment_items
                $tmp_shipment_item['mes_lis_shi_lin_lin_line_number']=$value[87];
                $tmp_shipment_item['mes_lis_shi_lin_lin_additional_line_number']=$value[88];
                $tmp_shipment_item['mes_lis_shi_lin_fre_trade_number']=$value[89];
                $tmp_shipment_item['mes_lis_shi_lin_fre_line_number']=$value[90];
                $tmp_shipment_item['mes_lis_shi_lin_fre_shipment_line_number']=$value[91];
                $tmp_shipment_item['mes_lis_shi_lin_goo_minor_category']=$value[92];
                $tmp_shipment_item['mes_lis_shi_lin_goo_detailed_category']=$value[93];
                $tmp_shipment_item['mes_lis_shi_lin_ite_scheduled_date']=$value[94];
                $tmp_shipment_item['mes_lis_shi_lin_ite_deadline_date']=$value[95];
                $tmp_shipment_item['mes_lis_shi_lin_ite_center_delivery_instruction_code']=$value[96];
                $tmp_shipment_item['mes_lis_shi_lin_fre_interim_price_code']=$value[97];
                $tmp_shipment_item['mes_lis_shi_lin_ite_maker_code']=$value[98];
                $tmp_shipment_item['mes_lis_shi_lin_ite_gtin']=$value[99];
                $tmp_shipment_item['mes_lis_shi_lin_ite_order_item_code']=$value[100];
                $tmp_shipment_item['mes_lis_shi_lin_ite_ord_code_type']=$value[101];
                $tmp_shipment_item['mes_lis_shi_lin_ite_supplier_item_code']=$value[102];
                $tmp_shipment_item['mes_lis_shi_lin_ite_name']=$value[103];
                $tmp_shipment_item['mes_lis_shi_lin_ite_name_sbcs']=$value[104];
                $tmp_shipment_item['mes_lis_shi_lin_fre_shipment_item_code']=$value[105];
                $tmp_shipment_item['mes_lis_shi_lin_ite_ite_spec']=$value[106];
                $tmp_shipment_item['mes_lis_shi_lin_ite_ite_spec_sbcs']=$value[107];
                $tmp_shipment_item['mes_lis_shi_lin_ite_col_color_code']=$value[108];
                $tmp_shipment_item['mes_lis_shi_lin_ite_col_description']=$value[109];
                $tmp_shipment_item['mes_lis_shi_lin_ite_col_description_sbcs']=$value[110];
                $tmp_shipment_item['mes_lis_shi_lin_ite_siz_size_code']=$value[111];
                $tmp_shipment_item['mes_lis_shi_lin_ite_siz_description']=$value[112];
                $tmp_shipment_item['mes_lis_shi_lin_ite_siz_description_sbcs']=$value[113];
                $tmp_shipment_item['mes_lis_shi_lin_fre_packing_quantity']=$value[114];
                $tmp_shipment_item['mes_lis_shi_lin_fre_prefecture_code']=$value[115];
                $tmp_shipment_item['mes_lis_shi_lin_fre_country_code']=$value[116];
                $tmp_shipment_item['mes_lis_shi_lin_fre_field_name']=$value[117];
                $tmp_shipment_item['mes_lis_shi_lin_fre_water_area_code']=$value[118];
                $tmp_shipment_item['mes_lis_shi_lin_fre_water_area_name']=$value[119];
                $tmp_shipment_item['mes_lis_shi_lin_fre_area_of_origin']=$value[120];
                $tmp_shipment_item['mes_lis_shi_lin_fre_item_grade']=$value[121];
                $tmp_shipment_item['mes_lis_shi_lin_fre_item_class']=$value[122];
                $tmp_shipment_item['mes_lis_shi_lin_fre_brand']=$value[123];
                $tmp_shipment_item['mes_lis_shi_lin_fre_item_pr']=$value[124];
                $tmp_shipment_item['mes_lis_shi_lin_fre_bio_code']=$value[125];
                $tmp_shipment_item['mes_lis_shi_lin_fre_breed_code']=$value[126];
                $tmp_shipment_item['mes_lis_shi_lin_fre_cultivation_code']=$value[127];
                $tmp_shipment_item['mes_lis_shi_lin_fre_defrost_code']=$value[128];
                $tmp_shipment_item['mes_lis_shi_lin_fre_item_preservation_code']=$value[129];
                $tmp_shipment_item['mes_lis_shi_lin_fre_item_shape_code']=$value[130];
                $tmp_shipment_item['mes_lis_shi_lin_fre_use']=$value[131];
                $tmp_shipment_item['mes_lis_shi_lin_sta_statutory_classification_code']=$value[132];
                $tmp_shipment_item['mes_lis_shi_lin_amo_item_net_price']=$value[133];
                $tmp_shipment_item['mes_lis_shi_lin_amo_item_net_price_unit_price']=$value[134];
                $tmp_shipment_item['mes_lis_shi_lin_amo_item_selling_price']=$value[135];
                $tmp_shipment_item['mes_lis_shi_lin_amo_item_selling_price_unit_price']=$value[136];
                $tmp_shipment_item['mes_lis_shi_lin_amo_item_tax']=$value[137];
                $tmp_shipment_item['mes_lis_shi_lin_qua_unit_multiple']=$value[138];
                $tmp_shipment_item['mes_lis_shi_lin_qua_unit_of_measure']=$value[139];
                $tmp_shipment_item['mes_lis_shi_lin_qua_package_indicator']=$value[140];
                $tmp_shipment_item['mes_lis_shi_lin_qua_ord_quantity']=$value[141];
                $tmp_shipment_item['mes_lis_shi_lin_qua_ord_num_of_order_units']=$value[142];
                $tmp_shipment_item['mes_lis_shi_lin_qua_shi_quantity']=$value[143];
                $tmp_shipment_item['mes_lis_shi_lin_qua_shi_num_of_order_units']=$value[144];
                $tmp_shipment_item['mes_lis_shi_lin_qua_sto_quantity']=$value[145];
                $tmp_shipment_item['mes_lis_shi_lin_qua_sto_num_of_order_units']=$value[146];
                $tmp_shipment_item['mes_lis_shi_lin_qua_sto_reason_code']=$value[147];
                $tmp_shipment_item['mes_lis_shi_lin_fre_unit_weight']=$value[148];
                $tmp_shipment_item['mes_lis_shi_lin_fre_unit_weight_code']=$value[149];
                $tmp_shipment_item['mes_lis_shi_lin_fre_item_weight']=$value[150];
                $tmp_shipment_item['mes_lis_shi_lin_fre_order_weight']=$value[151];
                $tmp_shipment_item['mes_lis_shi_lin_fre_shipment_weight']=$value[152];
                // data_shipment_item_details
                $tmp_shipment_item_details['mes_lis_shi_lin_pac_itf_code']=$value[153];
                $tmp_shipment_item_details['mes_lis_shi_lin_pac_package_indicator']=$value[154];
                $tmp_shipment_item_details['mes_lis_shi_lin_pac_number_of_packages']=$value[155];
                $tmp_shipment_item_details['mes_lis_shi_lin_pac_con_sell_by_date']=$value[156];
                $tmp_shipment_item_details['mes_lis_shi_lin_pac_con_production_date']=$value[157];
                $tmp_shipment_item_details['mes_lis_shi_lin_pac_con_lot_number']=$value[158];

                $data_shipment_voucher_query=data_shipment_voucher::where('mes_lis_shi_tra_trade_number',$value[16])
                ->where('mes_lis_shi_tra_dat_delivery_date',$value[59]);

                $data_shipment_voucher_info=$data_shipment_voucher_query->first();
                // \Log::info($data_shipment_voucher_info);

                if (empty($data_shipment_voucher_info)) {
                    return response()->json(['status'=>0,'message'=>'Error']);
                }
                $data_shipment_id=$data_shipment_voucher_info->data_shipment_id;

                $data_shipment_voucher_query->update($tmp_shipment_voucher);

                data_shipment::where('data_shipment_id',$data_shipment_id)->update($tmp_shipment);

                $all_voucher=$data_shipment_voucher_query->get();
                foreach ($all_voucher as $key1 => $voucher) {
                    $data_shipment_voucher_id=$voucher->data_shipment_voucher_id;

                    $data_shipment_item_query=data_shipment_item::where('data_shipment_voucher_id',$data_shipment_voucher_id)
                    ->where('mes_lis_shi_lin_ite_gtin',$value[98]);

                    $data_shipment_item_query->update($tmp_shipment_item);
                    $data_shipment_items=$data_shipment_item_query->get();
                    foreach ($data_shipment_items as $key2 => $data_shipment_item) {
                        $data_shipment_item_id=$data_shipment_item->data_shipment_item_id;
                        data_shipment_item_detail::where('data_shipment_item_id',$data_shipment_item_id)
                        ->update($tmp_shipment_item_details);
                    }

                }
            }
        return response()->json(['message'=>"Success",'status'=>1]);

    }


}
