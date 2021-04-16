<?php

namespace App\Http\Controllers\API\DATA;

// use DB;
use Session;
use App\Http\Controllers\Controller;
use App\Models\DATA\ORD\data_order;
use App\Models\DATA\SHIPMENT\data_shipment;
use App\Models\DATA\SHIPMENT\data_shipment_voucher;
use App\Models\DATA\SHIPMENT\data_shipment_item;
use App\Http\Controllers\API\AllUsedFunction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Data_Controller extends Controller
{
    private $all_functions;
    public function __construct()
    {
        $this->all_functions = new AllUsedFunction();
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

        $request_all=$request->all();
        // \Log::info($request_all);
        $sort_by=$request->sort_by?$request->sort_by:$request->form_search['sort_by'];
        $sort_type=$request->sort_type?$request->sort_type:$request->form_search['sort_type'];
        // \Log::info($sort_by);
        // \Log::info($sort_type);
        // \Log::info($request_all);

        $csv_data=data_shipment::select(
            // data_shipments
            'data_shipments.sta_sen_identifier', //0
            'data_shipments.sta_sen_ide_authority', //1
            'data_shipments.sta_rec_identifier', //2
            'data_shipments.sta_rec_ide_authority', //3
            'data_shipments.sta_doc_standard', //4
            'data_shipments.sta_doc_type_version', //5
            'data_shipments.sta_doc_instance_identifier', //6
            'data_shipments.sta_doc_type', //7
            'data_shipments.sta_doc_creation_date_and_time', //8
            'data_shipments.mes_ent_unique_creator_identification', //9
            'data_shipments.mes_lis_pay_code', //10
            'data_shipments.mes_lis_pay_gln', //11
            'data_shipments.mes_lis_buy_code', //12
            'data_shipments.mes_lis_buy_gln', //13
            'data_shipments.mes_lis_buy_name', //14
            'data_shipments.mes_lis_buy_name_sbcs', //15
            // data_shipment_vouchers
            'dsv.mes_lis_shi_tra_trade_number', //16
            'dsv.mes_lis_shi_tra_additional_trade_number', //17
            'dsv.mes_lis_shi_fre_shipment_number', //18
            'dsv.mes_lis_shi_par_shi_code', //19
            'dsv.mes_lis_shi_par_shi_gln', //20
            'dsv.mes_lis_shi_par_shi_name', //21
            'dsv.mes_lis_shi_par_shi_name_sbcs', //22
            'dsv.mes_lis_shi_par_rec_code', //23
            'dsv.mes_lis_shi_par_rec_gln', //24
            'dsv.mes_lis_shi_par_rec_name', //25
            'dsv.mes_lis_shi_par_rec_name_sbcs', //26
            'dsv.mes_lis_shi_par_tra_code', //27
            'dsv.mes_lis_shi_par_tra_gln', //28
            'dsv.mes_lis_shi_par_tra_name', //29
            'dsv.mes_lis_shi_par_tra_name_sbcs', //30
            'dsv.mes_lis_shi_par_pay_code', //31
            'dsv.mes_lis_shi_par_pay_gln', //32
            'dsv.mes_lis_shi_par_pay_name', //33
            'dsv.mes_lis_shi_par_pay_name_sbcs', //34
            'dsv.mes_lis_shi_par_sel_code', //35
            'dsv.mes_lis_shi_par_sel_gln', //36
            'dsv.mes_lis_shi_par_sel_name', //37
            'dsv.mes_lis_shi_par_sel_name_sbcs', //38
            'dsv.mes_lis_shi_par_sel_branch_number', //39
            'dsv.mes_lis_shi_par_sel_ship_location_code', //40
            'dsv.mes_lis_shi_log_shi_gln', //41
            'dsv.mes_lis_shi_log_del_route_code', //42
            'dsv.mes_lis_shi_log_del_delivery_service_code', //43
            'dsv.mes_lis_shi_log_del_stock_transfer_code', //44
            'dsv.mes_lis_shi_log_del_delivery_code', //45
            'dsv.mes_lis_shi_log_del_delivery_time', //46
            'dsv.mes_lis_shi_log_del_transportation_code', //47
            'dsv.mes_lis_shi_log_log_barcode_print', //48
            'dsv.mes_lis_shi_log_log_category_name_print1', //49
            'dsv.mes_lis_shi_log_log_category_name_print2', //50
            'dsv.mes_lis_shi_log_log_receiver_abbr_name', //51
            'dsv.mes_lis_shi_log_log_text', //52
            'dsv.mes_lis_shi_log_log_text_sbcs', //53
            'dsv.mes_lis_shi_log_maker_code_for_receiving', //54
            'dsv.mes_lis_shi_log_delivery_slip_number', //55
            'dsv.mes_lis_shi_tra_goo_major_category', //56
            'dsv.mes_lis_shi_tra_goo_sub_major_category', //57
            DB::raw('CASE
            WHEN dsv.mes_lis_shi_tra_dat_order_date="0000-00-00"
            THEN ""
            ELSE dsv.mes_lis_shi_tra_dat_order_date  END'), //58
            DB::raw('CASE
            WHEN dsv.mes_lis_shi_tra_dat_delivery_date="0000-00-00"
            THEN ""
            ELSE dsv.mes_lis_shi_tra_dat_delivery_date  END'), //59
            DB::raw('CASE
            WHEN dsv.mes_lis_shi_tra_dat_delivery_date_to_receiver="0000-00-00"
            THEN ""
            ELSE dsv.mes_lis_shi_tra_dat_delivery_date_to_receiver  END'), //60
            DB::raw('CASE
            WHEN dsv.mes_lis_shi_tra_dat_revised_delivery_date="0000-00-00"
            THEN ""
            ELSE dsv.mes_lis_shi_tra_dat_revised_delivery_date  END'), //61
            DB::raw('CASE
            WHEN dsv.mes_lis_shi_tra_dat_transfer_of_ownership_date="0000-00-00"
            THEN ""
            ELSE dsv.mes_lis_shi_tra_dat_transfer_of_ownership_date  END'), //62
            DB::raw('CASE
            WHEN dsv.mes_lis_shi_tra_dat_campaign_start_date="0000-00-00"
            THEN ""
            ELSE dsv.mes_lis_shi_tra_dat_campaign_start_date  END'), //63
            DB::raw('CASE
            WHEN dsv.mes_lis_shi_tra_dat_campaign_end_date="0000-00-00"
            THEN ""
            ELSE dsv.mes_lis_shi_tra_dat_campaign_end_date  END'), //64

            'dsv.mes_lis_shi_tra_ins_goods_classification_code', //65
            'dsv.mes_lis_shi_tra_ins_order_classification_code', //66
            'dsv.mes_lis_shi_tra_ins_ship_notification_request_code', //67

            DB::raw('CASE
            WHEN dsv.mes_lis_shi_tra_ins_eos_code=null
            THEN "01"
            WHEN dsv.mes_lis_shi_tra_ins_eos_code=""
            THEN "01"
            ELSE dsv.mes_lis_shi_tra_ins_eos_code  END'), //68

            // 'data_shipment_vouchers.mes_lis_shi_tra_ins_eos_code',
            'dsv.mes_lis_shi_tra_ins_private_brand_code', //69
            'dsv.mes_lis_shi_tra_ins_temperature_code', //70
            'dsv.mes_lis_shi_tra_ins_liquor_code', //71
            'dsv.mes_lis_shi_tra_ins_trade_type_code', //72
            'dsv.mes_lis_shi_tra_ins_paper_form_less_code', //73
            'dsv.mes_lis_shi_tra_fre_trade_number_request_code', //74
            'dsv.mes_lis_shi_tra_fre_package_code', //75
            'dsv.mes_lis_shi_tra_fre_variable_measure_item_code', //76
            'dsv.mes_lis_shi_tra_tax_tax_type_code', //77
            'dsv.mes_lis_shi_tra_tax_tax_rate', //78
            'dsv.mes_lis_shi_tra_not_text', //79
            'dsv.mes_lis_shi_tra_not_text_sbcs', //80
            'dsv.mes_lis_shi_tot_tot_net_price_total', //81
            'dsv.mes_lis_shi_tot_tot_selling_price_total', //82
            'dsv.mes_lis_shi_tot_tot_tax_total', //83
            'dsv.mes_lis_shi_tot_tot_item_total', //84
            'dsv.mes_lis_shi_tot_tot_unit_total', //85
            DB::raw('CASE
            WHEN dsv.mes_lis_shi_tot_fre_unit_weight_total=null
            THEN "0"
            WHEN dsv.mes_lis_shi_tot_fre_unit_weight_total=""
            THEN "0"
            ELSE dsv.mes_lis_shi_tot_fre_unit_weight_total  END'), //86

            // data_shipment_items
            'dsi.mes_lis_shi_lin_lin_line_number', //87
            'dsi.mes_lis_shi_lin_lin_additional_line_number', //88
            'dsi.mes_lis_shi_lin_fre_trade_number', //89
            'dsi.mes_lis_shi_lin_fre_line_number', //90
            'dsi.mes_lis_shi_lin_fre_shipment_line_number', //91
            'dsi.mes_lis_shi_lin_goo_minor_category', //92
            'dsi.mes_lis_shi_lin_goo_detailed_category', //93
            DB::raw('CASE
            WHEN dsi.mes_lis_shi_lin_ite_scheduled_date="0000-00-00"
            THEN ""
            ELSE dsi.mes_lis_shi_lin_ite_scheduled_date  END'), //94
            'dsi.mes_lis_shi_lin_ite_deadline_date', //95
            'dsi.mes_lis_shi_lin_ite_center_delivery_instruction_code', //96
            'dsi.mes_lis_shi_lin_fre_interim_price_code', //97
            'dsi.mes_lis_shi_lin_ite_maker_code', //98
            'dsi.mes_lis_shi_lin_ite_gtin', //99
            'dsi.mes_lis_shi_lin_ite_order_item_code', //100
            'dsi.mes_lis_shi_lin_ite_ord_code_type', //101
            'dsi.mes_lis_shi_lin_ite_supplier_item_code', //102
            'dsi.mes_lis_shi_lin_ite_name', //103
            'dsi.mes_lis_shi_lin_ite_name_sbcs', //104
            'dsi.mes_lis_shi_lin_fre_shipment_item_code', //105
            'dsi.mes_lis_shi_lin_ite_ite_spec', //106
            'dsi.mes_lis_shi_lin_ite_ite_spec_sbcs', //107
            'dsi.mes_lis_shi_lin_ite_col_color_code', //108
            'dsi.mes_lis_shi_lin_ite_col_description', //109
            'dsi.mes_lis_shi_lin_ite_col_description_sbcs', //110
            'dsi.mes_lis_shi_lin_ite_siz_size_code', //111
            'dsi.mes_lis_shi_lin_ite_siz_description', //112
            'dsi.mes_lis_shi_lin_ite_siz_description_sbcs', //113
            'dsi.mes_lis_shi_lin_fre_packing_quantity', //114
            'dsi.mes_lis_shi_lin_fre_prefecture_code', //115
            'dsi.mes_lis_shi_lin_fre_country_code', //116
            'dsi.mes_lis_shi_lin_fre_field_name', //117
            'dsi.mes_lis_shi_lin_fre_water_area_code', //118
            'dsi.mes_lis_shi_lin_fre_water_area_name', //119
            'dsi.mes_lis_shi_lin_fre_area_of_origin', //120
            'dsi.mes_lis_shi_lin_fre_item_grade', //121
            'dsi.mes_lis_shi_lin_fre_item_class', //122
            'dsi.mes_lis_shi_lin_fre_brand', //123
            'dsi.mes_lis_shi_lin_fre_item_pr', //124
            'dsi.mes_lis_shi_lin_fre_bio_code', //125
            'dsi.mes_lis_shi_lin_fre_breed_code', //126
            'dsi.mes_lis_shi_lin_fre_cultivation_code', //127
            'dsi.mes_lis_shi_lin_fre_defrost_code', //128
            'dsi.mes_lis_shi_lin_fre_item_preservation_code', //129
            'dsi.mes_lis_shi_lin_fre_item_shape_code', //130
            'dsi.mes_lis_shi_lin_fre_use', //131
            'dsi.mes_lis_shi_lin_sta_statutory_classification_code', //132
            'dsi.mes_lis_shi_lin_amo_item_net_price', //133
            'dsi.mes_lis_shi_lin_amo_item_net_price_unit_price', //134
            'dsi.mes_lis_shi_lin_amo_item_selling_price', //135
            'dsi.mes_lis_shi_lin_amo_item_selling_price_unit_price', //136
            'dsi.mes_lis_shi_lin_amo_item_tax', //137
            'dsi.mes_lis_shi_lin_qua_unit_multiple', //138
            'dsi.mes_lis_shi_lin_qua_unit_of_measure', //139
            'dsi.mes_lis_shi_lin_qua_package_indicator', //140
            'dsi.mes_lis_shi_lin_qua_ord_quantity', //141
            'dsi.mes_lis_shi_lin_qua_ord_num_of_order_units', // 142
            'dsi.mes_lis_shi_lin_qua_shi_quantity', //143
            'dsi.mes_lis_shi_lin_qua_shi_num_of_order_units', // 144
            'dsi.mes_lis_shi_lin_qua_sto_quantity', //145
            DB::raw('CASE
            WHEN dsi.mes_lis_shi_lin_qua_sto_num_of_order_units=null
            THEN "0"
            WHEN dsi.mes_lis_shi_lin_qua_sto_num_of_order_units=""
            THEN "0"
            ELSE dsi.mes_lis_shi_lin_qua_sto_num_of_order_units  END'), //146
            'dsi.mes_lis_shi_lin_qua_sto_reason_code', //147
            DB::raw('CASE
            WHEN dsi.mes_lis_shi_lin_fre_unit_weight=null
            THEN "0"
            WHEN dsi.mes_lis_shi_lin_fre_unit_weight=""
            THEN "0"
            ELSE dsi.mes_lis_shi_lin_fre_unit_weight  END'), //148
            // 'data_shipment_items.mes_lis_shi_lin_fre_unit_weight_code',
            DB::raw('CASE
            WHEN dsi.mes_lis_shi_lin_fre_unit_weight_code=null
            THEN "0"
            WHEN dsi.mes_lis_shi_lin_fre_unit_weight_code=""
            THEN "0"
            ELSE dsi.mes_lis_shi_lin_fre_unit_weight_code  END'), //149
            DB::raw('CASE
            WHEN dsi.mes_lis_shi_lin_fre_item_weight=null
            THEN "0"
            WHEN dsi.mes_lis_shi_lin_fre_item_weight=""
            THEN "0"
            ELSE dsi.mes_lis_shi_lin_fre_item_weight  END'), //150
            DB::raw('CASE
            WHEN dsi.mes_lis_shi_lin_fre_order_weight=null
            THEN "0"
            WHEN dsi.mes_lis_shi_lin_fre_order_weight=""
            THEN "0"
            ELSE dsi.mes_lis_shi_lin_fre_order_weight  END'), //151
            DB::raw('CASE
            WHEN dsi.mes_lis_shi_lin_fre_shipment_weight=null
            THEN "0"
            WHEN dsi.mes_lis_shi_lin_fre_shipment_weight=""
            THEN "0"
            ELSE dsi.mes_lis_shi_lin_fre_shipment_weight  END'), //152
            // data_shipment_item_details
            DB::raw('CASE
            WHEN dsid.mes_lis_shi_lin_pac_itf_code=null
            THEN "0"
            WHEN dsid.mes_lis_shi_lin_pac_itf_code=""
            THEN "0"
            ELSE dsid.mes_lis_shi_lin_pac_itf_code  END'), //153
            DB::raw('CASE
            WHEN dsid.mes_lis_shi_lin_pac_package_indicator=null
            THEN "00"
            WHEN dsid.mes_lis_shi_lin_pac_package_indicator=""
            THEN "00"
            ELSE dsid.mes_lis_shi_lin_pac_package_indicator  END'), //154
            DB::raw('CASE
            WHEN dsid.mes_lis_shi_lin_pac_number_of_packages=null
            THEN "0"
            WHEN dsid.mes_lis_shi_lin_pac_number_of_packages=""
            THEN "0"
            ELSE dsid.mes_lis_shi_lin_pac_number_of_packages  END'), //155
            'dsid.mes_lis_shi_lin_pac_con_sell_by_date', //156
            'dsid.mes_lis_shi_lin_pac_con_production_date', //157
            'dsid.mes_lis_shi_lin_pac_con_lot_number' //158
        )
        ->leftJoin('data_shipment_vouchers as dsv', 'dsv.data_shipment_id', '=', 'data_shipments.data_shipment_id')
        ->leftJoin('data_shipment_items as dsi', 'dsv.data_shipment_voucher_id', '=', 'dsi.data_shipment_voucher_id')
        ->leftJoin('data_shipment_item_details as dsid', 'dsi.data_shipment_item_id', '=', 'dsid.data_shipment_item_id')
        ->join('data_order_vouchers as dov', 'dov.data_order_voucher_id', '=', 'dsv.data_shipment_voucher_id')
        ->join('data_orders as dor', 'dor.data_order_id', '=', 'dov.data_order_id');


        // filtering
        if ((array_key_exists("order_info", $request_all))) {
            $data_order_id=$request->data_order_id;
            $order_info=$request->order_info;


            $csv_data=$csv_data->where('data_shipments.data_order_id', $data_order_id)
            ->where('dsv.mes_lis_shi_log_del_delivery_service_code', $order_info['mes_lis_shi_log_del_delivery_service_code'])
            ->where('dsv.mes_lis_shi_par_sel_code', $order_info['mes_lis_shi_par_sel_code'])
            ->where('dsv.mes_lis_shi_par_sel_name', $order_info['mes_lis_shi_par_sel_name'])
            ->where('dsv.mes_lis_shi_tra_dat_delivery_date', $order_info['mes_lis_shi_tra_dat_delivery_date'])
            ->where('dsv.mes_lis_shi_tra_goo_major_category', $order_info['mes_lis_shi_tra_goo_major_category'])
            ->where('dsv.mes_lis_shi_tra_ins_temperature_code', $order_info['mes_lis_shi_tra_ins_temperature_code']);

            if ((array_key_exists("form_search", $request_all))) {
                $form_search = $request->form_search;
                if ($form_search['mes_lis_shi_tra_trade_number']!="") {
                    $csv_data=$csv_data->where('dsv.mes_lis_shi_tra_trade_number', $form_search['mes_lis_shi_tra_trade_number']);
                }
                if ($form_search['fixedSpecial']!="*") {
                    $csv_data=$csv_data->where('dsv.mes_lis_shi_tra_ins_goods_classification_code', $form_search['fixedSpecial']);
                }
                if ($form_search['printingStatus']!="*") {
                    if ($form_search['printingStatus']=="未印刷あり") {
                        $csv_data=$csv_data->whereNull('dsv.print_datetime');
                    }
                    if ($form_search['printingStatus']=="印刷済") {
                        $csv_data=$csv_data->whereNotNull('dsv.print_datetime');
                    }
                }
                if ($form_search['situation']!="*") {
                    if ($form_search['situation']=="未確定あり") {
                        $csv_data=$csv_data->whereNull('dsv.decision_datetime');
                    }
                    if ($form_search['situation']=="確定済") {
                        $csv_data=$csv_data->whereNotNull('dsv.decision_datetime');
                    }
                }
            }
        } else {
            $receive_date_from = $request->receive_date_from;
            $receive_date_to = $request->receive_date_to;
            $delivery_date_from = $request->delivery_date_from;
            $delivery_date_to = $request->delivery_date_to;
            $receive_date_from = $receive_date_from!=null? date('Y-m-d 00:00:00', strtotime($receive_date_from)):$receive_date_from; // 受信日時開始
            $receive_date_to = $receive_date_to!=null? date('Y-m-d 23:59:59', strtotime($receive_date_to)):$receive_date_to; // 受信日時終了
            $delivery_date_from = $delivery_date_from!=null? date('Y-m-d 00:00:00', strtotime($delivery_date_from)):$delivery_date_from; // 納品日開始
            $delivery_date_to =$delivery_date_to!=null? date('Y-m-d 23:59:59', strtotime($delivery_date_to)):$delivery_date_to;
            ; // 納品日終了
            $delivery_service_code = $request->delivery_service_code; // 便
            $temperature = $request->temperature; // 配送温度区分
            $check_datetime = $request->check_datetime;
            // $check_datetime=$request->check_datetime;
            $confirmation_status = $request->confirmation_status; // 参照
            $decission_cnt = $request->decission_cnt; // 確定
            $print_cnt = $request->print_cnt; // 印刷
            $byr_category_code = $request->category_code; // 印刷
            $mes_lis_ord_par_sel_code = $request->mes_lis_ord_par_sel_code; // 印刷


            $byr_category_code = $byr_category_code['category_code'];


            if ($receive_date_from && $receive_date_to) {
                $csv_data=$csv_data->whereBetween('dor.receive_datetime', [$receive_date_from, $receive_date_to]);
            }
            if ($delivery_date_from && $delivery_date_to) {
                $csv_data=$csv_data->whereBetween('dov.mes_lis_ord_tra_dat_delivery_date', [$delivery_date_from, $delivery_date_to]);
            }
            if ($delivery_service_code!='*') {
                $csv_data=$csv_data->where('dov.mes_lis_ord_log_del_delivery_service_code', $delivery_service_code);
            }
            if ($mes_lis_ord_par_sel_code!='') {
                $csv_data=$csv_data->where('dov.mes_lis_ord_par_sel_code', $mes_lis_ord_par_sel_code);
            }

            if ($temperature!='*') {
                $csv_data=$csv_data->where('dov.mes_lis_ord_tra_ins_temperature_code', $temperature);
            }

            if ($byr_category_code!='*') {
                $csv_data=$csv_data->where('dov.mes_lis_ord_tra_goo_major_category', $byr_category_code);
            }

            if ($check_datetime!='*') {
                if ($check_datetime==1) {
                    $csv_data=$csv_data->whereNull('dov.check_datetime');
                } else {
                    $csv_data=$csv_data->whereNotNull('dov.check_datetime');
                }
            }

            if ($print_cnt == "!0") {
                $csv_data=$csv_data->having('print_cnt', '!=', '0');
            } elseif ($print_cnt != "*") {
                $csv_data=$csv_data->having('print_cnt', '=', $print_cnt);
            }
            if ($decission_cnt == "!0") {
                $csv_data=$csv_data->having('decision_cnt', '!=', '0');
            } elseif ($decission_cnt != "*") {
                $csv_data=$csv_data->having('decision_cnt', '=', $decission_cnt);
            }
            $csv_data=$csv_data->groupBy('dsv.mes_lis_shi_tra_trade_number');
        }
        // receive_datetime not found in shipment tables

        if (!(array_key_exists("downloadType", $request_all))) {
            // \Log::info("Clicked");
            $csv_data=$csv_data->whereNotNull('dsv.decision_datetime');
            $csv_data=$csv_data->whereNull('dsv.send_datetime');
        }
        // \Log::info("My Query");
        // $csv_data=$csv_data->groupBy('dsv.mes_lis_shi_tra_trade_number');
        // $csv_data=$csv_data->groupBy('dsv.data_shipment_voucher_id');
        // $csv_data=$csv_data->groupBy('dsi.data_shipment_item_id'); //New Added
        // $csv_data=$csv_data->orderBy('dsv.'.$sort_by,$sort_type);
        $csv_data=$csv_data->orderBy('dsv.mes_lis_shi_tra_trade_number', "ASC");
        $csv_data=$csv_data->orderBy('dsi.mes_lis_shi_lin_lin_line_number', "ASC");
        // 検索
        // $csv_data = $csv_data->limit(100000)->get()->toArray();
        return $csv_data;
    }

    public static function shipmentCsvHeading()
    {
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
    public function shipmentUpdateArray($data_array, $file_name="", $reason_code_list=[])
    {
        log::debug('shipmentUpdateArray start');
        // buyer_settings
        // $buyer_settings = byr_buyer::select('setting_information')->where('byr_buyer_id', Session::get('byr_buyer_id'))->first();

        // $byr_setting = json_decode($buyer_settings->setting_information, true);
        // // \log::info($byr_setting);
        // $reason_code_list = $byr_setting['shipments']['mes_lis_shi_lin_qua_sto_reason_code'];

        $net_price_total=0;
        $selling_price_total=0;
        $tax_total=0;
        $item_total=0;
        $unit_total=0;

        $trade_number='';
        DB::beginTransaction();
        try {
            foreach ($data_array as $key => $value) {
                $shipment_item_array=array();

                // line number
                $line_number = $value[87];

                // data_shipment_voucher情報取得
                if ($trade_number !== $value[16]) {
                    if ($trade_number !== '') {
                        // voucher 更新
                        // $dsv_query->update($shipment_voucher_array);
                        // 値初期化
                        $net_price_total = 0;       // 原価金額合計
                        $selling_price_total = 0;   // 売価金額合計
                        $tax_total = 0;             // 税額合計
                        $item_total = 0;            // 数量合計
                        $unit_total = 0;            // 発注単位数量合計
                    }
                    $trade_number = $value[16];     // 伝票番号
                    $order_date = $value[58];       // 発注日
                    $dsv_query=data_shipment_voucher::where('mes_lis_shi_tra_trade_number', $trade_number)
                        ->where('mes_lis_shi_tra_dat_order_date', $order_date);
                    $data_shipment_voucher_info=$dsv_query->first();
                    if (empty($data_shipment_voucher_info)) {
                        // 取得無しエラー
                        Log::error('Can not get data_shipment_voucher information:'.$dsv_query->toSql());
                        return response()->json(['status'=>0,'message'=>'対象データがありません。[伝票番号]'.$trade_number.' [発注日]'.$order_date]);
                    }
                }

                // decision_datetime check
                if (!empty($data_shipment_voucher_info->decision_datetime)) {
                    // 確定済み
                    Log::debug('Already decision:[trade_number]'.$trade_number.' [line_number]'.$line_number);
                    continue;
                }

                // data_shipment_item情報取得
                $dsi_query = data_shipment_item::where('data_shipment_voucher_id', $data_shipment_voucher_info->data_shipment_voucher_id)
                    ->where('mes_lis_shi_lin_lin_line_number', $line_number);
                $data_shipment_item_info=$dsi_query->first();
                if (empty($data_shipment_item_info)) {
                    // 取得無しエラー
                    Log::error('Can not get data_shipment_items information:'.$dsi_query->toSql());
                    return response()->json(['status'=>0,'message'=>'対象データがありません。[伝票番号]'.$trade_number.' [明細番号]'.$line_number]);
                }

                // data set from db
                $net_price_unit_price = $data_shipment_item_info->mes_lis_shi_lin_amo_item_net_price_unit_price;            // 原単価
                $selling_price_unit_price = $data_shipment_item_info->mes_lis_shi_lin_amo_item_selling_price_unit_price;    // 売単価
                $ord_quantity = $data_shipment_item_info->mes_lis_shi_lin_qua_ord_quantity;                                 // 発注数量(バラ)
                $ord_num_of_order_units = $data_shipment_item_info->mes_lis_shi_lin_qua_ord_num_of_order_units;             // 発注数量(単位)
                $unit_multiple = $data_shipment_item_info->mes_lis_shi_lin_qua_unit_multiple;                               // 発注単位
                $tax_rate = $data_shipment_voucher_info->mes_lis_shi_tra_tax_tax_rate;                                      // 税率

                // data set from csv
                $revised_delivery_date = $value[61];                                                                // 訂正後直接納品先納品日
                $shi_num_of_order_units = $value[144];                                                              // 出荷数量(単位)
                $sto_reason_code = $value[147];                                                                     // 欠品理由

                // data check validation
                // - shi_num_of_order_units
                // -- number check
                if (!is_numeric($shi_num_of_order_units)) {
                    // 数値以外
                    Log::error('not number:[shi_num_of_order_units]:'.$shi_num_of_order_units);
                    return response()->json(['status'=>0,'message'=>'対象データ不正です。:[出荷数量(単位)]:'.$shi_num_of_order_units.' [伝票番号]'.$trade_number.' [明細番号]'.$line_number]);
                }
                // -- max check
                if ((0 > $shi_num_of_order_units) || ($shi_num_of_order_units > $ord_num_of_order_units)) {
                    // しきい値
                    Log::error('not between number:'.'[ord_num_of_order_units]:'.$ord_num_of_order_units.' [shi_num_of_order_units]:'.$shi_num_of_order_units);
                    return response()->json(['status'=>0,'message'=>'対象データが許容外です。:[出荷数量(単位)]:'.$shi_num_of_order_units.' [発注数量(単位)]'.$ord_num_of_order_units.' [伝票番号]'.$trade_number.' [明細番号]'.$line_number]);
                }


                // - sto_reason_code
                // -- json data check
                if (!array_key_exists($sto_reason_code, $reason_code_list)) {
                    //
                    Log::error('not correct reason_code:[sto_reason_code]:'.$sto_reason_code);
                    return response()->json(['status'=>0,'message'=>'対象データ不正です。<br>:[欠品理由]:'.$sto_reason_code.' [伝票番号]'.$trade_number.' [明細番号]'.$line_number]);
                }

                // -- shi_num_of_order_units check
                if (($ord_num_of_order_units != $shi_num_of_order_units) && ($sto_reason_code == '00')) {
                    // 欠品理由無し
                    Log::error('not reason_code:'.'[sto_reason_code]:'.$sto_reason_code);
                    return response()->json(['status'=>0,'message'=>'欠品理由が選択されていません。:[欠品理由]:'.$sto_reason_code.' [伝票番号]'.$trade_number.' [明細番号]'.$line_number]);
                } elseif (($ord_num_of_order_units == $shi_num_of_order_units) && ($sto_reason_code != '00')) {
                    // 欠品理由不正
                    Log::error('not reason_code:'.'[sto_reason_code]:'.$sto_reason_code);
                    return response()->json(['status'=>0,'message'=>'欠品理由が不正です。:[欠品理由]:'.$sto_reason_code.' [伝票番号]'.$trade_number.' [明細番号]'.$line_number]);
                }

                // - mes_lis_shi_tra_dat_revised_delivery_date
                // -- date format check
                if (!empty($revised_delivery_date)) {
                    // date check
                    $date_temp = explode('-', $revised_delivery_date);
                    // \log::debug($date_temp);
                    if ((count($date_temp) !== 3)||
                        ((count($date_temp) === 3)&&(!checkdate($date_temp[1], $date_temp[2], $date_temp[0])))) {
                        // date check
                        Log::error('not correct revised_delivery_date:'.'[revised_delivery_date]:'.$revised_delivery_date);
                        return response()->json(['status'=>0,'message'=>'対象データ不正です。:[訂正後直接納品先納品日]:'.$revised_delivery_date.' [伝票番号]'.$trade_number.' [明細番号]'.$line_number]);
                    }
                    // -- order_date check
                    if (strtotime($revised_delivery_date) < strtotime($order_date)) {
                        // 発注日より過去は指定できない
                        Log::error('can not use revised_delivery_date before order date:'.'[revised_delivery_date]:'.$revised_delivery_date);
                        return response()->json(['status'=>0,'message'=>'発注日より過去は指定できません。:[訂正後直接納品先納品日]:'.$revised_delivery_date.' [発注日]'.$order_date.' [伝票番号]'.$trade_number.' [明細番号]'.$line_number]);
                    }
                }

                $shi_quantity = $unit_multiple * $shi_num_of_order_units;                       // 出荷数量(バラ)
                $sto_quantity = $ord_quantity - $shi_quantity;                                  // 欠品数量(バラ)
                $sto_num_of_order_units = $ord_num_of_order_units - $shi_num_of_order_units;    // 欠品数量(単位)
                $net_price = $shi_quantity * $net_price_unit_price;                             // 原価金額
                $selling_price = $shi_quantity * $selling_price_unit_price;                     // 売価金額
                $tax = $net_price * $tax_rate / 100;                                            // 税額

                $net_price_total += $net_price;             // 原価金額合計
                $selling_price_total += $selling_price;     // 売価金額合計
                $tax_total += $tax;                         // 税額合計
                $item_total += $shi_quantity;               // 数量合計
                $unit_total += $shi_num_of_order_units;     // 発注単位数量合計

                $shipment_item_array['mes_lis_shi_lin_amo_item_net_price']=$net_price;
                $shipment_item_array['mes_lis_shi_lin_amo_item_selling_price']=$selling_price;
                $shipment_item_array['mes_lis_shi_lin_amo_item_tax']=$tax;
                $shipment_item_array['mes_lis_shi_lin_qua_shi_quantity']=$shi_quantity;
                $shipment_item_array['mes_lis_shi_lin_qua_shi_num_of_order_units']=$shi_num_of_order_units;
                $shipment_item_array['mes_lis_shi_lin_qua_sto_quantity']=$sto_quantity;
                $shipment_item_array['mes_lis_shi_lin_qua_sto_num_of_order_units']=$sto_num_of_order_units;
                $shipment_item_array['mes_lis_shi_lin_qua_sto_reason_code']=$sto_reason_code;

                // data_shipment_items update
                $dsi_query->update($shipment_item_array);

                // update shipment_vouchers
                $shipment_voucher_array['mes_lis_shi_tra_dat_revised_delivery_date']=$revised_delivery_date;
                $shipment_voucher_array['mes_lis_shi_tot_tot_net_price_total']=$net_price_total;
                $shipment_voucher_array['mes_lis_shi_tot_tot_selling_price_total']=$selling_price_total;
                $shipment_voucher_array['mes_lis_shi_tot_tot_tax_total']=$tax_total;
                $shipment_voucher_array['mes_lis_shi_tot_tot_item_total']=$item_total;
                $shipment_voucher_array['mes_lis_shi_tot_tot_unit_total']=$unit_total;
            }



            // voucher 更新
            if (isset($shipment_voucher_array)) {
                $dsv_query->update($shipment_voucher_array);
                // udpate shipments
                $shipment_array['upload_datetime']=date('y-m-d H:i:s');
                $shipment_array['upload_file_path']=$file_name;
                $data_shipment_id=$data_shipment_voucher_info->data_shipment_id;
                data_shipment::where('data_shipment_id', $data_shipment_id)->update($shipment_array);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            log::error($e);
            return response()->json(['message' => $e, 'status' => 0]);
            // something went wrong
        }

        log::debug('shipmentUpdateArray end');
        return response()->json(['message'=>"Success",'status'=>1]);
    }
}
