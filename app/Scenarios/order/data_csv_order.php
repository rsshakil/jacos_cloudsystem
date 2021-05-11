<?php

namespace App\Scenarios\order;

use App\Http\Controllers\API\AllUsedFunction;
use App\Models\DATA\ORD\data_order;
use App\Models\DATA\ORD\data_order_item;
use App\Models\DATA\ORD\data_order_voucher;
use App\Models\DATA\SHIPMENT\data_shipment;
use App\Models\DATA\SHIPMENT\data_shipment_item;
use App\Models\DATA\SHIPMENT\data_shipment_item_detail;
use App\Models\DATA\SHIPMENT\data_shipment_voucher;
use App\Models\CMN\cmn_connect;
use App\Scenarios\Common;
use setasign\Fpdi\Tcpdf\Fpdi;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

require_once base_path('vendor/tecnickcom/tcpdf/tcpdf.php');
use Symfony\Component\HttpFoundation\Response;

// use setasign\Fpdi\Tcpdf\Fpdi;
use tecnickcom\tcpdf\TCPDF_FONTS;

class data_csv_order
{
    private $all_functions;
    private $common_class_obj;
    private $fax_number;
    private $attachment_paths_all;
    private $attachment_paths;
    public function __construct()
    {
        $this->common_class_obj = new Common();
        $this->all_functions = new AllUsedFunction();
        // $this->attachment_paths='';
        $this->attachment_paths_all=array();
        $this->attachment_paths=array();
        $this->fax_number='';
    }

    //
    public function exec($request, $sc)
    {
        $this->attachment_paths_all=$this->pdfGenerate(1);
        Log::info($this->attachment_paths_all);
        return ['message' => "success", 'status' => '1'];
        // return $chunks->all();
        Log::debug(get_class() . ' exec start  ---------------');
        if (!array_key_exists('up_file', $request->all())) {
            Log::error("File not found or file path not valid");
            // return response()->json(['message' => "error", 'status' => '0']);
            return ['message' => "error", 'status' => '0'];
        }
        // ファイルアップロード
        $file_name = time() . '-' . $request->file('up_file')->getClientOriginalName();
        // return response()->json(['file_name'=>$file_name,'status'=>0]);
        $path = $request->file('up_file')->storeAs(config('const.ORDER_DATA_PATH') . date('Y-m'), $file_name);
        Log::debug('save path:' . $path);

        $received_path = storage_path() . '/app//' . config('const.ORDER_DATA_PATH') . date('Y-m') . '/' . $file_name;
        // フォーマット変換

        $dataArr = $this->all_functions->csvReader($received_path, 1);
        $cmn_connect_id = $this->all_functions->get_connect_id_from_file_name($file_name);
        // $aaaaa=$this->pdfGenerate(1);
        // Log::info($aaaaa);
        // return "OK";
        $order_flg = true;
        $trade_number = '';
        DB::beginTransaction();
        try {
            foreach ($dataArr as $key => $value) {
                if (count($value) === 1) {
                    // 空であればcontinue
                    continue;
                }

                if ($order_flg) {
                    $data_order_array['sta_sen_identifier'] = $value[0];
                    $data_order_array['sta_sen_ide_authority'] = $value[1];
                    $data_order_array['sta_rec_identifier'] = $value[2];
                    $data_order_array['sta_rec_ide_authority'] = $value[3];
                    $data_order_array['sta_doc_standard'] = $value[4];
                    $data_order_array['sta_doc_type_version'] = $value[5];
                    $data_order_array['sta_doc_instance_identifier'] = $value[6];
                    $data_order_array['sta_doc_type'] = $value[7];
                    $data_order_array['sta_doc_creation_date_and_time'] = $value[8];
                    $data_order_array['sta_bus_scope_type'] = $value[9];
                    $data_order_array['sta_bus_scope_instance_identifier'] = $value[10];
                    $data_order_array['sta_bus_scope_identifier'] = $value[11];
                    $data_order_array['mes_ent_unique_creator_identification'] = $value[12];
                    $data_order_array['mes_mes_sender_station_address'] = $value[13];
                    $data_order_array['mes_mes_ultimate_receiver_station_address'] = $value[14];
                    $data_order_array['mes_mes_immediate_receiver_station_addres'] = $value[15];
                    $data_order_array['mes_mes_number_of_trading_documents'] = $value[16];
                    $data_order_array['mes_mes_sys_key'] = $value[17];
                    $data_order_array['mes_mes_sys_value'] = $value[18];
                    $data_order_array['mes_lis_con_version'] = $value[19];
                    $data_order_array['mes_lis_doc_version'] = $value[20];
                    $data_order_array['mes_lis_ext_namespace'] = $value[21];
                    $data_order_array['mes_lis_ext_version'] = $value[22];
                    $data_order_array['mes_lis_pay_code'] = $value[23];
                    $data_order_array['mes_lis_pay_gln'] = $value[24];
                    $data_order_array['mes_lis_pay_name'] = $value[25];
                    $data_order_array['mes_lis_pay_name_sbcs'] = $value[26];
                    $data_order_array['mes_lis_buy_code'] = $value[27];
                    $data_order_array['mes_lis_buy_gln'] = $value[28];
                    $data_order_array['mes_lis_buy_name'] = $value[29];
                    $data_order_array['mes_lis_buy_name_sbcs'] = $value[30];

                    // Order
                    $data_order_array['cmn_connect_id'] = $cmn_connect_id;
                    $data_order_array['route'] = 'edi';
                    $data_order_array['receive_file_path'] = $file_name;

                    $data_order_id = data_order::insertGetId($data_order_array);

                    // Shipment
                    unset($data_order_array["route"]);
                    unset($data_order_array["receive_file_path"]);
                    $data_order_array['data_order_id'] = $data_order_id;
                    $data_order_array['upload_datetime'] = '';
                    $data_order_array['upload_file_path'] = '';
                    $data_order_array['send_datetime'] = '';
                    $data_order_array['send_file_path'] = '';
                    $data_order_array['sta_sen_identifier'] = $value[2];
                    $data_order_array['sta_sen_ide_authority'] = $value[3];
                    $data_order_array['sta_rec_identifier'] = $value[0];
                    $data_order_array['sta_rec_ide_authority'] = $value[1];
                    $data_order_array['sta_doc_type'] = 'Shipment Notification';

                    $data_shipment_id = data_shipment::insertGetId($data_order_array);

                    $order_flg = false;
                }

                if ($trade_number != $value[31] . '-' . $value[32]) {
                    $data_voucher_array['mes_lis_ord_tra_trade_number'] = $value[31];
                    $data_voucher_array['mes_lis_ord_tra_additional_trade_number'] = $value[32];
                    $data_voucher_array['mes_lis_ord_par_shi_code'] = $value[33];
                    $data_voucher_array['mes_lis_ord_par_shi_gln'] = $value[34];
                    $data_voucher_array['mes_lis_ord_par_shi_name'] = $value[35];
                    $data_voucher_array['mes_lis_ord_par_shi_name_sbcs'] = $value[36];
                    $data_voucher_array['mes_lis_ord_par_rec_code'] = $value[37];
                    $data_voucher_array['mes_lis_ord_par_rec_gln'] = $value[38];
                    $data_voucher_array['mes_lis_ord_par_rec_name'] = $value[39];
                    $data_voucher_array['mes_lis_ord_par_rec_name_sbcs'] = $value[40];
                    $data_voucher_array['mes_lis_ord_par_tra_code'] = $value[41];
                    $data_voucher_array['mes_lis_ord_par_tra_gln'] = $value[42];
                    $data_voucher_array['mes_lis_ord_par_tra_name'] = $value[43];
                    $data_voucher_array['mes_lis_ord_par_tra_name_sbcs'] = $value[44];
                    $data_voucher_array['mes_lis_ord_par_dis_code'] = $value[45];
                    $data_voucher_array['mes_lis_ord_par_dis_name'] = $value[46];
                    $data_voucher_array['mes_lis_ord_par_dis_name_sbcs'] = $value[47];
                    $data_voucher_array['mes_lis_ord_par_pay_code'] = $value[48];
                    $data_voucher_array['mes_lis_ord_par_pay_gln'] = $value[49];
                    $data_voucher_array['mes_lis_ord_par_pay_name'] = $value[50];
                    $data_voucher_array['mes_lis_ord_par_pay_name_sbcs'] = $value[51];
                    $data_voucher_array['mes_lis_ord_par_sel_code'] = $value[52];
                    $data_voucher_array['mes_lis_ord_par_sel_gln'] = $value[53];
                    $data_voucher_array['mes_lis_ord_par_sel_name'] = $value[54];
                    $data_voucher_array['mes_lis_ord_par_sel_name_sbcs'] = $value[55];
                    $data_voucher_array['mes_lis_ord_par_sel_branch_number'] = $value[56];
                    $data_voucher_array['mes_lis_ord_par_sel_ship_location_code'] = $value[57];
                    $data_voucher_array['mes_lis_ord_log_shi_gln'] = $value[58];
                    $data_voucher_array['mes_lis_ord_log_del_route_code'] = $value[59];
                    $data_voucher_array['mes_lis_ord_log_del_delivery_service_code'] = $value[60];
                    $data_voucher_array['mes_lis_ord_log_del_stock_transfer_code'] = $value[61];
                    $data_voucher_array['mes_lis_ord_log_del_delivery_code'] = $value[62];
                    $data_voucher_array['mes_lis_ord_log_del_delivery_time'] = $value[63];
                    $data_voucher_array['mes_lis_ord_log_del_transportation_code'] = $value[64];
                    $data_voucher_array['mes_lis_ord_log_log_barcode_print'] = $value[65];
                    $data_voucher_array['mes_lis_ord_log_log_category_name_print1'] = $value[66];
                    $data_voucher_array['mes_lis_ord_log_log_category_name_print2'] = $value[67];
                    $data_voucher_array['mes_lis_ord_log_log_receiver_abbr_name'] = $value[68];
                    $data_voucher_array['mes_lis_ord_log_log_text'] = $value[69];
                    $data_voucher_array['mes_lis_ord_log_log_text_sbcs'] = $value[70];
                    $data_voucher_array['mes_lis_ord_tra_goo_major_category'] = $value[71];
                    $data_voucher_array['mes_lis_ord_tra_goo_sub_major_category'] = $value[72];
                    $data_voucher_array['mes_lis_ord_tra_dat_order_date'] = $value[73];
                    $data_voucher_array['mes_lis_ord_tra_dat_delivery_date'] = $value[74];
                    $data_voucher_array['mes_lis_ord_tra_dat_delivery_date_to_receiver'] = $value[75];
                    $data_voucher_array['mes_lis_ord_tra_dat_transfer_of_ownership_date'] = $value[76];
                    $data_voucher_array['mes_lis_ord_tra_dat_campaign_start_date'] = $value[77];
                    $data_voucher_array['mes_lis_ord_tra_dat_campaign_end_date'] = $value[78];
                    $data_voucher_array['mes_lis_ord_tra_dat_valid_until_date'] = $value[79];
                    $data_voucher_array['mes_lis_ord_tra_ins_goods_classification_code'] = $value[80];
                    $data_voucher_array['mes_lis_ord_tra_ins_order_classification_code'] = $value[81];
                    $data_voucher_array['mes_lis_ord_tra_ins_ship_notification_request_code'] = $value[82];
                    $data_voucher_array['mes_lis_ord_tra_ins_private_brand_code'] = $value[83];
                    $data_voucher_array['mes_lis_ord_tra_ins_temperature_code'] = $value[84];
                    $data_voucher_array['mes_lis_ord_tra_ins_liquor_code'] = $value[85];
                    $data_voucher_array['mes_lis_ord_tra_ins_trade_type_code'] = $value[86];
                    $data_voucher_array['mes_lis_ord_tra_ins_paper_form_less_code'] = $value[87];
                    $data_voucher_array['mes_lis_ord_tra_fre_trade_number_request_code'] = $value[88];
                    $data_voucher_array['mes_lis_ord_tra_fre_package_code'] = $value[89];
                    $data_voucher_array['mes_lis_ord_tra_fre_variable_measure_item_code'] = $value[90];
                    $data_voucher_array['mes_lis_ord_tra_tax_tax_type_code'] = $value[91];
                    $data_voucher_array['mes_lis_ord_tra_tax_tax_rate'] = $value[92];
                    $data_voucher_array['mes_lis_ord_tra_not_text'] = $value[93];
                    $data_voucher_array['mes_lis_ord_tra_not_text_sbcs'] = $value[94];
                    $data_voucher_array['mes_lis_ord_tot_tot_net_price_total'] = $value[95];
                    $data_voucher_array['mes_lis_ord_tot_tot_selling_price_total'] = $value[96];
                    $data_voucher_array['mes_lis_ord_tot_tot_tax_total'] = $value[97];
                    $data_voucher_array['mes_lis_ord_tot_tot_item_total'] = $value[98];
                    $data_voucher_array['mes_lis_ord_tot_tot_unit_total'] = $value[99];
                    $data_voucher_array['mes_lis_ord_tot_fre_unit_weight_total'] = $value[100];

                    $data_voucher_array['data_order_id'] = $data_order_id;
                    $data_order_voucher_id = data_order_voucher::insertGetId($data_voucher_array);

                    $data_shi_voucher_array['data_order_voucher_id'] = $data_order_voucher_id;
                    $data_shi_voucher_array['mes_lis_shi_tra_trade_number'] = $value[31];
                    $data_shi_voucher_array['mes_lis_shi_tra_additional_trade_number'] = $value[32];
                    $data_shi_voucher_array['mes_lis_shi_par_shi_code'] = $value[33];
                    $data_shi_voucher_array['mes_lis_shi_par_shi_gln'] = $value[34];
                    $data_shi_voucher_array['mes_lis_shi_par_shi_name'] = $value[35];
                    $data_shi_voucher_array['mes_lis_shi_par_shi_name_sbcs'] = $value[36];
                    $data_shi_voucher_array['mes_lis_shi_par_rec_code'] = $value[37];
                    $data_shi_voucher_array['mes_lis_shi_par_rec_gln'] = $value[38];
                    $data_shi_voucher_array['mes_lis_shi_par_rec_name'] = $value[39];
                    $data_shi_voucher_array['mes_lis_shi_par_rec_name_sbcs'] = $value[40];
                    $data_shi_voucher_array['mes_lis_shi_par_tra_code'] = $value[41];
                    $data_shi_voucher_array['mes_lis_shi_par_tra_gln'] = $value[42];
                    $data_shi_voucher_array['mes_lis_shi_par_tra_name'] = $value[43];
                    $data_shi_voucher_array['mes_lis_shi_par_tra_name_sbcs'] = $value[44];
                    $data_shi_voucher_array['mes_lis_shi_par_dis_code'] = $value[45];
                    $data_shi_voucher_array['mes_lis_shi_par_dis_name'] = $value[46];
                    $data_shi_voucher_array['mes_lis_shi_par_dis_name_sbcs'] = $value[47];
                    $data_shi_voucher_array['mes_lis_shi_par_pay_code'] = $value[48];
                    $data_shi_voucher_array['mes_lis_shi_par_pay_gln'] = $value[49];
                    $data_shi_voucher_array['mes_lis_shi_par_pay_name'] = $value[50];
                    $data_shi_voucher_array['mes_lis_shi_par_pay_name_sbcs'] = $value[51];
                    $data_shi_voucher_array['mes_lis_shi_par_sel_code'] = $value[52];
                    $data_shi_voucher_array['mes_lis_shi_par_sel_gln'] = $value[53];
                    $data_shi_voucher_array['mes_lis_shi_par_sel_name'] = $value[54];
                    $data_shi_voucher_array['mes_lis_shi_par_sel_name_sbcs'] = $value[55];
                    $data_shi_voucher_array['mes_lis_shi_par_sel_branch_number'] = $value[56];
                    $data_shi_voucher_array['mes_lis_shi_par_sel_ship_location_code'] = $value[57];
                    $data_shi_voucher_array['mes_lis_shi_log_shi_gln'] = $value[58];
                    $data_shi_voucher_array['mes_lis_shi_log_del_route_code'] = $value[59];
                    $data_shi_voucher_array['mes_lis_shi_log_del_delivery_service_code'] = $value[60];
                    $data_shi_voucher_array['mes_lis_shi_log_del_stock_transfer_code'] = $value[61];
                    $data_shi_voucher_array['mes_lis_shi_log_del_delivery_code'] = $value[62];
                    $data_shi_voucher_array['mes_lis_shi_log_del_delivery_time'] = $value[63];
                    $data_shi_voucher_array['mes_lis_shi_log_del_transportation_code'] = $value[64];
                    $data_shi_voucher_array['mes_lis_shi_log_log_barcode_print'] = $value[65];
                    $data_shi_voucher_array['mes_lis_shi_log_log_category_name_print1'] = $value[66];
                    $data_shi_voucher_array['mes_lis_shi_log_log_category_name_print2'] = $value[67];
                    $data_shi_voucher_array['mes_lis_shi_log_log_receiver_abbr_name'] = $value[68];
                    $data_shi_voucher_array['mes_lis_shi_log_log_text'] = $value[69];
                    $data_shi_voucher_array['mes_lis_shi_log_log_text_sbcs'] = $value[70];
                    $data_shi_voucher_array['mes_lis_shi_log_maker_code_for_receiving'] = '';
                    $data_shi_voucher_array['mes_lis_shi_log_delivery_slip_number'] = '';
                    $data_shi_voucher_array['mes_lis_shi_tra_goo_major_category'] = $value[71];
                    $data_shi_voucher_array['mes_lis_shi_tra_goo_sub_major_category'] = $value[72];
                    $data_shi_voucher_array['mes_lis_shi_tra_dat_order_date'] = $value[73];
                    $data_shi_voucher_array['mes_lis_shi_tra_dat_delivery_date'] = $value[74];
                    $data_shi_voucher_array['mes_lis_shi_tra_dat_delivery_date_to_receiver'] = $value[75];
                    $data_shi_voucher_array['mes_lis_shi_tra_dat_revised_delivery_date'] = null;
                    $data_shi_voucher_array['mes_lis_shi_tra_dat_transfer_of_ownership_date'] = $value[76];
                    $data_shi_voucher_array['mes_lis_shi_tra_dat_campaign_start_date'] = $value[77];
                    $data_shi_voucher_array['mes_lis_shi_tra_dat_campaign_end_date'] = $value[78];
                    // $data_shi_voucher_array['mes_lis_shi_tra_dat_valid_until_date']=$value[79];
                    $data_shi_voucher_array['mes_lis_shi_tra_ins_goods_classification_code'] = $value[80];
                    $data_shi_voucher_array['mes_lis_shi_tra_ins_order_classification_code'] = $value[81];
                    $data_shi_voucher_array['mes_lis_shi_tra_ins_ship_notification_request_code'] = $value[82];
                    $data_shi_voucher_array['mes_lis_shi_tra_ins_eos_code'] = '01';
                    $data_shi_voucher_array['mes_lis_shi_tra_ins_private_brand_code'] = $value[83];
                    $data_shi_voucher_array['mes_lis_shi_tra_ins_temperature_code'] = $value[84];
                    $data_shi_voucher_array['mes_lis_shi_tra_ins_liquor_code'] = $value[85];
                    $data_shi_voucher_array['mes_lis_shi_tra_ins_trade_type_code'] = $value[86];
                    $data_shi_voucher_array['mes_lis_shi_tra_ins_paper_form_less_code'] = $value[87];
                    $data_shi_voucher_array['mes_lis_shi_tra_fre_trade_number_request_code'] = $value[88];
                    $data_shi_voucher_array['mes_lis_shi_tra_fre_package_code'] = $value[89];
                    $data_shi_voucher_array['mes_lis_shi_tra_fre_variable_measure_item_code'] = $value[90];
                    $data_shi_voucher_array['mes_lis_shi_tra_tax_tax_type_code'] = $value[91];
                    $data_shi_voucher_array['mes_lis_shi_tra_tax_tax_rate'] = $value[92];
                    $data_shi_voucher_array['mes_lis_shi_tra_not_text'] = $value[93];
                    $data_shi_voucher_array['mes_lis_shi_tra_not_text_sbcs'] = $value[94];
                    $data_shi_voucher_array['mes_lis_shi_tot_tot_net_price_total'] = $value[95];
                    $data_shi_voucher_array['mes_lis_shi_tot_tot_selling_price_total'] = $value[96];
                    $data_shi_voucher_array['mes_lis_shi_tot_tot_tax_total'] = $value[97];
                    $data_shi_voucher_array['mes_lis_shi_tot_tot_item_total'] = $value[98];
                    $data_shi_voucher_array['mes_lis_shi_tot_tot_unit_total'] = $value[99];
                    $data_shi_voucher_array['mes_lis_shi_tot_fre_unit_weight_total'] = $value[100];

                    $data_shi_voucher_array["data_shipment_id"] = $data_shipment_id;
                    $data_shipment_voucher_id = data_shipment_voucher::insertGetId($data_shi_voucher_array);

                    $trade_number = $value[31] . '-' . $value[32];
                }

                $data_item_array['mes_lis_ord_lin_lin_line_number'] = $value[101];
                $data_item_array['mes_lis_ord_lin_lin_additional_line_number'] = $value[102];
                $data_item_array['mes_lis_ord_lin_fre_trade_number'] = $value[103];
                $data_item_array['mes_lis_ord_lin_fre_line_number'] = $value[104];
                $data_item_array['mes_lis_ord_lin_goo_minor_category'] = $value[105];
                $data_item_array['mes_lis_ord_lin_goo_detailed_category'] = $value[106];
                $data_item_array['mes_lis_ord_lin_ite_scheduled_date'] = $value[107];
                $data_item_array['mes_lis_ord_lin_ite_deadline_date'] = $value[108];
                $data_item_array['mes_lis_ord_lin_ite_center_delivery_instruction_code'] = $value[109];
                $data_item_array['mes_lis_ord_lin_ite_maker_code'] = $value[110];
                $data_item_array['mes_lis_ord_lin_ite_gtin'] = $value[111];
                $data_item_array['mes_lis_ord_lin_ite_order_item_code'] = $value[112];
                $data_item_array['mes_lis_ord_lin_ite_ord_code_type'] = $value[113];
                $data_item_array['mes_lis_ord_lin_ite_supplier_item_code'] = $value[114];
                $data_item_array['mes_lis_ord_lin_ite_name'] = $value[115];
                $data_item_array['mes_lis_ord_lin_ite_name_sbcs'] = $value[116];
                $data_item_array['mes_lis_ord_lin_ite_ite_spec'] = $value[117];
                $data_item_array['mes_lis_ord_lin_ite_ite_spec_sbcs'] = $value[118];
                $data_item_array['mes_lis_ord_lin_ite_col_color_code'] = $value[119];
                $data_item_array['mes_lis_ord_lin_ite_col_description'] = $value[120];
                $data_item_array['mes_lis_ord_lin_ite_col_description_sbcs'] = $value[121];
                $data_item_array['mes_lis_ord_lin_ite_siz_size_code'] = $value[122];
                $data_item_array['mes_lis_ord_lin_ite_siz_description'] = $value[123];
                $data_item_array['mes_lis_ord_lin_ite_siz_description_sbcs'] = $value[124];
                $data_item_array['mes_lis_ord_lin_fre_packing_quantity'] = $value[125];
                $data_item_array['mes_lis_ord_lin_fre_prefecture_code'] = $value[126];
                $data_item_array['mes_lis_ord_lin_fre_country_code'] = $value[127];
                $data_item_array['mes_lis_ord_lin_fre_field_name'] = $value[128];
                $data_item_array['mes_lis_ord_lin_fre_water_area_code'] = $value[129];
                $data_item_array['mes_lis_ord_lin_fre_water_area_name'] = $value[130];
                $data_item_array['mes_lis_ord_lin_fre_area_of_origin'] = $value[131];
                $data_item_array['mes_lis_ord_lin_fre_item_grade'] = $value[132];
                $data_item_array['mes_lis_ord_lin_fre_item_class'] = $value[133];
                $data_item_array['mes_lis_ord_lin_fre_brand'] = $value[134];
                $data_item_array['mes_lis_ord_lin_fre_item_pr'] = $value[135];
                $data_item_array['mes_lis_ord_lin_fre_bio_code'] = $value[136];
                $data_item_array['mes_lis_ord_lin_fre_breed_code'] = $value[137];
                $data_item_array['mes_lis_ord_lin_fre_cultivation_code'] = $value[138];
                $data_item_array['mes_lis_ord_lin_fre_defrost_code'] = $value[139];
                $data_item_array['mes_lis_ord_lin_fre_item_preservation_code'] = $value[140];
                $data_item_array['mes_lis_ord_lin_fre_item_shape_code'] = $value[141];
                $data_item_array['mes_lis_ord_lin_fre_use'] = $value[142];
                $data_item_array['mes_lis_ord_lin_sta_statutory_classification_code'] = $value[143];
                $data_item_array['mes_lis_ord_lin_amo_item_net_price'] = $value[144];
                $data_item_array['mes_lis_ord_lin_amo_item_net_price_unit_price'] = $value[145];
                $data_item_array['mes_lis_ord_lin_amo_item_selling_price'] = $value[146];
                $data_item_array['mes_lis_ord_lin_amo_item_selling_price_unit_price'] = $value[147];
                $data_item_array['mes_lis_ord_lin_amo_item_tax'] = $value[148];
                $data_item_array['mes_lis_ord_lin_qua_unit_multiple'] = $value[149];
                $data_item_array['mes_lis_ord_lin_qua_unit_of_measure'] = $value[150];
                $data_item_array['mes_lis_ord_lin_qua_package_indicator'] = $value[151];
                $data_item_array['mes_lis_ord_lin_qua_ord_quantity'] = $value[152];
                $data_item_array['mes_lis_ord_lin_qua_ord_num_of_order_units'] = $value[153];
                $data_item_array['mes_lis_ord_lin_fre_unit_weight'] = $value[154];
                $data_item_array['mes_lis_ord_lin_fre_unit_weight_code'] = $value[155];
                $data_item_array['mes_lis_ord_lin_fre_item_weight'] = $value[156];
                $data_item_array['mes_lis_ord_lin_fre_order_weight'] = $value[157];

                $data_shi_item_array['mes_lis_shi_lin_lin_line_number'] = $value[101];
                $data_shi_item_array['mes_lis_shi_lin_lin_additional_line_number'] = $value[102];
                $data_shi_item_array['mes_lis_shi_lin_fre_trade_number'] = $value[103];
                $data_shi_item_array['mes_lis_shi_lin_fre_line_number'] = $value[104];
                $data_shi_item_array['mes_lis_shi_lin_fre_shipment_line_number'] = '';
                $data_shi_item_array['mes_lis_shi_lin_goo_minor_category'] = $value[105];
                $data_shi_item_array['mes_lis_shi_lin_goo_detailed_category'] = $value[106];
                $data_shi_item_array['mes_lis_shi_lin_ite_scheduled_date'] = $value[107];
                $data_shi_item_array['mes_lis_shi_lin_ite_deadline_date'] = $value[108];
                $data_shi_item_array['mes_lis_shi_lin_ite_center_delivery_instruction_code'] = $value[109];
                $data_shi_item_array['mes_lis_shi_lin_fre_interim_price_code'] = '';
                $data_shi_item_array['mes_lis_shi_lin_ite_maker_code'] = $value[110];
                $data_shi_item_array['mes_lis_shi_lin_ite_gtin'] = $value[111];
                $data_shi_item_array['mes_lis_shi_lin_ite_order_item_code'] = $value[112];
                $data_shi_item_array['mes_lis_shi_lin_ite_ord_code_type'] = $value[113];
                $data_shi_item_array['mes_lis_shi_lin_ite_supplier_item_code'] = $value[114];
                $data_shi_item_array['mes_lis_shi_lin_ite_name'] = $value[115];
                $data_shi_item_array['mes_lis_shi_lin_ite_name_sbcs'] = $value[116];
                $data_shi_item_array['mes_lis_shi_lin_fre_shipment_item_code'] = '';
                $data_shi_item_array['mes_lis_shi_lin_ite_ite_spec'] = $value[117];
                $data_shi_item_array['mes_lis_shi_lin_ite_ite_spec_sbcs'] = $value[118];
                $data_shi_item_array['mes_lis_shi_lin_ite_col_color_code'] = $value[119];
                $data_shi_item_array['mes_lis_shi_lin_ite_col_description'] = $value[120];
                $data_shi_item_array['mes_lis_shi_lin_ite_col_description_sbcs'] = $value[121];
                $data_shi_item_array['mes_lis_shi_lin_ite_siz_size_code'] = $value[122];
                $data_shi_item_array['mes_lis_shi_lin_ite_siz_description'] = $value[123];
                $data_shi_item_array['mes_lis_shi_lin_ite_siz_description_sbcs'] = $value[124];
                $data_shi_item_array['mes_lis_shi_lin_fre_packing_quantity'] = $value[125];
                $data_shi_item_array['mes_lis_shi_lin_fre_prefecture_code'] = $value[126];
                $data_shi_item_array['mes_lis_shi_lin_fre_country_code'] = $value[127];
                $data_shi_item_array['mes_lis_shi_lin_fre_field_name'] = $value[128];
                $data_shi_item_array['mes_lis_shi_lin_fre_water_area_code'] = $value[129];
                $data_shi_item_array['mes_lis_shi_lin_fre_water_area_name'] = $value[130];
                $data_shi_item_array['mes_lis_shi_lin_fre_area_of_origin'] = $value[131];
                $data_shi_item_array['mes_lis_shi_lin_fre_item_grade'] = $value[132];
                $data_shi_item_array['mes_lis_shi_lin_fre_item_class'] = $value[133];
                $data_shi_item_array['mes_lis_shi_lin_fre_brand'] = $value[134];
                $data_shi_item_array['mes_lis_shi_lin_fre_item_pr'] = $value[135];
                $data_shi_item_array['mes_lis_shi_lin_fre_bio_code'] = $value[136];
                $data_shi_item_array['mes_lis_shi_lin_fre_breed_code'] = $value[137];
                $data_shi_item_array['mes_lis_shi_lin_fre_cultivation_code'] = $value[138];
                $data_shi_item_array['mes_lis_shi_lin_fre_defrost_code'] = $value[139];
                $data_shi_item_array['mes_lis_shi_lin_fre_item_preservation_code'] = $value[140];
                $data_shi_item_array['mes_lis_shi_lin_fre_item_shape_code'] = $value[141];
                $data_shi_item_array['mes_lis_shi_lin_fre_use'] = $value[142];
                $data_shi_item_array['mes_lis_shi_lin_sta_statutory_classification_code'] = $value[143];
                $data_shi_item_array['mes_lis_shi_lin_amo_item_net_price'] = $value[144];
                $data_shi_item_array['mes_lis_shi_lin_amo_item_net_price_unit_price'] = $value[145];
                $data_shi_item_array['mes_lis_shi_lin_amo_item_selling_price'] = $value[146];
                $data_shi_item_array['mes_lis_shi_lin_amo_item_selling_price_unit_price'] = $value[147];
                $data_shi_item_array['mes_lis_shi_lin_amo_item_tax'] = $value[148];
                $data_shi_item_array['mes_lis_shi_lin_qua_unit_multiple'] = $value[149];
                $data_shi_item_array['mes_lis_shi_lin_qua_unit_of_measure'] = $value[150];
                $data_shi_item_array['mes_lis_shi_lin_qua_package_indicator'] = $value[151];
                $data_shi_item_array['mes_lis_shi_lin_qua_ord_quantity'] = $value[152];
                $data_shi_item_array['mes_lis_shi_lin_qua_ord_num_of_order_units'] = $value[153];
                $data_shi_item_array['mes_lis_shi_lin_qua_shi_quantity'] = $value[152];
                $data_shi_item_array['mes_lis_shi_lin_qua_shi_num_of_order_units'] = $value[153];
                $data_shi_item_array['mes_lis_shi_lin_qua_sto_quantity'] = '';
                $data_shi_item_array['mes_lis_shi_lin_qua_sto_num_of_order_units'] = '';
                $data_shi_item_array['mes_lis_shi_lin_qua_sto_reason_code'] = '00';
                $data_shi_item_array['mes_lis_shi_lin_fre_unit_weight'] = $value[154];
                $data_shi_item_array['mes_lis_shi_lin_fre_unit_weight_code'] = $value[155];
                $data_shi_item_array['mes_lis_shi_lin_fre_item_weight'] = $value[156];
                $data_shi_item_array['mes_lis_shi_lin_fre_order_weight'] = $value[157];
                $data_shi_item_array['mes_lis_shi_lin_fre_shipment_weight'] = $value[157];
                // 158 done

                $data_item_array['data_order_voucher_id'] = $data_order_voucher_id;
                data_order_item::insert($data_item_array);

                $data_shi_item_array["data_shipment_voucher_id"] = $data_shipment_voucher_id;
                $data_shipment_item_id = data_shipment_item::insertGetId($data_shi_item_array);
                data_shipment_item_detail::insert(['data_shipment_item_id' => $data_shipment_item_id]);

                // format
                $data_order_array = array();
                $data_voucher_array = array();
                $data_shi_voucher_array = array();
                $data_item_array = array();
                $data_shi_item_array = array();
            }

    // });
    // Mail
        $cmn_connect_options=cmn_connect::select('optional')->where('cmn_connect_id',$cmn_connect_id)->first();
        $optional=json_decode($cmn_connect_options->optional);
        try {
            if ($optional->order->fax->exec) {
                $this->fax_number=$optional->order->fax->number;
                $this->attachment_paths_all=$this->pdfGenerate($data_order_id);
                Log::info($this->attachment_paths_all);

            // foreach ($this->attachment_paths_all as $key => $value) {
            //     Log::info('send mail for fax:[to:'.config('const.PDF_SEND_MAIL').',subject:'.$this->fax_number.']');
            //     $this->attachment_paths=$value;
            //     Mail::send([],[] ,function($message) { $message->to(config('const.PDF_SEND_MAIL'))
            //         ->subject($this->fax_number);
            //         Log::info('attach file:'.$this->attachment_paths);
            //         $message->attach($this->attachment_paths)
            //         // foreach($this->attachment_paths as $filePath){
            //         //     $message->attach($filePath);
            //         // }
            //         ->setBody(''); });
            // }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage().' Or May be data font missing in database data or bad file');
            return ['message' => "May be data font missing in database data or bad file", 'status' => 0];
        }
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::error($e->getMessage());
        return ['message' => $e, 'status' => 0];
        // something went wrong
    }

        // Mail
        return ['message' => "success", 'status' => 1];
    }
    public function pdfGenerate($data_order_id)
    {
        $pdf_file_paths=array();
        $page=0;
        $receipt=$this->fpdfRet();
        $pdf_datas = $this->pdfDAta($data_order_id);
        // print_r($pdf_datas);
        // Log::info($pdf_datas);
        $x = 0;
        $y = 0;
        $i = 0;
        $mes_lis_ord_par_rec_code='';
        $page_limit=10;
        $file_number=1;
        $same_rec_code=1;
        Log::info(count($pdf_datas));
        // foreach ($pdf_datas as $key => $pdf_data) {
        //     Log::info($pdf_data[0]->mes_lis_ord_par_rec_code);
        //     Log::info($pdf_data[0]->mes_lis_ord_tra_trade_number);

        // }
        foreach ($pdf_datas as $key=>$pdf_data) {
            Log::info($pdf_data);
            if (!($i > count($pdf_datas))) {
                if ($page!=0 && ($page % $page_limit)==0) {
                    Log::info("i: ".($i));
                    Log::info("page%: ".($page % $page_limit));
                    Log::info("page: ".$page);
                    Log::info("page_limit: ".$page_limit);
                    Log::info("file_number: ".$file_number);
                    Log::info("same_rec_code: ".$same_rec_code);
                    if (!(($file_number*$page_limit)>$page)) {
                        $pdf_file_path = $this->file_save($receipt,$file_number);
                        array_push($pdf_file_paths,$pdf_file_path);
                        $receipt=$this->fpdfRet();
                        $file_number+=1;
                    }

                }

                if (isset($pdf_datas[$i])) {
                    if ($mes_lis_ord_par_rec_code!=$pdf_datas[$i][0]->mes_lis_ord_par_rec_code) {
                        $receipt->AddPage();
                        $page+=1;
                        $receipt=$this->headerData($receipt,$pdf_data,$x,$y);
                        $this->coordinateText($receipt, $pdf_datas[$i],$i,0,50.7,103.4);
                    }else{
                        if ($same_rec_code%2==0) {
                            $receipt->AddPage();
                            $page+=1;
                        }
                        // $receipt=$this->headerData($receipt,$pdf_data,$x,$y);
                        $this->coordinateText($receipt, $pdf_datas[$i],$i,0,117,170);
                        $same_rec_code+=1;
                        // \Log::info("else i number".$i);
                    }

                    $mes_lis_ord_par_rec_code=$pdf_datas[$i][0]->mes_lis_ord_par_rec_code;
                }
                $i += 1;
                $x = 0;
                $y = 0;
                $same_rec_code=1;
            }

        }
        // if ($page==0 && $page % $page_limit!=0) {
        if ($page % $page_limit!=0) {
            $pdf_file_path= $this->file_save($receipt,$file_number);
            array_push($pdf_file_paths,$pdf_file_path);
        }
        return $pdf_file_paths;
        // return $response;
    }
    public function file_save($receipt, $file_number){
        // Log::debug(dd($receipt));
        $pdf_file_name=date('YmdHis').'_'.$file_number.'_receipt.pdf';
        $this->all_functions->folder_create(config('const.PDF_SAVE_PATH'));
        $response = new Response(
            $receipt->Output(storage_path(config('const.PDF_SAVE_PATH').$pdf_file_name), 'F'), 200, array('content-type' => 'application / pdf')
        );
        // $pdf_file_path = \Config::get('app.url').'storage/'.config('const.PDF_SAVE_PATH').$pdf_file_name;
        $pdf_file_path = storage_path(config('const.PDF_SAVE_PATH').$pdf_file_name);
        // $receipt = new Fpdi();
        // $pagecount = $receipt->setSourceFile($pdf_file_path);
        // Log::info("Counted".$pagecount);
        return $pdf_file_path;
    }
    public function headerData($receipt,$pdf_data,$x,$y){
        $receipt->setSourceFile(storage_path(config('const.BLANK_PDF_PATH')));
        $tplIdx = $receipt->importPage(1);
        $receipt->UseTemplate($tplIdx, null, null, null, null, true);
        $receipt->SetXY($x + 23, $y + 33.5);
        $receipt->Write(0, $pdf_data[0]->fax_number);
        $receipt->SetXY($x + 15, $y + 37.8);
        $receipt->Write(0, $pdf_data[0]->mes_lis_ord_par_sel_name_sbcs);
        $receipt->SetXY($x + 26.5, $y + 41.8);
        $receipt->Write(0, $pdf_data[0]->mes_lis_ord_par_sel_code);
        $receipt->SetXY($x + 122, $y + 33);
        $receipt->Write(0, $pdf_data[0]->mes_lis_ord_par_shi_name);
        return $receipt;
    }
    public function fpdfRet(){
        Log::info("FPDI");
        $receipt = new Fpdi();
        // Set PDF margins (top left and right)
        $receipt->SetMargins(0, 0, 0);

        // Disable header output
        $receipt->setPrintHeader(false);

        // Disable footer output
        $receipt->setPrintFooter(false);
        // $receipt->UseTemplate($tplIdx, null, null, null, null, true);
        $receipt->setFontSubsetting(true);
        // font declared
        $fontPathRegular = storage_path(config('const.MIGMIX_FONT_PATH'));
        $receipt->SetFont(\TCPDF_FONTS::addTTFfont($fontPathRegular), '', 8, '', true);


        return $receipt;
    }

    public function coordinateText($receipt, $pdf_data,$i=0, $x = 0, $y = 50.7,$sum_of_y=103.4)
    {
        //Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
        $receipt->SetXY($x + 29.6, $y);
        $receipt->Cell(14.8, 0, $pdf_data[0]->mes_lis_ord_par_rec_name_sbcs, 0, 1, 'L', 0, '', 0);
        $receipt->SetXY($x + 62.5, $y);
        $receipt->Cell(20, 0, str_pad($pdf_data[0]->mes_lis_ord_par_rec_code, 4, "0", STR_PAD_LEFT), 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 100.5, $y);
        $receipt->Cell(11.5, 0, '50', 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 121.5, $y);
        $receipt->Cell(11.5, 0, str_pad($pdf_data[0]->mes_lis_ord_tra_goo_major_category, 4, "0", STR_PAD_LEFT), 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 147.5, $y);
        $receipt->Cell(4.5, 0, $pdf_data[0]->mes_lis_ord_log_del_delivery_service_code, 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 170.2, $y);
        $receipt->Cell(22, 0, $pdf_data[0]->mes_lis_ord_tra_trade_number, 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 207, $y);
        $receipt->Cell(21.6, 0, date('y/m/d',strtotime($pdf_data[0]->mes_lis_ord_tra_dat_order_date)), 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 243, $y);
        $receipt->Cell(21.6, 0, date('y/m/d',strtotime($pdf_data[0]->mes_lis_ord_tra_dat_delivery_date)), 0, 1, 'C', 0, '', 0);
        $receipt->SetXY($x + 29.6, $y += 4.5);
        $receipt->Cell(14.8, 0, $pdf_data[0]->mes_lis_ord_tra_ins_goods_classification_code, 0, 1, 'C', 0, '', 0);
        $y += 8.3;
        foreach ($pdf_data as $key1 => $value) {
            $receipt->SetXY($x += 14.7, $y);
            $receipt->Cell(14.8, 4.5, str_pad($value->mes_lis_ord_lin_lin_line_number, 2, "0", STR_PAD_LEFT), 0, 1, 'C', 0, '', 0);
            $receipt->SetXY($x += 15, $y);
            $receipt->Cell(52.5, 4.5, $value->mes_lis_ord_lin_ite_name_sbcs, 0, 1, 'L', 0, '', 0);
            $receipt->SetXY($x += 52.5, $y);
            $receipt->Cell(30, 4.5, $value->mes_lis_ord_lin_ite_order_item_code, 0, 1, 'L', 0, '', 0);
            $receipt->SetXY($x += 30, $y);
            $receipt->Cell(21, 4.5, intVal($value->mes_lis_ord_lin_qua_ord_quantity), 0, 1, 'R', 0, '', 0);
            $receipt->SetXY($x += 21, $y);
            $receipt->Cell(37, 4.5, number_format($value->mes_lis_ord_lin_amo_item_net_price_unit_price, 2), 0, 1, 'R', 0, '', 0);
            $receipt->SetXY($x += 37, $y);
            $receipt->Cell(36.8, 4.5, number_format($value->mes_lis_ord_lin_amo_item_net_price), 0, 1, 'R', 0, '', 0);
            $receipt->SetXY($x += 36.8, $y);
            $receipt->Cell(21.5, 4.5, number_format($value->mes_lis_ord_lin_amo_item_selling_price_unit_price), 0, 1, 'R', 0, '', 0);
            $receipt->SetXY($x += 21.5, $y);
            $receipt->Cell(36, 4.5, number_format($value->mes_lis_ord_lin_amo_item_selling_price), 0, 1, 'R', 0, '', 0);
            $x = 0;
            $y += 4.5;
        }
        $x = 0;
        // if ($i%2==0) {
        //     $y=103.4;
        // }else{
        //     $y=170;
        // }
        // $y += 33.7;
        $receipt->SetXY($x + 170.5, $sum_of_y);
        $receipt->Cell(36.5, 4.5, number_format($value->mes_lis_ord_tot_tot_net_price_total), 0, 1, 'R', 0, '', 0);
        $receipt->SetXY($x + 228.2, $sum_of_y);
        $receipt->Cell(36.5, 4.5, number_format($value->mes_lis_ord_tot_tot_selling_price_total), 0, 1, 'R', 0, '', 0);
        $y=0;
        return $receipt;
    }
    public function pdfDAta($data_order_id)
    {
        // $line_per_page=$request->line_per_page;
        // $data_order_id=$request->data_order_id;
        $report_arr_final = array();
        $order_data = data_order::select(
            'cmn_connects.optional',
            'data_order_vouchers.mes_lis_ord_par_sel_name_sbcs',
            'data_order_vouchers.mes_lis_ord_par_sel_code',
            'data_order_vouchers.mes_lis_ord_par_rec_name_sbcs',
            'data_order_vouchers.mes_lis_ord_tra_ins_goods_classification_code',
            'data_order_vouchers.mes_lis_ord_par_rec_code',
            'data_order_vouchers.mes_lis_ord_tra_goo_major_category',
            'data_order_vouchers.mes_lis_ord_par_shi_name',
            'data_order_vouchers.mes_lis_ord_log_del_delivery_service_code',
            'data_order_vouchers.mes_lis_ord_tra_trade_number',
            'data_order_vouchers.mes_lis_ord_tra_dat_order_date',
            'data_order_vouchers.mes_lis_ord_tra_dat_delivery_date',
            'data_order_vouchers.mes_lis_ord_tot_tot_selling_price_total',
            'data_order_vouchers.mes_lis_ord_tot_tot_net_price_total',
            'data_order_items.mes_lis_ord_lin_ite_name_sbcs',
            'data_order_items.mes_lis_ord_lin_ite_order_item_code',
            'data_order_items.mes_lis_ord_lin_qua_ord_quantity',
            'data_order_items.mes_lis_ord_lin_amo_item_selling_price',
            'data_order_items.mes_lis_ord_lin_amo_item_selling_price_unit_price',
            'data_order_items.mes_lis_ord_lin_amo_item_net_price',
            'data_order_items.mes_lis_ord_lin_amo_item_net_price_unit_price',
            'data_order_items.mes_lis_ord_lin_lin_line_number'
        )
            ->join('data_order_vouchers', 'data_order_vouchers.data_order_id', '=', 'data_orders.data_order_id')
            ->join('data_order_items', 'data_order_items.data_order_voucher_id', '=', 'data_order_vouchers.data_order_voucher_id')
            ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'data_orders.cmn_connect_id')
            ->where('data_orders.data_order_id', $data_order_id)
            ->get();
        // return $order_data;
        $collection = collect($order_data);

        $grouped = $collection->groupBy('mes_lis_ord_tra_trade_number');

        $aaa = $grouped->all();
        $report_arr_count = count($aaa);
        for ($i = 0; $i < $report_arr_count; $i++) {
            $step0 = array_keys($aaa)[$i];
            // =====
            for ($k = 0; $k < count($aaa[$step0]); $k++) {
                $aaa[$step0][$k]['fax_number'] = json_decode($aaa[$step0][$k]['optional'])->order->fax->number;
            }
            // =====
            $step0_data_array = $aaa[$step0];
            $report_arr_final[] = $step0_data_array;
        }
        return $report_arr_final;
        // return ['status'=>1,'new_report_array'=>$report_arr_final];
    }
}
