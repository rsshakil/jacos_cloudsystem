<?php

namespace App\Http\Controllers\API\BYR\DATA\SHIPMENT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\DATA\ORD\data_order;
use App\Models\DATA\SHIPMENT\data_shipment;

class DataController extends Controller
{
    public static function get_shipment_data($request)
    {
        Log::debug(__METHOD__.':start---');

        // 対象データ取得

        // $request_all=$request->all();
        // $all_used_fun = new AllUsedFunction();
        // // \Log::info($request_all);
        // $sort_by=$request->sort_by;
        // $sort_type=$request->sort_type;
        // $adm_user_id=$request->adm_user_id;
        // $byr_buyer_id=$request->byr_buyer_id;
        $data_order_id=$request->data_order_id;
        // $slr_seller_id = Auth::User()->SlrInfo->slr_seller_id;
        // $authUser = User::find($adm_user_id);
        // $cmn_connect_id = '';
        // if (!$authUser->hasRole(config('const.adm_role_name'))) {
        //     $cmn_company_info=$all_used_fun->get_user_info($adm_user_id, $byr_buyer_id);
        //     $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        // }
        $byr_buyer_id =Auth::User()->ByrInfo->byr_buyer_id;
        $csv_data=data_shipment::select(
            // data_shipments
            'data_shipments.sta_sen_identifier', //0
            'data_shipments.sta_sen_ide_authority', //1
            'data_shipments.sta_rec_identifier', //2
            'data_shipments.sta_rec_ide_authority', //3
            'data_shipments.sta_doc_standard', //4
            'data_shipments.sta_doc_type_version', //5
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
            'dsv.mes_lis_shi_tra_trade_number',
            'dsv.mes_lis_shi_tra_additional_trade_number',
            'dsv.mes_lis_shi_fre_shipment_number',
            'dsv.mes_lis_shi_par_shi_code',
            'dsv.mes_lis_shi_par_shi_gln',
            'dsv.mes_lis_shi_par_shi_name',
            'dsv.mes_lis_shi_par_shi_name_sbcs',
            'dsv.mes_lis_shi_par_rec_code',
            'dsv.mes_lis_shi_par_rec_gln',
            'dsv.mes_lis_shi_par_rec_name',
            'dsv.mes_lis_shi_par_rec_name_sbcs',
            'dsv.mes_lis_shi_par_tra_code',
            'dsv.mes_lis_shi_par_tra_gln',
            'dsv.mes_lis_shi_par_tra_name',
            'dsv.mes_lis_shi_par_tra_name_sbcs',
            'dsv.mes_lis_shi_par_dis_code',
            'dsv.mes_lis_shi_par_dis_name',
            'dsv.mes_lis_shi_par_dis_name_sbcs',
            'dsv.mes_lis_shi_par_pay_code',
            'dsv.mes_lis_shi_par_pay_gln',
            'dsv.mes_lis_shi_par_pay_name',
            'dsv.mes_lis_shi_par_pay_name_sbcs',
            'dsv.mes_lis_shi_par_sel_code',
            'dsv.mes_lis_shi_par_sel_gln',
            'dsv.mes_lis_shi_par_sel_name',
            'dsv.mes_lis_shi_par_sel_name_sbcs',
            'dsv.mes_lis_shi_par_sel_branch_number',
            'dsv.mes_lis_shi_par_sel_ship_location_code',
            'dsv.mes_lis_shi_log_shi_gln',
            'dsv.mes_lis_shi_log_del_route_code',
            'dsv.mes_lis_shi_log_del_delivery_service_code',
            'dsv.mes_lis_shi_log_del_stock_transfer_code',
            'dsv.mes_lis_shi_log_del_delivery_code',
            'dsv.mes_lis_shi_log_del_delivery_time',
            'dsv.mes_lis_shi_log_del_transportation_code',
            'dsv.mes_lis_shi_log_log_barcode_print',
            'dsv.mes_lis_shi_log_log_category_name_print1',
            'dsv.mes_lis_shi_log_log_category_name_print2',
            'dsv.mes_lis_shi_log_log_receiver_abbr_name',
            'dsv.mes_lis_shi_log_log_text',
            'dsv.mes_lis_shi_log_log_text_sbcs',
            'dsv.mes_lis_shi_log_maker_code_for_receiving',
            'dsv.mes_lis_shi_log_delivery_slip_number',
            'dsv.mes_lis_shi_tra_goo_major_category',
            'dsv.mes_lis_shi_tra_goo_sub_major_category',
            DB::raw('CASE WHEN dsv.mes_lis_shi_tra_dat_order_date="0000-00-00" THEN "" ELSE dsv.mes_lis_shi_tra_dat_order_date  END as mes_lis_shi_tra_dat_order_date'), //58
            DB::raw('CASE WHEN dsv.mes_lis_shi_tra_dat_delivery_date="0000-00-00" THEN "" ELSE dsv.mes_lis_shi_tra_dat_delivery_date  END as mes_lis_shi_tra_dat_delivery_date'), //59
            DB::raw('CASE WHEN dsv.mes_lis_shi_tra_dat_delivery_date_to_receiver="0000-00-00" THEN "" ELSE dsv.mes_lis_shi_tra_dat_delivery_date_to_receiver  END as mes_lis_shi_tra_dat_delivery_date_to_receiver'), //60
            DB::raw('CASE WHEN dsv.mes_lis_shi_tra_dat_revised_delivery_date="0000-00-00" THEN "" ELSE dsv.mes_lis_shi_tra_dat_revised_delivery_date  END as mes_lis_shi_tra_dat_revised_delivery_date'), //61
            DB::raw('CASE WHEN dsv.mes_lis_shi_tra_dat_transfer_of_ownership_date="0000-00-00" THEN "" ELSE dsv.mes_lis_shi_tra_dat_transfer_of_ownership_date  END as mes_lis_shi_tra_dat_transfer_of_ownership_date'), //62
            DB::raw('CASE WHEN dsv.mes_lis_shi_tra_dat_campaign_start_date="0000-00-00" THEN "" ELSE dsv.mes_lis_shi_tra_dat_campaign_start_date  END as mes_lis_shi_tra_dat_campaign_start_date'), //63
            DB::raw('CASE WHEN dsv.mes_lis_shi_tra_dat_campaign_end_date="0000-00-00" THEN "" ELSE dsv.mes_lis_shi_tra_dat_campaign_end_date  END as mes_lis_shi_tra_dat_campaign_end_date'), //64
            'dsv.mes_lis_shi_tra_ins_goods_classification_code',
            'dsv.mes_lis_shi_tra_ins_order_classification_code',
            'dsv.mes_lis_shi_tra_ins_ship_notification_request_code',
            DB::raw('CASE WHEN dsv.mes_lis_shi_tra_ins_eos_code=null THEN "01" WHEN dsv.mes_lis_shi_tra_ins_eos_code="" THEN "01" ELSE dsv.mes_lis_shi_tra_ins_eos_code  END as mes_lis_shi_tra_ins_eos_code'), //68
            'dsv.mes_lis_shi_tra_ins_private_brand_code',
            'dsv.mes_lis_shi_tra_ins_temperature_code',
            'dsv.mes_lis_shi_tra_ins_liquor_code',
            'dsv.mes_lis_shi_tra_ins_trade_type_code',
            'dsv.mes_lis_shi_tra_ins_paper_form_less_code',
            'dsv.mes_lis_shi_tra_fre_trade_number_request_code',
            'dsv.mes_lis_shi_tra_fre_package_code',
            'dsv.mes_lis_shi_tra_fre_variable_measure_item_code',
            'dsv.mes_lis_shi_tra_tax_tax_type_code',
            'dsv.mes_lis_shi_tra_tax_tax_rate',
            'dsv.mes_lis_shi_tra_not_text',
            'dsv.mes_lis_shi_tra_not_text_sbcs',
            'dsv.mes_lis_shi_tot_tot_net_price_total',
            'dsv.mes_lis_shi_tot_tot_selling_price_total',
            'dsv.mes_lis_shi_tot_tot_tax_total',
            'dsv.mes_lis_shi_tot_tot_item_total',
            'dsv.mes_lis_shi_tot_tot_unit_total',
            DB::raw('CASE WHEN dsv.mes_lis_shi_tot_fre_unit_weight_total=null THEN "0" WHEN dsv.mes_lis_shi_tot_fre_unit_weight_total="" THEN "0" ELSE dsv.mes_lis_shi_tot_fre_unit_weight_total  END as mes_lis_shi_tot_fre_unit_weight_total'), //86
            // data_shipment_items
            'dsi.mes_lis_shi_lin_lin_line_number',
            'dsi.mes_lis_shi_lin_lin_additional_line_number',
            'dsi.mes_lis_shi_lin_fre_trade_number',
            'dsi.mes_lis_shi_lin_fre_line_number',
            'dsi.mes_lis_shi_lin_fre_shipment_line_number',
            'dsi.mes_lis_shi_lin_goo_minor_category',
            'dsi.mes_lis_shi_lin_goo_detailed_category',
            DB::raw('CASE WHEN dsi.mes_lis_shi_lin_ite_scheduled_date="0000-00-00" THEN "" ELSE dsi.mes_lis_shi_lin_ite_scheduled_date  END as mes_lis_shi_lin_ite_scheduled_date'), //94
            DB::raw('CASE WHEN dsi.mes_lis_shi_lin_ite_deadline_date="0000-00-00" THEN "" ELSE dsi.mes_lis_shi_lin_ite_deadline_date  END as mes_lis_shi_lin_ite_deadline_date'),   //95
            'dsi.mes_lis_shi_lin_ite_center_delivery_instruction_code',
            'dsi.mes_lis_shi_lin_fre_interim_price_code',
            'dsi.mes_lis_shi_lin_ite_maker_code',
            'dsi.mes_lis_shi_lin_ite_gtin',
            'dsi.mes_lis_shi_lin_ite_order_item_code',
            'dsi.mes_lis_shi_lin_ite_ord_code_type',
            'dsi.mes_lis_shi_lin_ite_supplier_item_code',
            'dsi.mes_lis_shi_lin_ite_name',
            'dsi.mes_lis_shi_lin_ite_name_sbcs',
            'dsi.mes_lis_shi_lin_fre_shipment_item_code',
            'dsi.mes_lis_shi_lin_ite_ite_spec',
            'dsi.mes_lis_shi_lin_ite_ite_spec_sbcs',
            'dsi.mes_lis_shi_lin_ite_col_color_code',
            'dsi.mes_lis_shi_lin_ite_col_description',
            'dsi.mes_lis_shi_lin_ite_col_description_sbcs',
            'dsi.mes_lis_shi_lin_ite_siz_size_code',
            'dsi.mes_lis_shi_lin_ite_siz_description',
            'dsi.mes_lis_shi_lin_ite_siz_description_sbcs',
            'dsi.mes_lis_shi_lin_fre_packing_quantity',
            'dsi.mes_lis_shi_lin_fre_prefecture_code',
            'dsi.mes_lis_shi_lin_fre_country_code',
            'dsi.mes_lis_shi_lin_fre_field_name',
            'dsi.mes_lis_shi_lin_fre_water_area_code',
            'dsi.mes_lis_shi_lin_fre_water_area_name',
            'dsi.mes_lis_shi_lin_fre_area_of_origin',
            'dsi.mes_lis_shi_lin_fre_item_grade',
            'dsi.mes_lis_shi_lin_fre_item_class',
            'dsi.mes_lis_shi_lin_fre_brand',
            'dsi.mes_lis_shi_lin_fre_item_pr',
            'dsi.mes_lis_shi_lin_fre_bio_code',
            'dsi.mes_lis_shi_lin_fre_breed_code',
            'dsi.mes_lis_shi_lin_fre_cultivation_code',
            'dsi.mes_lis_shi_lin_fre_defrost_code',
            'dsi.mes_lis_shi_lin_fre_item_preservation_code',
            'dsi.mes_lis_shi_lin_fre_item_shape_code',
            'dsi.mes_lis_shi_lin_fre_use',
            'dsi.mes_lis_shi_lin_sta_statutory_classification_code',
            'dsi.mes_lis_shi_lin_amo_item_net_price',
            'dsi.mes_lis_shi_lin_amo_item_net_price_unit_price',
            'dsi.mes_lis_shi_lin_amo_item_selling_price',
            'dsi.mes_lis_shi_lin_amo_item_selling_price_unit_price',
            'dsi.mes_lis_shi_lin_amo_item_tax',
            'dsi.mes_lis_shi_lin_qua_unit_multiple',
            'dsi.mes_lis_shi_lin_qua_unit_of_measure',
            'dsi.mes_lis_shi_lin_qua_package_indicator',
            'dsi.mes_lis_shi_lin_qua_ord_quantity',
            'dsi.mes_lis_shi_lin_qua_ord_num_of_order_units',
            'dsi.mes_lis_shi_lin_qua_shi_quantity',
            'dsi.mes_lis_shi_lin_qua_shi_num_of_order_units',
            'dsi.mes_lis_shi_lin_qua_sto_quantity',
            DB::raw('CASE WHEN dsi.mes_lis_shi_lin_qua_sto_num_of_order_units=null THEN "0" WHEN dsi.mes_lis_shi_lin_qua_sto_num_of_order_units="" THEN "0" ELSE dsi.mes_lis_shi_lin_qua_sto_num_of_order_units  END as mes_lis_shi_lin_qua_sto_num_of_order_units'), //146
            'dsi.mes_lis_shi_lin_qua_sto_reason_code',
            DB::raw('CASE WHEN dsi.mes_lis_shi_lin_fre_unit_weight=null THEN "0" WHEN dsi.mes_lis_shi_lin_fre_unit_weight="" THEN "0" ELSE dsi.mes_lis_shi_lin_fre_unit_weight  END as mes_lis_shi_lin_fre_unit_weight'), //148
            DB::raw('CASE WHEN dsi.mes_lis_shi_lin_fre_unit_weight_code=null THEN "0" WHEN dsi.mes_lis_shi_lin_fre_unit_weight_code="" THEN "0" ELSE dsi.mes_lis_shi_lin_fre_unit_weight_code  END as mes_lis_shi_lin_fre_unit_weight_code'), //149
            DB::raw('CASE WHEN dsi.mes_lis_shi_lin_fre_item_weight=null THEN "0" WHEN dsi.mes_lis_shi_lin_fre_item_weight="" THEN "0" ELSE dsi.mes_lis_shi_lin_fre_item_weight  END as mes_lis_shi_lin_fre_item_weight'), //150
            DB::raw('CASE WHEN dsi.mes_lis_shi_lin_fre_order_weight=null THEN "0" WHEN dsi.mes_lis_shi_lin_fre_order_weight="" THEN "0" ELSE dsi.mes_lis_shi_lin_fre_order_weight  END as mes_lis_shi_lin_fre_order_weight'), //151
            DB::raw('CASE WHEN dsi.mes_lis_shi_lin_fre_shipment_weight=null THEN "0" WHEN dsi.mes_lis_shi_lin_fre_shipment_weight="" THEN "0" ELSE dsi.mes_lis_shi_lin_fre_shipment_weight  END as mes_lis_shi_lin_fre_shipment_weight'), //152
            // data_shipment_item_details
            // DB::raw('CASE WHEN dsid.mes_lis_shi_lin_pac_itf_code=null THEN "0" WHEN dsid.mes_lis_shi_lin_pac_itf_code="" THEN "0" ELSE dsid.mes_lis_shi_lin_pac_itf_code  END as mes_lis_shi_lin_pac_itf_code'), //153
            // DB::raw('CASE WHEN dsid.mes_lis_shi_lin_pac_package_indicator=null THEN "00" WHEN dsid.mes_lis_shi_lin_pac_package_indicator="" THEN "00" ELSE dsid.mes_lis_shi_lin_pac_package_indicator  END as mes_lis_shi_lin_pac_package_indicator'), //154
            // DB::raw('CASE WHEN dsid.mes_lis_shi_lin_pac_number_of_packages=null THEN "0" WHEN dsid.mes_lis_shi_lin_pac_number_of_packages="" THEN "0" ELSE dsid.mes_lis_shi_lin_pac_number_of_packages  END as mes_lis_shi_lin_pac_number_of_packages'), //155
            'dsid.mes_lis_shi_lin_pac_itf_code',
            'dsid.mes_lis_shi_lin_pac_package_indicator',
            'dsid.mes_lis_shi_lin_pac_number_of_packages',
            DB::raw('CASE WHEN dsid.mes_lis_shi_lin_pac_con_sell_by_date="0000-00-00" THEN "" ELSE dsid.mes_lis_shi_lin_pac_con_sell_by_date  END as mes_lis_shi_lin_pac_con_sell_by_date'),  //156
            DB::raw('CASE WHEN dsid.mes_lis_shi_lin_pac_con_production_date="0000-00-00" THEN "" ELSE dsid.mes_lis_shi_lin_pac_con_production_date  END as mes_lis_shi_lin_pac_con_production_date'),   //157
            'dsid.mes_lis_shi_lin_pac_con_lot_number',
        )
        ->leftJoin('data_shipment_vouchers as dsv', 'dsv.data_shipment_id', '=', 'data_shipments.data_shipment_id')
        ->leftJoin('data_shipment_items as dsi', 'dsv.data_shipment_voucher_id', '=', 'dsi.data_shipment_voucher_id')
        ->leftJoin('data_shipment_item_details as dsid', 'dsi.data_shipment_item_id', '=', 'dsid.data_shipment_item_id')
        ->join('data_order_vouchers as dov', 'dov.data_order_voucher_id', '=', 'dsv.data_shipment_voucher_id')
        ->join('data_orders as dor', 'dor.data_order_id', '=', 'dov.data_order_id')
        ->join('cmn_connects as cc', 'cc.cmn_connect_id', '=', 'dor.cmn_connect_id')
        ->where('cc.byr_buyer_id', $byr_buyer_id);
        // ->where('cc.slr_seller_id', $slr_seller_id);
        // ->where('data_shipments.cmn_connect_id', $cmn_connect_id);


        // filtering
        if ($request->page_title=='slr_order_list') {
            // Log::info($request);
            $receive_date_from = $request->receive_date_from;
            $receive_date_to = $request->receive_date_to;
            $delivery_date_from = $request->delivery_date_from;
            $delivery_date_to = $request->delivery_date_to;
            $receive_date_from = $receive_date_from!=null? date('Y-m-d 00:00:00', strtotime($receive_date_from)):$receive_date_from; // 受信日時開始
            $receive_date_to = $receive_date_to!=null? date('Y-m-d 23:59:59', strtotime($receive_date_to)):$receive_date_to; // 受信日時終了
            $delivery_date_from = $delivery_date_from!=null? date('Y-m-d 00:00:00', strtotime($delivery_date_from)):$delivery_date_from; // 納品日開始
            $delivery_date_to =$delivery_date_to!=null? date('Y-m-d 23:59:59', strtotime($delivery_date_to)):$delivery_date_to;
            // 納品日終了
            $delivery_service_code = $request->delivery_service_code; // 便
            $temperature = $request->temperature; // 配送温度区分
            $check_datetime = $request->check_datetime;
            // $check_datetime=$request->check_datetime;
            $confirmation_status = $request->confirmation_status; // 参照
            $decission_cnt = $request->decission_cnt; // 確定
            $send_cnt = $request->send_cnt; // 印刷
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

            if ($send_cnt == "!0") {
                $csv_data=$csv_data->having('send_cnt', '!=', '0');
            } elseif ($send_cnt != "*") {
                $csv_data=$csv_data->having('send_cnt', '=', $send_cnt);
            }
            if ($decission_cnt == "!0") {
                $csv_data=$csv_data->having('decision_cnt', '!=', '0');
            } elseif ($decission_cnt != "*") {
                $csv_data=$csv_data->having('decision_cnt', '=', $decission_cnt);
            }
            // $csv_data=$csv_data->groupBy('dsv.mes_lis_shi_tra_trade_number');
        } elseif ($request->page_title=='slr_order_detail_list') {
            $order_info=$request->order_info;
            $mes_lis_shi_tra_trade_number=$request->mes_lis_shi_tra_trade_number;
            $fixedSpecial=$request->fixedSpecial;
            $printingStatus=$request->printingStatus;
            $situation=$request->situation;
            $send_datetime=$request->send_datetime;


            $csv_data=$csv_data->where('data_shipments.data_order_id', $data_order_id)
            ->where('dsv.mes_lis_shi_log_del_delivery_service_code', $order_info['mes_lis_shi_log_del_delivery_service_code'])
            ->where('dsv.mes_lis_shi_par_sel_code', $order_info['mes_lis_shi_par_sel_code'])
            ->where('dsv.mes_lis_shi_par_sel_name', $order_info['mes_lis_shi_par_sel_name'])
            ->where('dsv.mes_lis_shi_tra_dat_delivery_date', $order_info['mes_lis_shi_tra_dat_delivery_date'])
            ->where('dsv.mes_lis_shi_tra_goo_major_category', $order_info['mes_lis_shi_tra_goo_major_category'])
            ->where('dsv.mes_lis_shi_tra_ins_temperature_code', $order_info['mes_lis_shi_tra_ins_temperature_code']);

            if ($mes_lis_shi_tra_trade_number!="") {
                $csv_data=$csv_data->where('dsv.mes_lis_shi_tra_trade_number', $mes_lis_shi_tra_trade_number);
            }
            if ($fixedSpecial!="*") {
                $csv_data=$csv_data->where('dsv.mes_lis_shi_tra_ins_goods_classification_code', $fixedSpecial);
            }
            if ($printingStatus!="*") {
                if ($printingStatus=="未印刷あり") {
                    $csv_data=$csv_data->whereNull('dsv.print_datetime');
                }
                if ($printingStatus=="印刷済") {
                    $csv_data=$csv_data->whereNotNull('dsv.print_datetime');
                }
            }
            if ($situation!="*") {
                if ($situation=="未確定あり") {
                    $csv_data=$csv_data->whereNull('dsv.decision_datetime');
                }
                if ($situation=="確定済") {
                    $csv_data=$csv_data->whereNotNull('dsv.decision_datetime');
                }
            }
            if ($send_datetime!="*") {
                if ($send_datetime=="未送信あり") {
                    $csv_data = $csv_data->whereNull('dsv.send_datetime');
                }
                if ($send_datetime=="送信済") {
                    $csv_data = $csv_data->whereNotNull('dsv.send_datetime');
                }
            }
            // ========
            // send_data
            if ($request->send_data==true) {
                $csv_data = $csv_data->whereNotNull('dsv.decision_datetime')
                ->whereNull('dsv.send_datetime');
            }
            // =======
        }

        $csv_data=$csv_data->orderBy('dsv.mes_lis_shi_tra_trade_number', "ASC");
        $csv_data=$csv_data->orderBy('dsi.mes_lis_shi_lin_lin_line_number', "ASC");
        // 検索
        // $csv_data = $csv_data->limit(100000)->get()->toArray();
        Log::debug(__METHOD__.':end---');

        return $csv_data;
    }
    public static function shipmentCsvHeading()
    {
        return [
            '送信者ＩＤ',
            '送信者ＩＤ発行元',
            '受信者ＩＤ',
            '受信者ＩＤ発行元',
            '標準名称',
            'バージョン',
            'インスタンスＩＤ',
            'メッセージ種',
            '作成日時',
            'タイプ',
            'テスト区分ＩＤ',
            '最終送信先ＩＤ',
            'メッセージ識別ＩＤ',
            '送信者ステーションアドレス',
            '最終受信者ステーションアドレス',
            '直接受信者ステーションアドレス',
            '取引数',
            'システム情報キー',
            'システム情報値',
            'バージョン番号',
            'バージョン番号',
            '名前空間',
            'バージョン',
            '支払法人コード',
            '支払法人GLN',
            '支払法人名称',
            '支払法人名称カナ',
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
            '陳列場所コード',
            '陳列場所名称',
            '陳列場所名称カナ',
            '請求取引先コード',
            '請求取引先GLN',
            '請求取引先名',
            '請求取引先名カナ',
            '取引先コード',
            '取引先GLN',
            '取引先名称',
            '取引先名称カナ',
            '枝番',
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
            '商品コード（GTIN）',
            '商品コード（発注用）',
            '商品コード区分',
            '商品コード（取引先）',
            '商品名',
            '商品名カナ',
            '商品コード（出荷元）',
            '規格',
            '規格カナ',
            'カラーコード',
            'カラー名称',
            'カラー名称カナ',
            'サイズコード',
            'サイズ名称',
            'サイズ名称カナ',
            '入数',
            '都道府県コード',
            '国コード',
            '産地名',
            '水域コード',
            '水域名',
            '原産エリア',
            '等級',
            '階級',
            '銘柄',
            '商品ＰＲ',
            'バイオ区分',
            '品種コード',
            '養殖区分',
            '解凍区分',
            '商品状態区分',
            '形状・部位',
            '用途',
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
    public static function getShipmentPdfData($request)
    {
        Log::debug(__METHOD__.':start---');
        $order_info=$request->order_info;
        $mes_lis_shi_tra_trade_number=$request->mes_lis_shi_tra_trade_number;
        $fixedSpecial=$request->fixedSpecial;
        $printingStatus=$request->printingStatus;
        $situation=$request->situation;
        $send_datetime=$request->send_datetime;
        $data_order_id=$request->data_order_id;
        $byr_buyer_id =Auth::User()->ByrInfo->byr_buyer_id;
        $report_arr_final = array();

        $shipment_data = data_order::select(
            'cc.optional',
            'dov.data_order_voucher_id',
            'dov.mes_lis_ord_par_sel_name_sbcs',
            'dov.mes_lis_ord_par_sel_code',
            'dov.mes_lis_ord_par_rec_name_sbcs',
            'dov.mes_lis_ord_tra_ins_goods_classification_code',
            'dov.mes_lis_ord_par_rec_code',
            'dov.mes_lis_ord_tra_goo_major_category',
            'dov.mes_lis_ord_par_shi_name',
            'dov.mes_lis_ord_log_del_delivery_service_code',
            'dov.mes_lis_ord_tra_trade_number',
            'dov.mes_lis_ord_tra_dat_order_date',
            'dov.mes_lis_ord_tra_dat_delivery_date',
            'dov.mes_lis_ord_tot_tot_selling_price_total',
            'dov.mes_lis_ord_tot_tot_net_price_total',
            'doi.mes_lis_ord_lin_ite_name_sbcs',
            'doi.mes_lis_ord_lin_ite_order_item_code',
            'doi.mes_lis_ord_lin_qua_ord_quantity',
            'doi.mes_lis_ord_lin_amo_item_selling_price',
            'doi.mes_lis_ord_lin_amo_item_selling_price_unit_price',
            'doi.mes_lis_ord_lin_amo_item_net_price',
            'doi.mes_lis_ord_lin_amo_item_net_price_unit_price',
            'doi.mes_lis_ord_lin_lin_line_number'
        )
        ->join('data_order_vouchers as dov', 'dov.data_order_id', '=', 'data_orders.data_order_id')
        ->join('data_order_items as doi', 'doi.data_order_voucher_id', '=', 'dov.data_order_voucher_id')
        // ->join('data_shipments as ds', 'ds.data_order_id', '=', 'data_orders.data_order_id')
        // ->join('data_shipment_vouchers as dsv', 'dsv.data_shipment_id', '=', 'ds.data_shipment_id')
        ->join('cmn_connects as cc', 'cc.cmn_connect_id', '=', 'data_orders.cmn_connect_id')
        ->where('cc.byr_buyer_id',$byr_buyer_id);

        $shipment_data=$shipment_data->where('data_orders.data_order_id', $data_order_id)
        ->where('dov.mes_lis_ord_log_del_delivery_service_code', $order_info['mes_lis_shi_log_del_delivery_service_code'])
        ->where('dov.mes_lis_ord_par_sel_code', $order_info['mes_lis_shi_par_sel_code'])
        ->where('dov.mes_lis_ord_par_sel_name', $order_info['mes_lis_shi_par_sel_name'])
        ->where('dov.mes_lis_ord_tra_dat_delivery_date', $order_info['mes_lis_shi_tra_dat_delivery_date'])
        ->where('dov.mes_lis_ord_tra_goo_major_category', $order_info['mes_lis_shi_tra_goo_major_category'])
        ->where('dov.mes_lis_ord_tra_ins_temperature_code', $order_info['mes_lis_shi_tra_ins_temperature_code']);
        $shipment_data=$shipment_data->get();
        // return $shipment_data;
        // ===================
        $recs = new \Illuminate\Database\Eloquent\Collection($shipment_data);
        // return $recs->groupBy(['mes_lis_ord_par_rec_code','mes_lis_ord_tra_trade_number']);
        $grouped = $recs->groupBy(['mes_lis_ord_par_sel_code','mes_lis_ord_par_rec_code','mes_lis_ord_tra_trade_number']);
        // ===================
        // ===============For PDF Data Start============
        // $recs = new \Illuminate\Database\Eloquent\Collection($shipment_data);
        // $grouped = $recs->groupBy('mes_lis_ord_par_rec_code')->transform(function ($item, $k) {
        //     return $item->groupBy('mes_lis_ord_tra_trade_number');
        // });
        // return $grouped;
        $all_shipment_data = $grouped->all();
        // return $all_shipment_data;
        $report_arr_final=array();
        foreach ($all_shipment_data as $key => $value) {
            $tmp_array1=array();
            foreach ($value as $key1 => $value1) {
                $tmp_array2=array();
                foreach ($value1 as $key2 => $value2) {
                    $tmp_array3=array();
                    foreach ($value2 as $key => $value3) {
                        $value3->fax_number = json_decode($value3->optional)->order->fax->number;
                        unset($value3->optional);
                        $tmp_array3[]=$value3;
                    }
                    $tmp_array2[]=$tmp_array3;
                }
                $tmp_array1[]=$tmp_array2;
            }
            $report_arr_final[]=$tmp_array1;
        }
        // ===============For PDF Data End============
        // ==========For Voucher Id Start==============
        $data_collection = collect($shipment_data);
        $data_grouped = $data_collection->groupBy('data_order_voucher_id');
        $data_grouped=$data_grouped->all();
        $voucher_id_arr=array();
        for ($i=0; $i <count($data_grouped) ; $i++) {
            $step0=array_keys($data_grouped)[$i];
            $voucher_id_arr[]=$step0;
        }
        // ==========For Voucher Id End==============
        Log::debug(__METHOD__.':end---');
        return ['report_arr_final'=>$report_arr_final,'voucher_id_array'=>$voucher_id_arr];
    }
}