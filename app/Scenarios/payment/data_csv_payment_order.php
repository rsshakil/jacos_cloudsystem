<?php

namespace App\Scenarios\payment;

use App\Scenarios\Common;
use Illuminate\Database\Eloquent\Model;
use App\Models\DATA\PAYMENT\data_payment;
use App\Models\DATA\PAYMENT\data_payment_pay;
use App\Models\DATA\PAYMENT\data_payment_pay_detail;
use App\Http\Controllers\API\AllUsedFunction;
use DB;

class data_csv_payment_order extends Model
{
    private $all_functions;
    public function __construct()
    {
        $this->common_class_obj = new Common();
        $this->all_functions = new AllUsedFunction();
    }

    public function exec($request, $sc)
    {
        \Log::debug(get_class().' exec start  ---------------');
        if (!array_key_exists('up_file',$request->all())) {
            // return response()->json(['message' => "error", 'status' => '0']);
            return ['message' => "error", 'status' => '0'];
        }
        // ファイルアップロード
        $file_name = time().'-'.$request->file('up_file')->getClientOriginalName();
        // return response()->json(['file_name'=>$file_name,'status'=>0]);
        $path = $request->file('up_file')->storeAs(config('const.PAYMENT_DATA_PATH').date('Y-m'), $file_name);
        \Log::debug('save path:'.$path);

        $received_path = storage_path().'/app//'.config('const.PAYMENT_DATA_PATH').date('Y-m').'/'.$file_name;
        // フォーマット変換

        $dataArr = $this->all_functions->csvReader($received_path, 1);
        // $cmn_connect_id=$this->all_functions->get_connect_id_from_file_name($file_name);

        // $order_flg = true;
        // $trade_number = '';

        foreach ($dataArr as $key => $value) {
            if (count($value) === 1) {
                // 空であればcontinue
                continue;
            }

            // if ($order_flg) {
                $data_payment_array['sta_sen_identifier']=$value[0];
                $data_payment_array['sta_sen_ide_authority']=$value[1];
                $data_payment_array['sta_rec_identifier']=$value[2];
                $data_payment_array['sta_rec_ide_authority']=$value[3];
                $data_payment_array['sta_doc_standard']=$value[4];
                $data_payment_array['sta_doc_type_version']=$value[5];
                $data_payment_array['sta_doc_instance_identifier']=$value[6];
                $data_payment_array['sta_doc_type']=$value[7];
                $data_payment_array['sta_doc_creation_date_and_time']=$value[8];
                $data_payment_array['sta_bus_scope_type']=$value[9];
                $data_payment_array['sta_bus_scope_instance_identifier']=$value[10];
                $data_payment_array['sta_bus_scope_identifier']=$value[11];
                $data_payment_array['mes_ent_unique_creator_identification']=$value[12];
                $data_payment_array['mes_mes_sender_station_address']=$value[13];
                $data_payment_array['mes_mes_ultimate_receiver_station_address']=$value[14];
                $data_payment_array['mes_mes_immediate_receiver_station_addres']=$value[15];
                $data_payment_array['mes_mes_number_of_trading_documents']=$value[16];
                $data_payment_array['mes_mes_system_info']=""; //New added
                $data_payment_array['mes_mes_sys_key']=$value[17];
                $data_payment_array['mes_mes_sys_value']=$value[18];
                $data_payment_array['mes_lis_con_version']=$value[19];
                $data_payment_array['mes_lis_doc_version']=$value[20];
                $data_payment_array['mes_lis_ext_version']=$value[22];
                $data_payment_array['mes_lis_pay_code']=$value[23];
                $data_payment_array['mes_lis_pay_gln']=$value[24];
                $data_payment_array['mes_lis_pay_name']=$value[25];
                $data_payment_array['mes_lis_pay_name_sbcs']=$value[26];

                $data_payment_id = data_payment::insertGetId($data_payment_array);

            //     $order_flg =false;
            // }
            // if ($trade_number !=$value[31].'-'.$value[32]) {
                $data_payment_pay_array['mes_lis_buy_code']=$value[27];
                $data_payment_pay_array['mes_lis_buy_gln']=$value[28];
                $data_payment_pay_array['mes_lis_buy_name']=$value[29];
                $data_payment_pay_array['mes_lis_buy_name_sbcs']=$value[30];
                $data_payment_pay_array['mes_lis_pay_pay_code']=$value[32];
                $data_payment_pay_array['mes_lis_pay_pay_id']=$value[31];  //new added
                $data_payment_pay_array['mes_lis_pay_pay_gln']=$value[33];
                $data_payment_pay_array['mes_lis_pay_pay_name']=$value[34];
                $data_payment_pay_array['mes_lis_pay_pay_name_sbcs']=$value[35];
                $data_payment_pay_array['mes_lis_pay_per_begin_date']=$value[36]; //new added
                $data_payment_pay_array['mes_lis_pay_per_end_date']=$value[37]; // new added
                $data_payment_pay_array['data_payment_id']=$data_payment_id;
                $data_payment_pay_id = data_payment_pay::insertGetId($data_payment_pay_array);

            // }
 //new Added
            $data_payment_details_array['mes_lis_pay_lin_lin_trade_number_eference']=$value[38];
            $data_payment_details_array['mes_lis_pay_lin_lin_issue_classification_code']=$value[39];
            $data_payment_details_array['mes_lis_pay_lin_lin_sequence_number']=$value[40];
            $data_payment_details_array['mes_lis_pay_lin_tra_code']=$value[41];
            $data_payment_details_array['mes_lis_pay_lin_tra_gln']=$value[42];
            $data_payment_details_array['mes_lis_pay_lin_tra_name']=$value[43];
            $data_payment_details_array['mes_lis_pay_lin_tra_name_sbcs']=$value[44];
            $data_payment_details_array['mes_lis_pay_lin_sel_code']=$value[45];
            $data_payment_details_array['mes_lis_pay_lin_sel_gln']=$value[46];
            $data_payment_details_array['mes_lis_pay_lin_sel_name']=$value[47];
            $data_payment_details_array['mes_lis_pay_lin_sel_name_sbcs']=$value[48];
            $data_payment_details_array['mes_lis_pay_lin_det_goo_major_category']=$value[49];
            $data_payment_details_array['mes_lis_pay_lin_det_goo_sub_major_category']=$value[50];
            $data_payment_details_array['mes_lis_pay_lin_det_transfer_of_ownership_date']=$value[51];
            $data_payment_details_array['mes_lis_pay_lin_det_pay_out_date']=$value[52];
            $data_payment_details_array['mes_lis_pay_lin_det_amo_requested_amount']=$value[53];
            $data_payment_details_array['mes_lis_pay_lin_det_amo_req_plus_minus']=$value[54];
            $data_payment_details_array['mes_lis_pay_lin_det_amo_payable_amount']=$value[55];
            $data_payment_details_array['mes_lis_pay_lin_det_amo_pay_plus_minus']=$value[56];
            $data_payment_details_array['mes_lis_pay_lin_det_amo_optional_amount']=$value[57];
            $data_payment_details_array['mes_lis_pay_lin_det_amo_opt_plus_minus']=$value[58];
            $data_payment_details_array['mes_lis_pay_lin_det_amo_tax']=$value[59];
            $data_payment_details_array['mes_lis_pay_lin_det_trade_type_code']=$value[60];
            $data_payment_details_array['mes_lis_pay_lin_det_balance_carried_code']=$value[61];
            $data_payment_details_array['mes_lis_pay_lin_det_creditor_unsettled_code']=$value[62];
            $data_payment_details_array['mes_lis_pay_lin_det_verification_result_code']=$value[63];
            $data_payment_details_array['mes_lis_pay_lin_det_pay_code']=$value[64];
            $data_payment_details_array['mes_lis_pay_lin_det_det_code']=$value[65];
            $data_payment_details_array['mes_lis_pay_lin_det_det_meaning']=$value[66];
            $data_payment_details_array['mes_lis_pay_lin_det_det_meaning_sbcs']=$value[67];
            $data_payment_details_array['mes_lis_pay_lin_det_payment_method_code']=$value[68];
            $data_payment_details_array['mes_lis_pay_lin_det_tax_tax_type_code']=$value[69];
            $data_payment_details_array['mes_lis_pay_lin_det_tax_tax_rate']=$value[70];
 //new Added
            $data_payment_details_array['data_payment_pay_id']=$data_payment_pay_id;
            data_payment_pay_detail::insert($data_payment_details_array);


            // format
            $data_payment_array=array();
            $data_payment_pay_array=array();
            $data_payment_details_array=array();
        }
        return ['message' => "success", 'status' => '1'];
    }
}
