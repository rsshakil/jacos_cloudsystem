<?php

namespace App\Scenarios;

use App\Scenarios\Common;
use Illuminate\Database\Eloquent\Model;
use App\Models\DATA\ORD\data_order;
use App\Models\DATA\ORD\data_order_voucher;
use App\Models\DATA\ORD\data_order_item;
use App\Models\DATA\SHIPMENT\data_shipment;
use App\Models\DATA\SHIPMENT\data_shipment_voucher;
use App\Models\DATA\SHIPMENT\data_shipment_item;
use App\Models\DATA\SHIPMENT\data_shipment_item_detail;
use App\Http\Controllers\API\AllUsedFunction;
use DB;

class data_csv_order extends Model
{
    private $all_functions;
    private $common_class_obj;
    public function __construct()
    {
        $this->common_class_obj = new Common();
        $this->all_functions = new AllUsedFunction();
    }
    private $format = [
        [
            "type"=>"header",
            "key"=>["start" => 1,"length" => 2,"value" => "HD"],
            "fmt"=>[
                ["start" => 1,		"length" => 2,"name" => "hd_tag",			"name_jp"=>"タグ"],
                ["start" => 15,		"length" => 8,"name" => "invoice_num",		"name_jp"=>"伝票番号"],
                ["start" => 72,		"length" => 8,"name" => "order_date",	"name_jp"=>"発注日"],
                ["start" => 94,		"length" => 8,"name" => "shipment_date","name_jp"=>"納品指定日"],
                ["start" => 148,	"length" => 4,"name" => "order_class",	"name_jp"=>"発注区分"],
                ["start" => 1197,	"length" => 1,"name" => "auto_order",	"name_jp"=>"自動発注区分"],
                ["start" => 1283,	"length" => 6,"name" => "company_code",	"name_jp"=>"小売企業コード"],
                ["start" => 1296,	"length" => 10,"name" => "company_name_kana","name_jp"=>"小売企業名称(ｶﾅ)"],
                ["start" => 1356,	"length" => 40,"name" => "company_name",	"name_jp"=>"小売企業名称(漢字)"],
                ["start" => 1851,	"length" => 4,"name" => "shop_code",	"name_jp"=>"店舗コード"],
                ["start" => 1864,	"length" => 6,"name" => "purchase_code",	"name_jp"=>"仕入先コード"],
                ["start" => 1877,	"length" => 20,"name" => "purchase_name_kana",	"name_jp"=>"仕入先名称(ｶﾅ)"],
                ["start" => 1897,	"length" => 20,"name" => "purchase_name",	"name_jp"=>"仕入先名称(漢字)"],
                ["start" => 2141,	"length" => 10,"name" => "ship_name_kana",	"name_jp"=>"店舗名称(ｶﾅ)"],
                ["start" => 2171,	"length" => 50,"name" => "ship_name",	"name_jp"=>"店舗名称(漢字)"],
                ["start" => 2405,	"length" => 6,"name" => "transmission_code",	"name_jp"=>"送受信コード"],
                ["start" => 2811,	"length" => 3,"name" => "major_category_code",	"name_jp"=>"大分類コード"],
                ["start" => 2817,	"length" => 20,"name" => "major_category_name_kana",	"name_jp"=>"大分類名称(ｶﾅ)"],
                ["start" => 2847,	"length" => 40,"name" => "major_category_name",	"name_jp"=>"大分類名称(漢字)"],
            ]
        ],
        [
            "type"=>"data",
            "key"=>["start" => 1,"length" => 2,"value" => "DT"],
            "fmt"=>[
                ["start" => 1,		"length" => 2,"name" => "dt_tag",			"name_jp"=>"タグ"],
                ["start" => 3,		"length" => 13,"name" => "jan",		"name_jp"=>"SKU"],
                ["start" => 20,		"length" => 1,"name" => "invoice_line_num",	"name_jp"=>"伝票行番号"],
                ["start" => 67,		"length" => 13,"name" => "own_jan","name_jp"=>"自社品番"],
                ["start" => 80,		"length" => 15,"name" => "maker_jan",	"name_jp"=>"メーカー品番"],
                ["start" => 120,	"length" => 2,"name" => "submajor_category",	"name_jp"=>"中分類"],
                ["start" => 130,	"length" => 2,"name" => "minor_category",	"name_jp"=>"小分類"],
                ["start" => 156,	"length" => 10,"name" => "size_name","name_jp"=>"サイズ名称"],
                ["start" => 360,	"length" => 40,"name" => "item_name",	"name_jp"=>"商品名称(漢字)"],
                ["start" => 430,	"length" => 10,"name" => "brand_name",	"name_jp"=>"ブランド名称"],
                ["start" => 547,	"length" => 10,"name" => "color_name",	"name_jp"=>"カラー名称"],
                ["start" => 669,	"length" => 5,"name" => "order_quentity",	"name_jp"=>"発注数(ﾊﾞﾗ)"],
                ["start" => 697,	"length" => 5,"name" => "order_quentity_original",	"name_jp"=>"発注数(ﾊﾞﾗ)(納品数量元値)"],
                ["start" => 715,	"length" => 9,"name" => "item_price",	"name_jp"=>"原価金額"],
                ["start" => 726,	"length" => 9,"name" => "suggested_retail_price",	"name_jp"=>"標準上代金額"],
                ["start" => 761,	"length" => 7,"name" => "item_unit_price",	"name_jp"=>"原価"],
                ["start" => 772,	"length" => 7,"name" => "suggested_retail_unit_price",	"name_jp"=>"標準上代"],
                ["start" => 786,	"length" => 3,"name" => "lot_quentity",	"name_jp"=>"ロット数"],
            ]
        ],
        [
            "type"=>"footer",
            "key"=>["start" => 1,"length" => 2,"value" => "TR"],
            "fmt"=>[
                ["start" => 1,		"length" => 2,"name" => "tr_tag",			"name_jp"=>"タグ"],
                ["start" => 5,		"length" => 10,"name" => "item_price_total",		"name_jp"=>"原価金額合計"],
                ["start" => 29,		"length" => 10,"name" => "suggested_retail_price_total",	"name_jp"=>"売価金額合計"],
            ]
        ],
    ];

    //
    public function exec($request, $sc)
    {
        \Log::debug(get_class().' exec start  ---------------');

        // ファイルアップロード
        $file_name = time().'-'.$request->file('up_file')->getClientOriginalName();
        return response()->json(['file_name'=>$file_name]);
        $path = $request->file('up_file')->storeAs(config('const.ORDER_DATA_PATH').date('Y-m'), $file_name);
        \Log::debug('save path:'.$path);

        $received_path = storage_path().'/app//'.config('const.ORDER_DATA_PATH').date('Y-m').'/'.$file_name;
        // フォーマット変換

        $dataArr = $this->all_functions->csvReader($received_path, 1);
        $cmn_connect_id=$this->all_functions->get_connect_id_from_file_name($file_name);

        $order_flg = true;
        $trade_number = '';

        foreach ($dataArr as $key => $value) {
            if (count($value) === 1) {
                // 空であればcontinue
                continue;
            }

            if ($order_flg) {
                $data_order_array['sta_sen_identifier']=$value[0];
                $data_order_array['sta_sen_ide_authority']=$value[1];
                $data_order_array['sta_rec_identifier']=$value[2];
                $data_order_array['sta_rec_ide_authority']=$value[3];
                $data_order_array['sta_doc_standard']=$value[4];
                $data_order_array['sta_doc_type_version']=$value[5];
                $data_order_array['sta_doc_instance_identifier']=$value[6];
                $data_order_array['sta_doc_type']=$value[7];
                $data_order_array['sta_doc_creation_date_and_time']=$value[8];
                $data_order_array['sta_bus_scope_type']=$value[9];
                $data_order_array['sta_bus_scope_instance_identifier']=$value[10];
                $data_order_array['sta_bus_scope_identifier']=$value[11];
                $data_order_array['mes_ent_unique_creator_identification']=$value[12];
                $data_order_array['mes_mes_sender_station_address']=$value[13];
                $data_order_array['mes_mes_ultimate_receiver_station_address']=$value[14];
                $data_order_array['mes_mes_immediate_receiver_station_addres']=$value[15];
                $data_order_array['mes_mes_number_of_trading_documents']=$value[16];
                $data_order_array['mes_mes_sys_key']=$value[17];
                $data_order_array['mes_mes_sys_value']=$value[18];
                $data_order_array['mes_lis_con_version']=$value[19];
                $data_order_array['mes_lis_doc_version']=$value[20];
                $data_order_array['mes_lis_ext_namespace']=$value[21];
                $data_order_array['mes_lis_ext_version']=$value[22];
                $data_order_array['mes_lis_pay_code']=$value[23];
                $data_order_array['mes_lis_pay_gln']=$value[24];
                $data_order_array['mes_lis_pay_name']=$value[25];
                $data_order_array['mes_lis_pay_name_sbcs']=$value[26];
                $data_order_array['mes_lis_buy_code']=$value[27];
                $data_order_array['mes_lis_buy_gln']=$value[28];
                $data_order_array['mes_lis_buy_name']=$value[29];
                $data_order_array['mes_lis_buy_name_sbcs']=$value[30];

                // Order
                $data_order_array['cmn_connect_id']=$cmn_connect_id;
                $data_order_array['route']='edi';
                $data_order_array['receive_file_path']=$file_name;

                $data_order_id = data_order::insertGetId($data_order_array);

                // Shipment
                unset($data_order_array["route"]);
                unset($data_order_array["receive_file_path"]);
                $data_order_array['data_order_id']=$data_order_id;
                $data_order_array['upload_datetime']='';
                $data_order_array['upload_file_path']='';
                $data_order_array['send_datetime']='';
                $data_order_array['send_file_path']='';

                $data_shipment_id = data_shipment::insertGetId($data_order_array);

                $order_flg =false;
            }

            if ($trade_number !=$value[31].'-'.$value[32]) {
                $data_voucher_array['mes_lis_ord_tra_trade_number']=$value[31];
                $data_voucher_array['mes_lis_ord_tra_additional_trade_number']=$value[32];
                $data_voucher_array['mes_lis_ord_par_shi_code']=$value[33];
                $data_voucher_array['mes_lis_ord_par_shi_gln']=$value[34];
                $data_voucher_array['mes_lis_ord_par_shi_name']=$value[35];
                $data_voucher_array['mes_lis_ord_par_shi_name_sbcs']=$value[36];
                $data_voucher_array['mes_lis_ord_par_rec_code']=$value[37];
                $data_voucher_array['mes_lis_ord_par_rec_gln']=$value[38];
                $data_voucher_array['mes_lis_ord_par_rec_name']=$value[39];
                $data_voucher_array['mes_lis_ord_par_rec_name_sbcs']=$value[40];
                $data_voucher_array['mes_lis_ord_par_tra_code']=$value[41];
                $data_voucher_array['mes_lis_ord_par_tra_gln']=$value[42];
                $data_voucher_array['mes_lis_ord_par_tra_name']=$value[43];
                $data_voucher_array['mes_lis_ord_par_tra_name_sbcs']=$value[44];
                $data_voucher_array['mes_lis_ord_par_dis_code']=$value[45];
                $data_voucher_array['mes_lis_ord_par_dis_name']=$value[46];
                $data_voucher_array['mes_lis_ord_par_dis_name_sbcs']=$value[47];
                $data_voucher_array['mes_lis_ord_par_pay_code']=$value[48];
                $data_voucher_array['mes_lis_ord_par_pay_gln']=$value[49];
                $data_voucher_array['mes_lis_ord_par_pay_name']=$value[50];
                $data_voucher_array['mes_lis_ord_par_pay_name_sbcs']=$value[51];
                $data_voucher_array['mes_lis_ord_par_sel_code']=$value[52];
                $data_voucher_array['mes_lis_ord_par_sel_gln']=$value[53];
                $data_voucher_array['mes_lis_ord_par_sel_name']=$value[54];
                $data_voucher_array['mes_lis_ord_par_sel_name_sbcs']=$value[55];
                $data_voucher_array['mes_lis_ord_par_sel_branch_number']=$value[56];
                $data_voucher_array['mes_lis_ord_par_sel_ship_location_code']=$value[57];
                $data_voucher_array['mes_lis_ord_log_shi_gln']=$value[58];
                $data_voucher_array['mes_lis_ord_log_del_route_code']=$value[59];
                $data_voucher_array['mes_lis_ord_log_del_delivery_service_code']=$value[60];
                $data_voucher_array['mes_lis_ord_log_del_stock_transfer_code']=$value[61];
                $data_voucher_array['mes_lis_ord_log_del_delivery_code']=$value[62];
                $data_voucher_array['mes_lis_ord_log_del_delivery_time']=$value[63];
                $data_voucher_array['mes_lis_ord_log_del_transportation_code']=$value[64];
                $data_voucher_array['mes_lis_ord_log_log_barcode_print']=$value[65];
                $data_voucher_array['mes_lis_ord_log_log_category_name_print1']=$value[66];
                $data_voucher_array['mes_lis_ord_log_log_category_name_print2']=$value[67];
                $data_voucher_array['mes_lis_ord_log_log_receiver_abbr_name']=$value[68];
                $data_voucher_array['mes_lis_ord_log_log_text']=$value[69];
                $data_voucher_array['mes_lis_ord_log_log_text_sbcs']=$value[70];
                $data_voucher_array['mes_lis_ord_tra_goo_major_category']=$value[71];
                $data_voucher_array['mes_lis_ord_tra_goo_sub_major_category']=$value[72];
                $data_voucher_array['mes_lis_ord_tra_dat_order_date']=$value[73];
                $data_voucher_array['mes_lis_ord_tra_dat_delivery_date']=$value[74];
                $data_voucher_array['mes_lis_ord_tra_dat_delivery_date_to_receiver']=$value[75];
                $data_voucher_array['mes_lis_ord_tra_dat_transfer_of_ownership_date']=$value[76];
                $data_voucher_array['mes_lis_ord_tra_dat_campaign_start_date']=$value[77];
                $data_voucher_array['mes_lis_ord_tra_dat_campaign_end_date']=$value[78];
                $data_voucher_array['mes_lis_ord_tra_dat_valid_until_date']=$value[79];
                $data_voucher_array['mes_lis_ord_tra_ins_goods_classification_code']=$value[80];
                $data_voucher_array['mes_lis_ord_tra_ins_order_classification_code']=$value[81];
                $data_voucher_array['mes_lis_ord_tra_ins_ship_notification_request_code']=$value[82];
                $data_voucher_array['mes_lis_ord_tra_ins_private_brand_code']=$value[83];
                $data_voucher_array['mes_lis_ord_tra_ins_temperature_code']=$value[84];
                $data_voucher_array['mes_lis_ord_tra_ins_liquor_code']=$value[85];
                $data_voucher_array['mes_lis_ord_tra_ins_trade_type_code']=$value[86];
                $data_voucher_array['mes_lis_ord_tra_ins_paper_form_less_code']=$value[87];
                $data_voucher_array['mes_lis_ord_tra_fre_trade_number_request_code']=$value[88];
                $data_voucher_array['mes_lis_ord_tra_fre_package_code']=$value[89];
                $data_voucher_array['mes_lis_ord_tra_fre_variable_measure_item_code']=$value[90];
                $data_voucher_array['mes_lis_ord_tra_tax_tax_type_code']=$value[91];
                $data_voucher_array['mes_lis_ord_tra_tax_tax_rate']=$value[92];
                $data_voucher_array['mes_lis_ord_tra_not_text']=$value[93];
                $data_voucher_array['mes_lis_ord_tra_not_text_sbcs']=$value[94];
                $data_voucher_array['mes_lis_ord_tot_tot_net_price_total']=$value[95];
                $data_voucher_array['mes_lis_ord_tot_tot_selling_price_total']=$value[96];
                $data_voucher_array['mes_lis_ord_tot_tot_tax_total']=$value[97];
                $data_voucher_array['mes_lis_ord_tot_tot_item_total']=$value[98];
                $data_voucher_array['mes_lis_ord_tot_tot_unit_total']=$value[99];
                $data_voucher_array['mes_lis_ord_tot_fre_unit_weight_total']=$value[100];

                $data_voucher_array['data_order_id']=$data_order_id;
                $data_order_voucher_id = data_order_voucher::insertGetId($data_voucher_array);

                $data_shi_voucher_array['data_order_voucher_id']=$data_order_voucher_id;
                $data_shi_voucher_array['mes_lis_shi_tra_trade_number']=$value[31];
                $data_shi_voucher_array['mes_lis_shi_tra_additional_trade_number']=$value[32];
                $data_shi_voucher_array['mes_lis_shi_par_shi_code']=$value[33];
                $data_shi_voucher_array['mes_lis_shi_par_shi_gln']=$value[34];
                $data_shi_voucher_array['mes_lis_shi_par_shi_name']=$value[35];
                $data_shi_voucher_array['mes_lis_shi_par_shi_name_sbcs']=$value[36];
                $data_shi_voucher_array['mes_lis_shi_par_rec_code']=$value[37];
                $data_shi_voucher_array['mes_lis_shi_par_rec_gln']=$value[38];
                $data_shi_voucher_array['mes_lis_shi_par_rec_name']=$value[39];
                $data_shi_voucher_array['mes_lis_shi_par_rec_name_sbcs']=$value[40];
                $data_shi_voucher_array['mes_lis_shi_par_tra_code']=$value[41];
                $data_shi_voucher_array['mes_lis_shi_par_tra_gln']=$value[42];
                $data_shi_voucher_array['mes_lis_shi_par_tra_name']=$value[43];
                $data_shi_voucher_array['mes_lis_shi_par_tra_name_sbcs']=$value[44];
                $data_shi_voucher_array['mes_lis_shi_par_dis_code']=$value[45];
                $data_shi_voucher_array['mes_lis_shi_par_dis_name']=$value[46];
                $data_shi_voucher_array['mes_lis_shi_par_dis_name_sbcs']=$value[47];
                $data_shi_voucher_array['mes_lis_shi_par_pay_code']=$value[48];
                $data_shi_voucher_array['mes_lis_shi_par_pay_gln']=$value[49];
                $data_shi_voucher_array['mes_lis_shi_par_pay_name']=$value[50];
                $data_shi_voucher_array['mes_lis_shi_par_pay_name_sbcs']=$value[51];
                $data_shi_voucher_array['mes_lis_shi_par_sel_code']=$value[52];
                $data_shi_voucher_array['mes_lis_shi_par_sel_gln']=$value[53];
                $data_shi_voucher_array['mes_lis_shi_par_sel_name']=$value[54];
                $data_shi_voucher_array['mes_lis_shi_par_sel_name_sbcs']=$value[55];
                $data_shi_voucher_array['mes_lis_shi_par_sel_branch_number']=$value[56];
                $data_shi_voucher_array['mes_lis_shi_par_sel_ship_location_code']=$value[57];
                $data_shi_voucher_array['mes_lis_shi_log_shi_gln']=$value[58];
                $data_shi_voucher_array['mes_lis_shi_log_del_route_code']=$value[59];
                $data_shi_voucher_array['mes_lis_shi_log_del_delivery_service_code']=$value[60];
                $data_shi_voucher_array['mes_lis_shi_log_del_stock_transfer_code']=$value[61];
                $data_shi_voucher_array['mes_lis_shi_log_del_delivery_code']=$value[62];
                $data_shi_voucher_array['mes_lis_shi_log_del_delivery_time']=$value[63];
                $data_shi_voucher_array['mes_lis_shi_log_del_transportation_code']=$value[64];
                $data_shi_voucher_array['mes_lis_shi_log_log_barcode_print']=$value[65];
                $data_shi_voucher_array['mes_lis_shi_log_log_category_name_print1']=$value[66];
                $data_shi_voucher_array['mes_lis_shi_log_log_category_name_print2']=$value[67];
                $data_shi_voucher_array['mes_lis_shi_log_log_receiver_abbr_name']=$value[68];
                $data_shi_voucher_array['mes_lis_shi_log_log_text']=$value[69];
                $data_shi_voucher_array['mes_lis_shi_log_log_text_sbcs']=$value[70];
                $data_shi_voucher_array['mes_lis_shi_log_maker_code_for_receiving']='';
                $data_shi_voucher_array['mes_lis_shi_log_delivery_slip_number']='';
                $data_shi_voucher_array['mes_lis_shi_tra_goo_major_category']=$value[71];
                $data_shi_voucher_array['mes_lis_shi_tra_goo_sub_major_category']=$value[72];
                $data_shi_voucher_array['mes_lis_shi_tra_dat_order_date']=$value[73];
                $data_shi_voucher_array['mes_lis_shi_tra_dat_delivery_date']=$value[74];
                $data_shi_voucher_array['mes_lis_shi_tra_dat_delivery_date_to_receiver']=$value[75];
                $data_shi_voucher_array['mes_lis_shi_tra_dat_revised_delivery_date']='';
                $data_shi_voucher_array['mes_lis_shi_tra_dat_transfer_of_ownership_date']=$value[76];
                $data_shi_voucher_array['mes_lis_shi_tra_dat_campaign_start_date']=$value[77];
                $data_shi_voucher_array['mes_lis_shi_tra_dat_campaign_end_date']=$value[78];
                // $data_shi_voucher_array['mes_lis_shi_tra_dat_valid_until_date']=$value[79];
                $data_shi_voucher_array['mes_lis_shi_tra_ins_goods_classification_code']=$value[80];
                $data_shi_voucher_array['mes_lis_shi_tra_ins_order_classification_code']=$value[81];
                $data_shi_voucher_array['mes_lis_shi_tra_ins_ship_notification_request_code']=$value[82];
                $data_shi_voucher_array['mes_lis_shi_tra_ins_eos_code']='';
                $data_shi_voucher_array['mes_lis_shi_tra_ins_private_brand_code']=$value[83];
                $data_shi_voucher_array['mes_lis_shi_tra_ins_temperature_code']=$value[84];
                $data_shi_voucher_array['mes_lis_shi_tra_ins_liquor_code']=$value[85];
                $data_shi_voucher_array['mes_lis_shi_tra_ins_trade_type_code']=$value[86];
                $data_shi_voucher_array['mes_lis_shi_tra_ins_paper_form_less_code']=$value[87];
                $data_shi_voucher_array['mes_lis_shi_tra_fre_trade_number_request_code']=$value[88];
                $data_shi_voucher_array['mes_lis_shi_tra_fre_package_code']=$value[89];
                $data_shi_voucher_array['mes_lis_shi_tra_fre_variable_measure_item_code']=$value[90];
                $data_shi_voucher_array['mes_lis_shi_tra_tax_tax_type_code']=$value[91];
                $data_shi_voucher_array['mes_lis_shi_tra_tax_tax_rate']=$value[92];
                $data_shi_voucher_array['mes_lis_shi_tra_not_text']=$value[93];
                $data_shi_voucher_array['mes_lis_shi_tra_not_text_sbcs']=$value[94];
                $data_shi_voucher_array['mes_lis_shi_tot_tot_net_price_total']=$value[95];
                $data_shi_voucher_array['mes_lis_shi_tot_tot_selling_price_total']=$value[96];
                $data_shi_voucher_array['mes_lis_shi_tot_tot_tax_total']=$value[97];
                $data_shi_voucher_array['mes_lis_shi_tot_tot_item_total']=$value[98];
                $data_shi_voucher_array['mes_lis_shi_tot_tot_unit_total']=$value[99];
                $data_shi_voucher_array['mes_lis_shi_tot_fre_unit_weight_total']=$value[100];

                $data_shi_voucher_array["data_shipment_id"]=$data_shipment_id;
                $data_shipment_voucher_id = data_shipment_voucher::insertGetId($data_shi_voucher_array);

                $trade_number = $value[31].'-'.$value[32];
            }



            $data_item_array['mes_lis_ord_lin_lin_line_number']=$value[101];
            $data_item_array['mes_lis_ord_lin_lin_additional_line_number']=$value[102];
            $data_item_array['mes_lis_ord_lin_fre_trade_number']=$value[103];
            $data_item_array['mes_lis_ord_lin_fre_line_number']=$value[104];
            $data_item_array['mes_lis_ord_lin_goo_minor_category']=$value[105];
            $data_item_array['mes_lis_ord_lin_goo_detailed_category']=$value[106];
            $data_item_array['mes_lis_ord_lin_ite_scheduled_date']=$value[107];
            $data_item_array['mes_lis_ord_lin_ite_deadline_date']=$value[108];
            $data_item_array['mes_lis_ord_lin_ite_center_delivery_instruction_code']=$value[109];
            $data_item_array['mes_lis_ord_lin_ite_maker_code']=$value[110];
            $data_item_array['mes_lis_ord_lin_ite_gtin']=$value[111];
            $data_item_array['mes_lis_ord_lin_ite_order_item_code']=$value[112];
            $data_item_array['mes_lis_ord_lin_ite_code_type']=$value[113];
            $data_item_array['mes_lis_ord_lin_ite_supplier_item_code']=$value[114];
            $data_item_array['mes_lis_ord_lin_ite_name']=$value[115];
            $data_item_array['mes_lis_ord_lin_ite_name_sbcs']=$value[116];
            $data_item_array['mes_lis_ord_lin_ite_ite_spec']=$value[117];
            $data_item_array['mes_lis_ord_lin_ite_ite_spec_sbcs']=$value[118];
            $data_item_array['mes_lis_ord_lin_ite_col_color_code']=$value[119];
            $data_item_array['mes_lis_ord_lin_ite_col_description']=$value[120];
            $data_item_array['mes_lis_ord_lin_ite_col_description_sbcs']=$value[121];
            $data_item_array['mes_lis_ord_lin_ite_siz_size_code']=$value[122];
            $data_item_array['mes_lis_ord_lin_ite_siz_description']=$value[123];
            $data_item_array['mes_lis_ord_lin_ite_siz_description_sbcs']=$value[124];
            $data_item_array['mes_lis_ord_lin_fre_packing_quantity']=$value[125];
            $data_item_array['mes_lis_ord_lin_fre_prefecture_code']=$value[126];
            $data_item_array['mes_lis_ord_lin_fre_country_code']=$value[127];
            $data_item_array['mes_lis_ord_lin_fre_field_name']=$value[128];
            $data_item_array['mes_lis_ord_lin_fre_water_area_code']=$value[129];
            $data_item_array['mes_lis_ord_lin_fre_water_area_name']=$value[130];
            $data_item_array['mes_lis_ord_lin_fre_area_of_origin']=$value[131];
            $data_item_array['mes_lis_ord_lin_fre_item_grade']=$value[132];
            $data_item_array['mes_lis_ord_lin_fre_item_class']=$value[133];
            $data_item_array['mes_lis_ord_lin_fre_brand']=$value[134];
            $data_item_array['mes_lis_ord_lin_fre_item_pr']=$value[135];
            $data_item_array['mes_lis_ord_lin_fre_bio_code']=$value[136];
            $data_item_array['mes_lis_ord_lin_fre_breed_code']=$value[137];
            $data_item_array['mes_lis_ord_lin_fre_cultivation_code']=$value[138];
            $data_item_array['mes_lis_ord_lin_fre_defrost_code']=$value[139];
            $data_item_array['mes_lis_ord_lin_fre_item_preservation_code']=$value[140];
            $data_item_array['mes_lis_ord_lin_fre_item_shape_code']=$value[141];
            $data_item_array['mes_lis_ord_lin_fre_use']=$value[142];
            $data_item_array['mes_lis_ord_lin_sta_statutory_classification_code']=$value[143];
            $data_item_array['mes_lis_ord_lin_amo_item_net_price']=$value[144];
            $data_item_array['mes_lis_ord_lin_amo_item_net_price_unit_price']=$value[145];
            $data_item_array['mes_lis_ord_lin_amo_item_selling_price']=$value[146];
            $data_item_array['mes_lis_ord_lin_amo_item_selling_price_unit_price']=$value[147];
            $data_item_array['mes_lis_ord_lin_amo_item_tax']=$value[148];
            $data_item_array['mes_lis_ord_lin_qua_unit_multiple']=$value[149];
            $data_item_array['mes_lis_ord_lin_qua_unit_of_measure']=$value[150];
            $data_item_array['mes_lis_ord_lin_qua_package_indicator']=$value[151];
            $data_item_array['mes_lis_ord_lin_qua_ord_quantity']=$value[152];
            $data_item_array['mes_lis_ord_lin_qua_ord_num_of_order_units']=$value[153];
            $data_item_array['mes_lis_ord_lin_fre_unit_weight']=$value[154];
            $data_item_array['mes_lis_ord_lin_fre_unit_weight_code']=$value[155];
            $data_item_array['mes_lis_ord_lin_fre_item_weight']=$value[156];
            $data_item_array['mes_lis_ord_lin_fre_order_weight']=$value[157];

            $data_shi_item_array['mes_lis_shi_lin_lin_line_number']=$value[101];
            $data_shi_item_array['mes_lis_shi_lin_lin_additional_line_number']=$value[102];
            $data_shi_item_array['mes_lis_shi_lin_fre_trade_number']=$value[103];
            $data_shi_item_array['mes_lis_shi_lin_fre_line_number']=$value[104];
            $data_shi_item_array['mes_lis_shi_lin_fre_shipment_line_number']='';
            $data_shi_item_array['mes_lis_shi_lin_goo_minor_category']=$value[105];
            $data_shi_item_array['mes_lis_shi_lin_goo_detailed_category']=$value[106];
            $data_shi_item_array['mes_lis_shi_lin_ite_scheduled_date']=$value[107];
            $data_shi_item_array['mes_lis_shi_lin_ite_deadline_date']=$value[108];
            $data_shi_item_array['mes_lis_shi_lin_ite_center_delivery_instruction_code']=$value[109];
            $data_shi_item_array['mes_lis_shi_lin_fre_interim_price_code']='';
            $data_shi_item_array['mes_lis_shi_lin_ite_maker_code']=$value[110];
            $data_shi_item_array['mes_lis_shi_lin_ite_gtin']=$value[111];
            $data_shi_item_array['mes_lis_shi_lin_ite_order_item_code']=$value[112];
            $data_shi_item_array['mes_lis_shi_lin_ite_code_type']=$value[113];
            $data_shi_item_array['mes_lis_shi_lin_ite_supplier_item_code']=$value[114];
            $data_shi_item_array['mes_lis_shi_lin_ite_name']=$value[115];
            $data_shi_item_array['mes_lis_shi_lin_ite_name_sbcs']=$value[116];
            $data_shi_item_array['mes_lis_shi_lin_fre_shipment_item_code']='';
            $data_shi_item_array['mes_lis_shi_lin_ite_ite_spec']=$value[117];
            $data_shi_item_array['mes_lis_shi_lin_ite_ite_spec_sbcs']=$value[118];
            $data_shi_item_array['mes_lis_shi_lin_ite_col_color_code']=$value[119];
            $data_shi_item_array['mes_lis_shi_lin_ite_col_description']=$value[120];
            $data_shi_item_array['mes_lis_shi_lin_ite_col_description_sbcs']=$value[121];
            $data_shi_item_array['mes_lis_shi_lin_ite_siz_size_code']=$value[122];
            $data_shi_item_array['mes_lis_shi_lin_ite_siz_description']=$value[123];
            $data_shi_item_array['mes_lis_shi_lin_ite_siz_description_sbcs']=$value[124];
            $data_shi_item_array['mes_lis_shi_lin_fre_packing_quantity']=$value[125];
            $data_shi_item_array['mes_lis_shi_lin_fre_prefecture_code']=$value[126];
            $data_shi_item_array['mes_lis_shi_lin_fre_country_code']=$value[127];
            $data_shi_item_array['mes_lis_shi_lin_fre_field_name']=$value[128];
            $data_shi_item_array['mes_lis_shi_lin_fre_water_area_code']=$value[129];
            $data_shi_item_array['mes_lis_shi_lin_fre_water_area_name']=$value[130];
            $data_shi_item_array['mes_lis_shi_lin_fre_area_of_origin']=$value[131];
            $data_shi_item_array['mes_lis_shi_lin_fre_item_grade']=$value[132];
            $data_shi_item_array['mes_lis_shi_lin_fre_item_class']=$value[133];
            $data_shi_item_array['mes_lis_shi_lin_fre_brand']=$value[134];
            $data_shi_item_array['mes_lis_shi_lin_fre_item_pr']=$value[135];
            $data_shi_item_array['mes_lis_shi_lin_fre_bio_code']=$value[136];
            $data_shi_item_array['mes_lis_shi_lin_fre_breed_code']=$value[137];
            $data_shi_item_array['mes_lis_shi_lin_fre_cultivation_code']=$value[138];
            $data_shi_item_array['mes_lis_shi_lin_fre_defrost_code']=$value[139];
            $data_shi_item_array['mes_lis_shi_lin_fre_item_preservation_code']=$value[140];
            $data_shi_item_array['mes_lis_shi_lin_fre_item_shape_code']=$value[141];
            $data_shi_item_array['mes_lis_shi_lin_fre_use']=$value[142];
            $data_shi_item_array['mes_lis_shi_lin_sta_statutory_classification_code']=$value[143];
            $data_shi_item_array['mes_lis_shi_lin_amo_item_net_price']=$value[144];
            $data_shi_item_array['mes_lis_shi_lin_amo_item_net_price_unit_price']=$value[145];
            $data_shi_item_array['mes_lis_shi_lin_amo_item_selling_price']=$value[146];
            $data_shi_item_array['mes_lis_shi_lin_amo_item_selling_price_unit_price']=$value[147];
            $data_shi_item_array['mes_lis_shi_lin_amo_item_tax']=$value[148];
            $data_shi_item_array['mes_lis_shi_lin_qua_unit_multiple']=$value[149];
            $data_shi_item_array['mes_lis_shi_lin_qua_unit_of_measure']=$value[150];
            $data_shi_item_array['mes_lis_shi_lin_qua_package_indicator']=$value[151];
            $data_shi_item_array['mes_lis_shi_lin_qua_ord_quantity']=$value[152];
            $data_shi_item_array['mes_lis_shi_lin_qua_ord_num_of_order_units']=$value[153];
            $data_shi_item_array['mes_lis_shi_lin_qua_shi_quantity']='';
            $data_shi_item_array['mes_lis_shi_lin_qua_shi_num_of_order_units']='';
            $data_shi_item_array['mes_lis_shi_lin_qua_sto_quantity']='';
            $data_shi_item_array['mes_lis_shi_lin_qua_sto_num_of_order_units']='';
            $data_shi_item_array['mes_lis_shi_lin_qua_sto_reason_code']='';
            $data_shi_item_array['mes_lis_shi_lin_fre_unit_weight']=$value[154];
            $data_shi_item_array['mes_lis_shi_lin_fre_unit_weight_code']=$value[155];
            $data_shi_item_array['mes_lis_shi_lin_fre_item_weight']=$value[156];
            $data_shi_item_array['mes_lis_shi_lin_fre_order_weight']=$value[157];
            $data_shi_item_array['mes_lis_shi_lin_fre_shipment_weight']='';
            // 158 done

            $data_item_array['data_order_voucher_id']=$data_order_voucher_id;
            data_order_item::insert($data_item_array);



            $data_shi_item_array["data_shipment_voucher_id"]=$data_shipment_voucher_id;
            $data_shipment_item_id = data_shipment_item::insertGetId($data_shi_item_array);
            data_shipment_item_detail::insert(['data_shipment_item_id'=>$data_shipment_item_id]);

            // format
            $data_order_array=array();
            $data_voucher_array=array();
            $data_shi_voucher_array=array();
            $data_item_array=array();
            $data_shi_item_array=array();
        }
        return \response()->json(['message' => "success", 'status' => 0]);
    }
}
