<?php

namespace App\Scenarios\DATA\INVOICE;

use App\Scenarios\Common;
use App\Models\DATA\SHIPMENT\data_shipment;
use App\Http\Controllers\API\AllUsedFunction;
use App\Models\DATA\INVOICE\data_invoice;
use App\Models\DATA\INVOICE\data_invoice_pay;
use App\Models\DATA\INVOICE\data_invoice_pay_detail;
use DB;

class data_invoice_scheduler
{
    private $all_functions;
    public function __construct()
    {
        // $this->common_class_obj = new Common();
        $this->all_functions = new AllUsedFunction();
    }

    public function exec($request, $sc)
    {
        // \Log::info($request->all());
        // return $request->all();
        $data_order_id=$request->data_order_id;
        $start_date=$request->start_date;
        $end_date=$request->end_date;

        $data_invoice_array=array();
        $data_invoice_pay_array=array();
        $data_invoice_pay_details_array=array();
        $shipment_datas=self::shipmentQuery($data_order_id,$start_date,$end_date);
        $datashipment=true;
        $data_invoice_pay_id=1;
        foreach ($shipment_datas as $key => $shipment_data) {
            if ($datashipment) {
                $data_invoice_array['cmn_connect_id']=$shipment_data['cmn_connect_id'];
                $data_invoice_array['sta_sen_identifier']=$shipment_data['sta_sen_identifier'];
                $data_invoice_array['sta_sen_ide_authority']=$shipment_data['sta_sen_ide_authority'];
                $data_invoice_array['sta_rec_identifier']=$shipment_data['sta_rec_identifier'];
                $data_invoice_array['sta_rec_ide_authority']=$shipment_data['sta_rec_ide_authority'];
                $data_invoice_array['sta_doc_standard']=$shipment_data['sta_doc_standard'];
                $data_invoice_array['sta_doc_type_version']=$shipment_data['sta_doc_type_version'];
                $data_invoice_array['sta_doc_instance_identifier']=$shipment_data['sta_doc_instance_identifier'];
                $data_invoice_array['sta_doc_type']=$shipment_data['sta_doc_type'];
                $data_invoice_array['sta_doc_creation_date_and_time']=$shipment_data['sta_doc_creation_date_and_time'];
                $data_invoice_array['sta_bus_scope_instance_identifier']=$shipment_data['sta_bus_scope_instance_identifier'];
                $data_invoice_array['sta_bus_scope_type']=$shipment_data['sta_bus_scope_type'];
                $data_invoice_array['sta_bus_scope_identifier']=$shipment_data['sta_bus_scope_identifier'];
                $data_invoice_array['mes_ent_unique_creator_identification']=$shipment_data['mes_ent_unique_creator_identification'];
                $data_invoice_array['mes_mes_sender_station_address']=$shipment_data['mes_mes_sender_station_address'];
                $data_invoice_array['mes_mes_ultimate_receiver_station_address']=$shipment_data['mes_mes_ultimate_receiver_station_address'];
                $data_invoice_array['mes_mes_immediate_receiver_station_addres']=$shipment_data['mes_mes_immediate_receiver_station_addres'];
                $data_invoice_array['mes_mes_number_of_trading_documents']=$shipment_data['mes_mes_number_of_trading_documents'];
                $data_invoice_array['mes_mes_sys_key']=$shipment_data['mes_mes_sys_key'];
                $data_invoice_array['mes_mes_sys_value']=$shipment_data['mes_mes_sys_value'];
                $data_invoice_array['mes_lis_con_version']=$shipment_data['mes_lis_con_version'];
                $data_invoice_array['mes_lis_doc_version']=$shipment_data['mes_lis_doc_version'];
                $data_invoice_array['mes_lis_ext_namespace']=$shipment_data['mes_lis_ext_namespace'];
                $data_invoice_array['mes_lis_ext_version']=$shipment_data['mes_lis_ext_version'];
                $data_invoice_array['mes_lis_pay_code']=$shipment_data['mes_lis_pay_code'];
                $data_invoice_array['mes_lis_pay_gln']=$shipment_data['mes_lis_pay_gln'];
                $data_invoice_array['mes_lis_pay_name']=$shipment_data['mes_lis_pay_name'];
                $data_invoice_array['mes_lis_pay_name_sbcs']=$shipment_data['mes_lis_pay_name_sbcs'];
                $datashipment=false;
                $data_invoice_id=data_invoice::insertGetId($data_invoice_array);
            }

                $data_invoice_pay_array['mes_lis_buy_code']=$shipment_data['mes_lis_buy_code'];
                $data_invoice_pay_array['mes_lis_buy_gln']=$shipment_data['mes_lis_buy_gln'];
                $data_invoice_pay_array['mes_lis_buy_name']=$shipment_data['mes_lis_buy_name'];
                $data_invoice_pay_array['mes_lis_buy_name_sbcs']=$shipment_data['mes_lis_buy_name_sbcs'];
                //static
                $data_invoice_pay_array['mes_lis_inv_pay_id']='';
                $data_invoice_pay_array['mes_lis_inv_pay_code']='';
                $data_invoice_pay_array['mes_lis_inv_pay_gln']='';
                $data_invoice_pay_array['mes_lis_inv_pay_name']='';
                $data_invoice_pay_array['mes_lis_inv_pay_name_sbcs']='';
                $data_invoice_pay_array['mes_lis_inv_per_begin_date']=$start_date;
                $data_invoice_pay_array['mes_lis_inv_per_end_date']=$end_date;
                //static


                $data_invoice_pay_count = data_invoice_pay::where($data_invoice_pay_array)->get()->count();
                if (!$data_invoice_pay_count) {
                    $data_invoice_pay_array['data_invoice_id']=$data_invoice_id;
                    $data_invoice_pay_id = data_invoice_pay::insertGetId($data_invoice_pay_array);
                }

                $data_invoice_pay_details_array['mes_lis_inv_lin_lin_trade_number_reference']=$shipment_data['mes_lis_shi_tra_trade_number'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_lin_issue_classification_code']=$shipment_data['mes_lis_shi_tra_additional_trade_number'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_lin_sequence_number']=$shipment_data['mes_lis_shi_fre_shipment_number'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_tra_code']=$shipment_data['mes_lis_shi_par_shi_code'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_tra_gln']=$shipment_data['mes_lis_shi_par_shi_gln'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_tra_name']=$shipment_data['mes_lis_shi_par_shi_name'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_tra_name_sbcs']=$shipment_data['mes_lis_shi_par_shi_name_sbcs'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_sel_code']=$shipment_data['mes_lis_shi_par_sel_code'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_sel_gln']=$shipment_data['mes_lis_shi_par_sel_gln'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_sel_name']=$shipment_data['mes_lis_shi_par_sel_name'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_sel_name_sbcs']=$shipment_data['mes_lis_shi_par_sel_name_sbcs'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_det_goo_major_category']=$shipment_data['mes_lis_shi_tra_goo_major_category'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_det_goo_sub_major_category']=$shipment_data['mes_lis_shi_tra_goo_sub_major_category'];
                $data_invoice_pay_details_array['mes_lis_inv_lin_det_transfer_of_ownership_date']=$shipment_data['mes_lis_shi_tra_dat_transfer_of_ownership_date'];
                //static
                $data_invoice_pay_details_array['mes_lis_inv_lin_det_amo_requested_amount']='';
                $data_invoice_pay_details_array['mes_lis_inv_lin_det_amo_req_plus_minus']='';
                $data_invoice_pay_details_array['mes_lis_inv_lin_det_amo_tax']='';
                $data_invoice_pay_details_array['mes_lis_inv_lin_det_balance_carried_code']='';
                $data_invoice_pay_details_array['mes_lis_inv_lin_det_credit_or_unsettlement']='';
                $data_invoice_pay_details_array['mes_lis_inv_lin_det_pay_code']='';
                $data_invoice_pay_details_array['mes_lis_inv_lin_det_tax_tax_type_code']='';
                $data_invoice_pay_details_array['mes_lis_inv_lin_det_tax_tax_rate']='';
                 //static
                $data_invoice_pay_details_array['data_invoice_pay_id']=$data_invoice_pay_id;
                data_invoice_pay_detail::insert($data_invoice_pay_details_array);

                $data_invoice_array=array();
                $data_invoice_pay_array=array();
                $data_invoice_pay_details_array=array();
        }

        return ['message' => "success", 'status' => '1'];
    }
    public static function shipmentQuery($data_order_id,$start_date,$end_date){
        $start_date = $start_date!=null? date('Y-m-d 00:00:00',strtotime($start_date)):$start_date;
        $end_date = $end_date!=null? date('Y-m-d 23:59:59',strtotime($end_date)):$end_date;
        $shipment_datas=data_shipment::select(
            'data_shipments.cmn_connect_id',
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
        'data_shipment_vouchers.*','data_shipment_items.*','data_shipment_item_details.*')
        ->join('data_shipment_vouchers','data_shipment_vouchers.data_shipment_id','data_shipments.data_shipment_id')
        ->join('data_shipment_items','data_shipment_items.data_shipment_voucher_id','data_shipment_vouchers.data_shipment_voucher_id')
        ->join('data_shipment_item_details','data_shipment_item_details.data_shipment_item_id','data_shipment_items.data_shipment_item_id')
        ->where('data_shipments.data_order_id',$data_order_id)
        // ->whereBetween('data_shipment_vouchers.mes_lis_shi_tra_dat_transfer_of_ownership_date', [$start_date, $end_date])
        ->get();
        return $shipment_datas;
    }
}