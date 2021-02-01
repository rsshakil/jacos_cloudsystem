<?php

namespace App\Http\Controllers\API\DATA;

use App\Http\Controllers\Controller;
use App\Models\DATA\ORD\data_order;
use App\Models\DATA\SHIPMENT\data_shipment;

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
            'mes_lis_ord_lin_ite_code_type',
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
            'data_shipments.sta_bus_scope_type',
            'data_shipments.sta_bus_scope_instance_identifier',
            'data_shipments.sta_bus_scope_identifier',
            'data_shipments.mes_ent_unique_creator_identification',
            'data_shipments.mes_mes_sender_station_address',
            'data_shipments.mes_mes_ultimate_receiver_station_address',
            'data_shipments.mes_mes_immediate_receiver_station_addres',
            'data_shipments.mes_mes_number_of_trading_documents',
            'data_shipments.mes_mes_sys_key',
            'data_shipments.mes_mes_sys_value',
            'data_shipments.mes_lis_con_version',
            'data_shipments.mes_lis_doc_version',
            'data_shipments.mes_lis_ext_namespace',
            'data_shipments.mes_lis_ext_version',
            'data_shipments.mes_lis_pay_code',
            'data_shipments.mes_lis_pay_gln',
            'data_shipments.mes_lis_pay_name',
            'data_shipments.mes_lis_pay_name_sbcs',
            'data_shipments.mes_lis_buy_code',
            'data_shipments.mes_lis_buy_gln',
            'data_shipments.mes_lis_buy_name',
            'data_shipments.mes_lis_buy_name_sbcs',
            // data_shipment_vouchers
            'data_shipment_vouchers.mes_lis_shi_tra_trade_number',
            'data_shipment_vouchers.mes_lis_shi_tra_additional_trade_number',
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
            'data_shipment_vouchers.mes_lis_shi_par_dis_code',
            'data_shipment_vouchers.mes_lis_shi_par_dis_name',
            'data_shipment_vouchers.mes_lis_shi_par_dis_name_sbcs',
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
            'data_shipment_vouchers.mes_lis_shi_tra_goo_major_category',
            'data_shipment_vouchers.mes_lis_shi_tra_goo_sub_major_category',
            'data_shipment_vouchers.mes_lis_shi_tra_dat_order_date',
            'data_shipment_vouchers.mes_lis_shi_tra_dat_delivery_date',
            'data_shipment_vouchers.mes_lis_shi_tra_dat_delivery_date_to_receiver',
            'data_shipment_vouchers.mes_lis_shi_tra_dat_transfer_of_ownership_date',
            'data_shipment_vouchers.mes_lis_shi_tra_dat_campaign_start_date',
            'data_shipment_vouchers.mes_lis_shi_tra_dat_campaign_end_date',
            'data_shipment_vouchers.mes_lis_shi_tra_ins_goods_classification_code',
            'data_shipment_vouchers.mes_lis_shi_tra_ins_order_classification_code',
            'data_shipment_vouchers.mes_lis_shi_tra_ins_ship_notification_request_code',
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
            'data_shipment_vouchers.mes_lis_shi_tot_fre_unit_weight_total',
            // data_shipment_items
            'data_shipment_items.mes_lis_shi_lin_lin_line_number',
            'data_shipment_items.mes_lis_shi_lin_lin_additional_line_number',
            'data_shipment_items.mes_lis_shi_lin_fre_trade_number',
            'data_shipment_items.mes_lis_shi_lin_fre_line_number',
            'data_shipment_items.mes_lis_shi_lin_goo_minor_category',
            'data_shipment_items.mes_lis_shi_lin_goo_detailed_category',
            'data_shipment_items.mes_lis_shi_lin_ite_scheduled_date',
            'data_shipment_items.mes_lis_shi_lin_ite_deadline_date',
            'data_shipment_items.mes_lis_shi_lin_ite_center_delivery_instruction_code',
            'data_shipment_items.mes_lis_shi_lin_ite_maker_code',
            'data_shipment_items.mes_lis_shi_lin_ite_gtin',
            'data_shipment_items.mes_lis_shi_lin_ite_order_item_code',
            'data_shipment_items.mes_lis_shi_lin_ite_code_type',
            'data_shipment_items.mes_lis_shi_lin_ite_supplier_item_code',
            'data_shipment_items.mes_lis_shi_lin_ite_name',
            'data_shipment_items.mes_lis_shi_lin_ite_name_sbcs',
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
            'data_shipment_items.mes_lis_shi_lin_fre_unit_weight',
            'data_shipment_items.mes_lis_shi_lin_fre_unit_weight_code',
            'data_shipment_items.mes_lis_shi_lin_fre_item_weight',
            'data_shipment_items.mes_lis_shi_lin_fre_order_weight',
            // data_shipment_item_details
            'data_shipment_item_details.mes_lis_shi_lin_pac_itf_code',
            'data_shipment_item_details.mes_lis_shi_lin_pac_package_indicator',
            'data_shipment_item_details.mes_lis_shi_lin_pac_number_of_packages',
            'data_shipment_item_details.mes_lis_shi_lin_pac_con_sell_by_date',
            'data_shipment_item_details.mes_lis_shi_lin_pac_con_production_date',
            'data_shipment_item_details.mes_lis_shi_lin_pac_con_lot_number'
            )
        ->join('data_shipment_vouchers','data_shipment_vouchers.data_shipment_id','=','data_shipments.data_shipment_id')
        ->join('data_shipment_items','data_shipment_vouchers.data_shipment_voucher_id','=','data_shipment_items.data_shipment_voucher_id')
        ->join('data_shipment_item_details','data_shipment_items.data_shipment_item_id','=','data_shipment_item_details.data_shipment_item_id')
        ->where('data_shipment_vouchers.decision_datetime','!=',null)
        ->where('data_shipments.data_order_id',$data_order_id)
        // filtering
        ->where('data_shipment_vouchers.mes_lis_shi_log_del_delivery_service_code', $order_info['mes_lis_shi_log_del_delivery_service_code'])
        ->where('data_shipment_vouchers.mes_lis_shi_par_sel_code', $order_info['mes_lis_shi_par_sel_code'])
        ->where('data_shipment_vouchers.mes_lis_shi_par_sel_name', $order_info['mes_lis_shi_par_sel_name'])
        ->where('data_shipment_vouchers.mes_lis_shi_tra_dat_delivery_date', $order_info['mes_lis_shi_tra_dat_delivery_date'])
        ->where('data_shipment_vouchers.mes_lis_shi_tra_goo_major_category', $order_info['mes_lis_shi_tra_goo_major_category'])
        ->where('data_shipment_vouchers.mes_lis_shi_tra_ins_temperature_code', $order_info['mes_lis_shi_tra_ins_temperature_code'])
        // receive_datetime not found in shipment tables
        // filtering
        ->orderBy("data_shipments.data_shipment_id");
        // if ($order_info->mes_lis_shi_log_del_delivery_service_code) {
        //     $csv_data->where('data_shipment_vouchers.mes_lis_shi_log_del_delivery_service_code', $order_info->mes_lis_shi_log_del_delivery_service_code);
        // }
        // ->get();

        // 検索
        // $csv_data = $csv_data->limit(100000)->get()->toArray();
        return $csv_data;
    }
    public static function shipmentCsvHeading(){
        return [
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
            // data_shipment_vouchers
            'mes_lis_shi_tra_trade_number',
            'mes_lis_shi_tra_additional_trade_number',
            'mes_lis_shi_par_shi_code',
            'mes_lis_shi_par_shi_gln',
            'mes_lis_shi_par_shi_name',
            'mes_lis_shi_par_shi_name_sbcs',
            'mes_lis_shi_par_rec_code',
            'mes_lis_shi_par_rec_gln',
            'mes_lis_shi_par_rec_name',
            'mes_lis_shi_par_rec_name_sbcs',
            'mes_lis_shi_par_tra_code',
            'mes_lis_shi_par_tra_gln',
            'mes_lis_shi_par_tra_name',
            'mes_lis_shi_par_tra_name_sbcs',
            'mes_lis_shi_par_dis_code',
            'mes_lis_shi_par_dis_name',
            'mes_lis_shi_par_dis_name_sbcs',
            'mes_lis_shi_par_pay_code',
            'mes_lis_shi_par_pay_gln',
            'mes_lis_shi_par_pay_name',
            'mes_lis_shi_par_pay_name_sbcs',
            'mes_lis_shi_par_sel_code',
            'mes_lis_shi_par_sel_gln',
            'mes_lis_shi_par_sel_name',
            'mes_lis_shi_par_sel_name_sbcs',
            'mes_lis_shi_par_sel_branch_number',
            'mes_lis_shi_par_sel_ship_location_code',
            'mes_lis_shi_log_shi_gln',
            'mes_lis_shi_log_del_route_code',
            'mes_lis_shi_log_del_delivery_service_code',
            'mes_lis_shi_log_del_stock_transfer_code',
            'mes_lis_shi_log_del_delivery_code',
            'mes_lis_shi_log_del_delivery_time',
            'mes_lis_shi_log_del_transportation_code',
            'mes_lis_shi_log_log_barcode_print',
            'mes_lis_shi_log_log_category_name_print1',
            'mes_lis_shi_log_log_category_name_print2',
            'mes_lis_shi_log_log_receiver_abbr_name',
            'mes_lis_shi_log_log_text',
            'mes_lis_shi_log_log_text_sbcs',
            'mes_lis_shi_tra_goo_major_category',
            'mes_lis_shi_tra_goo_sub_major_category',
            'mes_lis_shi_tra_dat_order_date',
            'mes_lis_shi_tra_dat_delivery_date',
            'mes_lis_shi_tra_dat_delivery_date_to_receiver',
            'mes_lis_shi_tra_dat_transfer_of_ownership_date',
            'mes_lis_shi_tra_dat_campaign_start_date',
            'mes_lis_shi_tra_dat_campaign_end_date',
            'mes_lis_shi_tra_ins_goods_classification_code',
            'mes_lis_shi_tra_ins_order_classification_code',
            'mes_lis_shi_tra_ins_ship_notification_request_code',
            'mes_lis_shi_tra_ins_private_brand_code',
            'mes_lis_shi_tra_ins_temperature_code',
            'mes_lis_shi_tra_ins_liquor_code',
            'mes_lis_shi_tra_ins_trade_type_code',
            'mes_lis_shi_tra_ins_paper_form_less_code',
            'mes_lis_shi_tra_fre_trade_number_request_code',
            'mes_lis_shi_tra_fre_package_code',
            'mes_lis_shi_tra_fre_variable_measure_item_code',
            'mes_lis_shi_tra_tax_tax_type_code',
            'mes_lis_shi_tra_tax_tax_rate',
            'mes_lis_shi_tra_not_text',
            'mes_lis_shi_tra_not_text_sbcs',
            'mes_lis_shi_tot_tot_net_price_total',
            'mes_lis_shi_tot_tot_selling_price_total',
            'mes_lis_shi_tot_tot_tax_total',
            'mes_lis_shi_tot_tot_item_total',
            'mes_lis_shi_tot_tot_unit_total',
            'mes_lis_shi_tot_fre_unit_weight_total',
            // data_shipment_items
            'mes_lis_shi_lin_lin_line_number',
            'mes_lis_shi_lin_lin_additional_line_number',
            'mes_lis_shi_lin_fre_trade_number',
            'mes_lis_shi_lin_fre_line_number',
            'mes_lis_shi_lin_goo_minor_category',
            'mes_lis_shi_lin_goo_detailed_category',
            'mes_lis_shi_lin_ite_scheduled_date',
            'mes_lis_shi_lin_ite_deadline_date',
            'mes_lis_shi_lin_ite_center_delivery_instruction_code',
            'mes_lis_shi_lin_ite_maker_code',
            'mes_lis_shi_lin_ite_gtin',
            'mes_lis_shi_lin_ite_order_item_code',
            'mes_lis_shi_lin_ite_code_type',
            'mes_lis_shi_lin_ite_supplier_item_code',
            'mes_lis_shi_lin_ite_name',
            'mes_lis_shi_lin_ite_name_sbcs',
            'mes_lis_shi_lin_ite_ite_spec',
            'mes_lis_shi_lin_ite_ite_spec_sbcs',
            'mes_lis_shi_lin_ite_col_color_code',
            'mes_lis_shi_lin_ite_col_description',
            'mes_lis_shi_lin_ite_col_description_sbcs',
            'mes_lis_shi_lin_ite_siz_size_code',
            'mes_lis_shi_lin_ite_siz_description',
            'mes_lis_shi_lin_ite_siz_description_sbcs',
            'mes_lis_shi_lin_fre_packing_quantity',
            'mes_lis_shi_lin_fre_prefecture_code',
            'mes_lis_shi_lin_fre_country_code',
            'mes_lis_shi_lin_fre_field_name',
            'mes_lis_shi_lin_fre_water_area_code',
            'mes_lis_shi_lin_fre_water_area_name',
            'mes_lis_shi_lin_fre_area_of_origin',
            'mes_lis_shi_lin_fre_item_grade',
            'mes_lis_shi_lin_fre_item_class',
            'mes_lis_shi_lin_fre_brand',
            'mes_lis_shi_lin_fre_item_pr',
            'mes_lis_shi_lin_fre_bio_code',
            'mes_lis_shi_lin_fre_breed_code',
            'mes_lis_shi_lin_fre_cultivation_code',
            'mes_lis_shi_lin_fre_defrost_code',
            'mes_lis_shi_lin_fre_item_preservation_code',
            'mes_lis_shi_lin_fre_item_shape_code',
            'mes_lis_shi_lin_fre_use',
            'mes_lis_shi_lin_sta_statutory_classification_code',
            'mes_lis_shi_lin_amo_item_net_price',
            'mes_lis_shi_lin_amo_item_net_price_unit_price',
            'mes_lis_shi_lin_amo_item_selling_price',
            'mes_lis_shi_lin_amo_item_selling_price_unit_price',
            'mes_lis_shi_lin_amo_item_tax',
            'mes_lis_shi_lin_qua_unit_multiple',
            'mes_lis_shi_lin_qua_unit_of_measure',
            'mes_lis_shi_lin_qua_package_indicator',
            'mes_lis_shi_lin_qua_ord_quantity',
            'mes_lis_shi_lin_qua_ord_num_of_order_units',
            'mes_lis_shi_lin_fre_unit_weight',
            'mes_lis_shi_lin_fre_unit_weight_code',
            'mes_lis_shi_lin_fre_item_weight',
            'mes_lis_shi_lin_fre_order_weight',
            // data_shipment_item_details
            'mes_lis_shi_lin_pac_itf_code',
            'mes_lis_shi_lin_pac_package_indicator',
            'mes_lis_shi_lin_pac_number_of_packages',
            'mes_lis_shi_lin_pac_con_sell_by_date',
            'mes_lis_shi_lin_pac_con_production_date',
            'mes_lis_shi_lin_pac_con_lot_number',
        ];
    }


}
