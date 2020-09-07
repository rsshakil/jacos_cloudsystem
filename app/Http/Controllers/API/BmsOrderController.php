<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\AllUsedFunction;
use App\Models\ADM\User;
use App\Models\BYR\byr_order;
use App\Models\BMS\bms_order;
use App\Models\CMN\cmn_job;

class BmsOrderController extends Controller
{
    private $order_id;
    private $all_functions;
    public function __construct()
    {
        $this->order_id = '';
        $this->all_functions = new AllUsedFunction();
    }
    public function store(Request $request, $job_id){
        // return $request->all();
        ini_set('max_execution_time', 6000);
        ini_set('memory_limit', '256M');
        if(isset($request->email) && isset($request->password)){
            $user = User::where('email', '=', $request->email)->first();
            if (!$user) {
                return ['status'=>1, 'message' => 'Authentication faild!'];
            }
            if (!Hash::check($request->password, $user->password)) {
                return ['status'=>1, 'message' => 'Authentication faild!'];
            } 
        }else{
            return ['status'=>1, 'message' => 'Authentication faild!'];
        }
        if (!(Validator::make($request->all(), ['order_file' => 'required'])->passes())) {
            return $result = response()->json(['message' => 'File required','class_name' => 'alert-danger', 'status_code' => 404]);
        }
        // return $request->all();
        // return $this->customer_id;
        $file = $request->file('order_file');
        // return $file_name = $file->getClientOriginalName();
        $file_name = $file->getClientOriginalName();
        // File Name change 
        $fileName = $this->all_functions->file_name_change($file_name);
        // $this->all_functions->public_folder_create('bms_order_files');
        $file_temp_path = public_path('bms_order_files');
        $file->move($file_temp_path, $fileName);

        $baseUrl = public_path('bms_order_files/') . $fileName;
        $dataArr = $this->all_functions->csvReader($baseUrl);
        $data_count=count($dataArr);
        $cmn_connect_info=cmn_job::select('cmn_connect_id')->where('cmn_job_id',$job_id)->first();
        $order_array=array(
            "cmn_connect_id"=>$cmn_connect_info->cmn_connect_id,
            "receive_file_path"=>$fileName,
            "data_count"=>$data_count,
        );
        $this->order_id=byr_order::insertGetId($order_array);
        // print_r($dataArr);
        // return $dataArr;
        $insert_array=array();
        foreach ($dataArr as $key => $value) {
            // $temp_array['file_name']=$fileName;
            $temp_array['byr_order_id']=$this->order_id;
            // $temp_array['customer_id']=$this->customer_id;
            $temp_array['sta_sen_identifier']=$value[0];
            $temp_array['sta_sen_ide_authority']=$value[1];
            $temp_array['sta_rec_identifier']=$value[2];
            $temp_array['sta_rec_ide_authority']=$value[3];
            $temp_array['sta_doc_standard']=$value[4];
            $temp_array['sta_doc_type_version']=$value[5];
            $temp_array['sta_doc_instance_identifier']=$value[6];
            $temp_array['sta_doc_type']=$value[7];
            $temp_array['sta_doc_creation_date_and_time']=$value[8];
            $temp_array['sta_bus_scope_type']=$value[9];
            $temp_array['sta_bus_scope_instance_identifier']=$value[10];
            $temp_array['sta_bus_scope_identifier']=$value[11];
            $temp_array['mes_ent_unique_creator_identification']=$value[12];
            $temp_array['mes_mes_sender_station_address']=$value[13];
            $temp_array['mes_mes_ultimate_receiver_station_address']=$value[14];
            $temp_array['mes_mes_immediate_receiver_station_addres']=$value[15];
            $temp_array['mes_mes_number_of_trading_documents']=$value[16];
            $temp_array['mes_mes_sys_key']=$value[17];
            $temp_array['mes_mes_sys_value']=$value[18];
            $temp_array['mes_lis_con_version']=$value[19];
            $temp_array['mes_lis_doc_version']=$value[20];
            $temp_array['mes_lis_ext_namespace']=$value[21];
            $temp_array['mes_lis_ext_version']=$value[22];
            $temp_array['mes_lis_pay_code']=$value[23];
            $temp_array['mes_lis_pay_gln']=$value[24];
            $temp_array['mes_lis_pay_name']=$value[25];
            $temp_array['mes_lis_pay_name_sbcs']=$value[26];
            $temp_array['mes_lis_buy_code']=$value[27];
            $temp_array['mes_lis_buy_gln']=$value[28];
            $temp_array['mes_lis_buy_name']=$value[29];
            $temp_array['mes_lis_buy_name_sbcs']=$value[30];
            $temp_array['mes_lis_ord_tra_trade_number']=$value[31];
            $temp_array['mes_lis_ord_tra_additional_trade_number']=$value[32];
            $temp_array['mes_lis_ord_par_shi_code']=$value[33];
            $temp_array['mes_lis_ord_par_shi_gln']=$value[34];
            $temp_array['mes_lis_ord_par_shi_name']=$value[35];
            $temp_array['mes_lis_ord_par_shi_name_sbcs']=$value[36];
            $temp_array['mes_lis_ord_par_rec_code']=$value[37];
            $temp_array['mes_lis_ord_par_rec_gln']=$value[38];
            $temp_array['mes_lis_ord_par_rec_name']=$value[39];
            $temp_array['mes_lis_ord_par_rec_name_sbcs']=$value[40];
            $temp_array['mes_lis_ord_par_tra_code']=$value[41];
            $temp_array['mes_lis_ord_par_tra_gln']=$value[42];
            $temp_array['mes_lis_ord_par_tra_name']=$value[43];
            $temp_array['mes_lis_ord_par_tra_name_sbcs']=$value[44];
            $temp_array['mes_lis_ord_par_dis_code']=$value[45];
            $temp_array['mes_lis_ord_par_dis_name']=$value[46];
            $temp_array['mes_lis_ord_par_dis_name_sbcs']=$value[47];
            $temp_array['mes_lis_ord_par_pay_code']=$value[48];
            $temp_array['mes_lis_ord_par_pay_gln']=$value[49];
            $temp_array['mes_lis_ord_par_pay_name']=$value[50];
            $temp_array['mes_lis_ord_par_pay_name_sbcs']=$value[51];
            $temp_array['mes_lis_ord_par_sel_code']=$value[52];
            $temp_array['mes_lis_ord_par_sel_gln']=$value[53];
            $temp_array['mes_lis_ord_par_sel_name']=$value[54];
            $temp_array['mes_lis_ord_par_sel_name_sbcs']=$value[55];
            $temp_array['mes_lis_ord_par_sel_branch_number']=$value[56];
            $temp_array['mes_lis_ord_par_sel_ship_location_code']=$value[57];
            $temp_array['mes_lis_ord_log_shi_gln']=$value[58];
            $temp_array['mes_lis_ord_log_del_route_code']=$value[59];
            $temp_array['mes_lis_ord_log_del_delivery_service_code']=$value[60];
            $temp_array['mes_lis_ord_log_del_stock_transfer_code']=$value[61];
            $temp_array['mes_lis_ord_log_del_delivery_code']=$value[62];
            $temp_array['mes_lis_ord_log_del_delivery_time']=$value[63];
            $temp_array['mes_lis_ord_log_del_transportation_code']=$value[64];
            $temp_array['mes_lis_ord_log_log_barcode_print']=$value[65];
            $temp_array['mes_lis_ord_log_log_category_name_print1']=$value[66];
            $temp_array['mes_lis_ord_log_log_category_name_print2']=$value[67];
            $temp_array['mes_lis_ord_log_log_receiver_abbr_name']=$value[68];
            $temp_array['mes_lis_ord_log_log_text']=$value[69];
            $temp_array['mes_lis_ord_log_log_text_sbcs']=$value[70];
            $temp_array['mes_lis_ord_tra_goo_major_category']=$value[71];
            $temp_array['mes_lis_ord_tra_goo_sub_major_category']=$value[72];
            $temp_array['mes_lis_ord_tra_dat_order_date']=$value[73];
            $temp_array['mes_lis_ord_tra_dat_delivery_date']=$value[74];
            $temp_array['mes_lis_ord_tra_dat_delivery_date_to_receiver']=$value[75];
            $temp_array['mes_lis_ord_tra_dat_transfer_of_ownership_date']=$value[76];
            $temp_array['mes_lis_ord_tra_dat_campaign_start_date']=$value[77];
            $temp_array['mes_lis_ord_tra_dat_campaign_end_date']=$value[78];
            $temp_array['mes_lis_ord_tra_dat_valid_until_date']=$value[79];
            $temp_array['mes_lis_ord_tra_ins_goods_classification_code']=$value[80];
            $temp_array['mes_lis_ord_tra_ins_order_classification_code']=$value[81];
            $temp_array['mes_lis_ord_tra_ins_ship_notification_request_code']=$value[82];
            $temp_array['mes_lis_ord_tra_ins_private_brand_code']=$value[83];
            $temp_array['mes_lis_ord_tra_ins_temperature_code']=$value[84];
            $temp_array['mes_lis_ord_tra_ins_liquor_code']=$value[85];
            $temp_array['mes_lis_ord_tra_ins_trade_type_code']=$value[86];
            $temp_array['mes_lis_ord_tra_ins_paper_form_less_code']=$value[87];
            $temp_array['mes_lis_ord_tra_fre_trade_number_request_code']=$value[88];
            $temp_array['mes_lis_ord_tra_fre_package_code']=$value[89];
            $temp_array['mes_lis_ord_tra_fre_variable_measure_item_code']=$value[90];
            $temp_array['mes_lis_ord_tra_tax_tax_type_code']=$value[91];
            $temp_array['mes_lis_ord_tra_tax_tax_rate']=$value[92];
            $temp_array['mes_lis_ord_tra_not_text']=$value[93];
            $temp_array['mes_lis_ord_tra_not_text_sbcs']=$value[94];
            $temp_array['mes_lis_ord_tot_tot_net_price_total']=$value[95];
            $temp_array['mes_lis_ord_tot_tot_selling_price_total']=$value[96];
            $temp_array['mes_lis_ord_tot_tot_tax_total']=$value[97];
            $temp_array['mes_lis_ord_tot_tot_item_total']=$value[98];
            $temp_array['mes_lis_ord_tot_tot_unit_total']=$value[99];
            $temp_array['mes_lis_ord_tot_fre_unit_weight_total']=$value[100];
            $temp_array['mes_lis_ord_lin_lin_line_number']=$value[101];
            $temp_array['mes_lis_ord_lin_lin_additional_line_number']=$value[102];
            $temp_array['mes_lis_ord_lin_fre_trade_number']=$value[103];
            $temp_array['mes_lis_ord_lin_fre_line_number']=$value[104];
            $temp_array['mes_lis_ord_lin_goo_minor_category']=$value[105];
            $temp_array['mes_lis_ord_lin_goo_detailed_category']=$value[106];
            $temp_array['mes_lis_ord_lin_ite_scheduled_date']=$value[107];
            $temp_array['mes_lis_ord_lin_ite_deadline_date']=$value[108];
            $temp_array['mes_lis_ord_lin_ite_center_delivery_instruction_code']=$value[109];
            $temp_array['mes_lis_ord_lin_ite_maker_code']=$value[110];
            $temp_array['mes_lis_ord_lin_ite_gtin']=$value[111];
            $temp_array['mes_lis_ord_lin_ite_order_item_code']=$value[112];
            $temp_array['mes_lis_ord_lin_ite_code_type']=$value[113];
            $temp_array['mes_lis_ord_lin_ite_supplier_item_code']=$value[114];
            $temp_array['mes_lis_ord_lin_ite_name']=$value[115];
            $temp_array['mes_lis_ord_lin_ite_name_sbcs']=$value[116];
            $temp_array['mes_lis_ord_lin_ite_ite_spec']=$value[117];
            $temp_array['mes_lis_ord_lin_ite_ite_spec_sbcs']=$value[118];
            $temp_array['mes_lis_ord_lin_ite_col_color_code']=$value[119];
            $temp_array['mes_lis_ord_lin_ite_col_description']=$value[120];
            $temp_array['mes_lis_ord_lin_ite_col_description_sbcs']=$value[121];
            $temp_array['mes_lis_ord_lin_ite_siz_size_code']=$value[122];
            $temp_array['mes_lis_ord_lin_ite_siz_description']=$value[123];
            $temp_array['mes_lis_ord_lin_ite_siz_description_sbcs']=$value[124];
            $temp_array['mes_lis_ord_lin_fre_packing_quantity']=$value[125];
            $temp_array['mes_lis_ord_lin_fre_prefecture_code']=$value[126];
            $temp_array['mes_lis_ord_lin_fre_country_code']=$value[127];
            $temp_array['mes_lis_ord_lin_fre_field_name']=$value[128];
            $temp_array['mes_lis_ord_lin_fre_water_area_code']=$value[129];
            $temp_array['mes_lis_ord_lin_fre_water_area_name']=$value[130];
            $temp_array['mes_lis_ord_lin_fre_area_of_origin']=$value[131];
            $temp_array['mes_lis_ord_lin_fre_item_grade']=$value[132];
            $temp_array['mes_lis_ord_lin_fre_item_class']=$value[133];
            $temp_array['mes_lis_ord_lin_fre_brand']=$value[134];
            $temp_array['mes_lis_ord_lin_fre_item_pr']=$value[135];
            $temp_array['mes_lis_ord_lin_fre_bio_code']=$value[136];
            $temp_array['mes_lis_ord_lin_fre_breed_code']=$value[137];
            $temp_array['mes_lis_ord_lin_fre_cultivation_code']=$value[138];
            $temp_array['mes_lis_ord_lin_fre_defrost_code']=$value[139];
            $temp_array['mes_lis_ord_lin_fre_item_preservation_code']=$value[140];
            $temp_array['mes_lis_ord_lin_fre_item_shape_code']=$value[141];
            $temp_array['mes_lis_ord_lin_fre_use']=$value[142];
            $temp_array['mes_lis_ord_lin_sta_statutory_classification_code']=$value[143];
            $temp_array['mes_lis_ord_lin_amo_item_net_price']=$value[144];
            $temp_array['mes_lis_ord_lin_amo_item_net_price_unit_price']=$value[145];
            $temp_array['mes_lis_ord_lin_amo_item_selling_price']=$value[146];
            $temp_array['mes_lis_ord_lin_amo_item_selling_price_unit_price']=$value[147];
            $temp_array['mes_lis_ord_lin_amo_item_tax']=$value[148];
            $temp_array['mes_lis_ord_lin_qua_unit_multiple']=$value[149];
            $temp_array['mes_lis_ord_lin_qua_unit_of_measure']=$value[150];
            $temp_array['mes_lis_ord_lin_qua_package_indicator']=$value[151];
            $temp_array['mes_lis_ord_lin_qua_ord_quantity']=$value[152];
            $temp_array['mes_lis_ord_lin_qua_ord_num_of_order_units']=$value[153];
            $temp_array['mes_lis_ord_lin_fre_unit_weight']=$value[154];
            $temp_array['mes_lis_ord_lin_fre_unit_weight_code']=$value[155];
            $temp_array['mes_lis_ord_lin_fre_item_weight']=$value[156];
            $temp_array['mes_lis_ord_lin_fre_order_weight']=$value[157];
            // 158 done 
            $insert_array[]=$temp_array;
        }
        // return $insert_array;
        foreach (array_chunk($insert_array,300) as $t)  
        {
            bms_order::insert($t); 
        }
        return response()->json(['message' => 'File inserted', 'class_name' => 'alert-success', 'status_code' => 200]);
       
    }
}
