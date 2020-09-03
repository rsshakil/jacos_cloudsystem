<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\AllUsedFunction;
use App\User;
use App\Byr_order;
use App\bms_order;
use App\cmn_job;

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
        $this->order_id=Byr_order::insertGetId($order_array);
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
            $temp_array['sta_doc_typeVersion']=$value[5];
            $temp_array['sta_doc_instanceIdentifier']=$value[6];
            $temp_array['sta_doc_type']=$value[7];
            $temp_array['sta_doc_creationDateAndTime']=$value[8];
            $temp_array['sta_bus_scope_type']=$value[9];
            $temp_array['sta_bus_scope_instanceIdentifier']=$value[10];
            $temp_array['sta_bus_scope_identifier']=$value[11];
            $temp_array['mes_ent_uniqueCreatorIdentification']=$value[12];
            $temp_array['mes_mes_senderStationAddress']=$value[13];
            $temp_array['mes_mes_ultimateReceiverStationAddress']=$value[14];
            $temp_array['mes_mes_immediateReceiverStationAddres']=$value[15];
            $temp_array['mes_mes_numberOfTradingDocuments']=$value[16];
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
            $temp_array['mes_lis_ord_tra_tradeNumber']=$value[31];
            $temp_array['mes_lis_ord_tra_additionalTradeNumber']=$value[32];
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
            $temp_array['mes_lis_ord_par_sel_branchNumber']=$value[56];
            $temp_array['mes_lis_ord_par_sel_shipLocationCode']=$value[57];
            $temp_array['mes_lis_ord_log_shi_gln']=$value[58];
            $temp_array['mes_lis_ord_log_del_routeCode']=$value[59];
            $temp_array['mes_lis_ord_log_del_deliveryServiceCode']=$value[60];
            $temp_array['mes_lis_ord_log_del_stockTransferCode']=$value[61];
            $temp_array['mes_lis_ord_log_del_deliveryCode']=$value[62];
            $temp_array['mes_lis_ord_log_del_deliveryTime']=$value[63];
            $temp_array['mes_lis_ord_log_del_transportationCode']=$value[64];
            $temp_array['mes_lis_ord_log_log_barcodePrint']=$value[65];
            $temp_array['mes_lis_ord_log_log_categoryNamePrint1']=$value[66];
            $temp_array['mes_lis_ord_log_log_categoryNamePrint2']=$value[67];
            $temp_array['mes_lis_ord_log_log_receiverAbbrName']=$value[68];
            $temp_array['mes_lis_ord_log_log_text']=$value[69];
            $temp_array['mes_lis_ord_log_log_text_sbcs']=$value[70];
            $temp_array['mes_lis_ord_tra_goo_majorCategory']=$value[71];
            $temp_array['mes_lis_ord_tra_goo_subMajorCategory']=$value[72];
            $temp_array['mes_lis_ord_tra_dat_orderDate']=$value[73];
            $temp_array['mes_lis_ord_tra_dat_deliveryDate']=$value[74];
            $temp_array['mes_lis_ord_tra_dat_deliveryDateToReceiver']=$value[75];
            $temp_array['mes_lis_ord_tra_dat_transferOfOwnershipDate']=$value[76];
            $temp_array['mes_lis_ord_tra_dat_campaignStartDate']=$value[77];
            $temp_array['mes_lis_ord_tra_dat_campaignEndDate']=$value[78];
            $temp_array['mes_lis_ord_tra_dat_validUntilDate']=$value[79];
            $temp_array['mes_lis_ord_tra_ins_goodsClassificationCode']=$value[80];
            $temp_array['mes_lis_ord_tra_ins_orderClassificationCode']=$value[81];
            $temp_array['mes_lis_ord_tra_ins_shipNotificationRequestCode']=$value[82];
            $temp_array['mes_lis_ord_tra_ins_privateBrandCode']=$value[83];
            $temp_array['mes_lis_ord_tra_ins_temperatureCode']=$value[84];
            $temp_array['mes_lis_ord_tra_ins_liquorCode']=$value[85];
            $temp_array['mes_lis_ord_tra_ins_tradeTypeCode']=$value[86];
            $temp_array['mes_lis_ord_tra_ins_paperFormLessCode']=$value[87];
            $temp_array['mes_lis_ord_tra_fre_tradeNumberRequestCode']=$value[88];
            $temp_array['mes_lis_ord_tra_fre_packageCode']=$value[89];
            $temp_array['mes_lis_ord_tra_fre_variableMeasureItemCode']=$value[90];
            $temp_array['mes_lis_ord_tra_tax_taxTypeCode']=$value[91];
            $temp_array['mes_lis_ord_tra_tax_taxRate']=$value[92];
            $temp_array['mes_lis_ord_tra_not_text']=$value[93];
            $temp_array['mes_lis_ord_tra_not_text_sbcs']=$value[94];
            $temp_array['mes_lis_ord_tot_tot_netPriceTotal']=$value[95];
            $temp_array['mes_lis_ord_tot_tot_sellingPriceTotal']=$value[96];
            $temp_array['mes_lis_ord_tot_tot_taxTotal']=$value[97];
            $temp_array['mes_lis_ord_tot_tot_itemTotal']=$value[98];
            $temp_array['mes_lis_ord_tot_tot_unitTotal']=$value[99];
            $temp_array['mes_lis_ord_tot_fre_unitWeightTotal']=$value[100];
            $temp_array['mes_lis_ord_lin_lin_lineNumber']=$value[101];
            $temp_array['mes_lis_ord_lin_lin_additionalLineNumber']=$value[102];
            $temp_array['mes_lis_ord_lin_fre_tradeNumber']=$value[103];
            $temp_array['mes_lis_ord_lin_fre_lineNumber']=$value[104];
            $temp_array['mes_lis_ord_lin_goo_minorCategory']=$value[105];
            $temp_array['mes_lis_ord_lin_goo_detailedCategory']=$value[106];
            $temp_array['mes_lis_ord_lin_ite_scheduledDate']=$value[107];
            $temp_array['mes_lis_ord_lin_ite_deadlineDate']=$value[108];
            $temp_array['mes_lis_ord_lin_ite_centerDeliveryInstructionCode']=$value[109];
            $temp_array['mes_lis_ord_lin_ite_makerCode']=$value[110];
            $temp_array['mes_lis_ord_lin_ite_gtin']=$value[111];
            $temp_array['mes_lis_ord_lin_ite_orderItemCode']=$value[112];
            $temp_array['mes_lis_ord_lin_ite_codeType']=$value[113];
            $temp_array['mes_lis_ord_lin_ite_supplierItemCode']=$value[114];
            $temp_array['mes_lis_ord_lin_ite_name']=$value[115];
            $temp_array['mes_lis_ord_lin_ite_name_sbcs']=$value[116];
            $temp_array['mes_lis_ord_lin_ite_ite_spec']=$value[117];
            $temp_array['mes_lis_ord_lin_ite_ite_spec_sbcs']=$value[118];
            $temp_array['mes_lis_ord_lin_ite_col_colorCode']=$value[119];
            $temp_array['mes_lis_ord_lin_ite_col_description']=$value[120];
            $temp_array['mes_lis_ord_lin_ite_col_description_sbcs']=$value[121];
            $temp_array['mes_lis_ord_lin_ite_siz_sizeCode']=$value[122];
            $temp_array['mes_lis_ord_lin_ite_siz_description']=$value[123];
            $temp_array['mes_lis_ord_lin_ite_siz_description_sbcs']=$value[124];
            $temp_array['mes_lis_ord_lin_fre_packingQuantity']=$value[125];
            $temp_array['mes_lis_ord_lin_fre_prefectureCode']=$value[126];
            $temp_array['mes_lis_ord_lin_fre_countryCode']=$value[127];
            $temp_array['mes_lis_ord_lin_fre_fieldName']=$value[128];
            $temp_array['mes_lis_ord_lin_fre_waterAreaCode']=$value[129];
            $temp_array['mes_lis_ord_lin_fre_waterAreaName']=$value[130];
            $temp_array['mes_lis_ord_lin_fre_areaOfOrigin']=$value[131];
            $temp_array['mes_lis_ord_lin_fre_itemGrade']=$value[132];
            $temp_array['mes_lis_ord_lin_fre_itemClass']=$value[133];
            $temp_array['mes_lis_ord_lin_fre_brand']=$value[134];
            $temp_array['mes_lis_ord_lin_fre_itemPR']=$value[135];
            $temp_array['mes_lis_ord_lin_fre_bioCode']=$value[136];
            $temp_array['mes_lis_ord_lin_fre_breedCode']=$value[137];
            $temp_array['mes_lis_ord_lin_fre_cultivationCode']=$value[138];
            $temp_array['mes_lis_ord_lin_fre_defrostCode']=$value[139];
            $temp_array['mes_lis_ord_lin_fre_itemPreservationCode']=$value[140];
            $temp_array['mes_lis_ord_lin_fre_itemShapeCode']=$value[141];
            $temp_array['mes_lis_ord_lin_fre_use']=$value[142];
            $temp_array['mes_lis_ord_lin_sta_statutoryClassificationCode']=$value[143];
            $temp_array['mes_lis_ord_lin_amo_itemNetPrice']=$value[144];
            $temp_array['mes_lis_ord_lin_amo_itemNetPrice_unitPrice']=$value[145];
            $temp_array['mes_lis_ord_lin_amo_itemSellingPrice']=$value[146];
            $temp_array['mes_lis_ord_lin_amo_itemSellingPrice_unitPrice']=$value[147];
            $temp_array['mes_lis_ord_lin_amo_itemTax']=$value[148];
            $temp_array['mes_lis_ord_lin_qua_unitMultiple']=$value[149];
            $temp_array['mes_lis_ord_lin_qua_unitOfMeasure']=$value[150];
            $temp_array['mes_lis_ord_lin_qua_packageIndicator']=$value[151];
            $temp_array['mes_lis_ord_lin_qua_ord_quantity']=$value[152];
            $temp_array['mes_lis_ord_lin_qua_ord_numOfOrderUnits']=$value[153];
            $temp_array['mes_lis_ord_lin_fre_unitWeight']=$value[154];
            $temp_array['mes_lis_ord_lin_fre_unitWeightCode']=$value[155];
            $temp_array['mes_lis_ord_lin_fre_itemWeight']=$value[156];
            $temp_array['mes_lis_ord_lin_fre_orderWeight']=$value[157];
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
