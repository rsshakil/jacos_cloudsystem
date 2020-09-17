<?php

namespace App\Scenarios;
use App\scenarios\Common;
use Illuminate\Database\Eloquent\Model;
use App\Models\BYR\byr_order_detail;
use App\Models\BYR\byr_order;
use App\Models\BYR\byr_shipment_detail;
use App\Models\BYR\byr_shipment;
use App\Models\BYR\byr_shop;
use App\Models\BYR\byr_item;
use App\Models\BYR\byr_item_class;
use App\Models\CMN\cmn_maker;
use App\Models\CMN\cmn_category;
use App\Models\CMN\cmn_category_description;
use App\Models\CMN\cmn_category_path;
use App\Models\BMS\bms_order;
use DB;
class bms_csv_order extends Model
{
    // private $b;
    // private $d;
    // private $voucher_number;
    // private $shop_code;
    // private $category_code;
    // private $voucher_category;
    // private $order_date;
    // private $expected_delivery_date;
    // private $partner_code;
    // private $delivery_service_code;
    // private $shop_name_kana;
    // private $list_number;
    // private $order_quantity;
    // private $inputs;
    // private $jan;
    // private $order_inputs;
    // private $cost_unit_price;
    // private $cost_price;
    // private $selling_unit_price;
    // private $selling_price;
    // private $item_name_kana;
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
                ["start" => 2141,	"length" => 10,"name" => "shop_name_kana",	"name_jp"=>"店舗名称(ｶﾅ)"],
                ["start" => 2171,	"length" => 50,"name" => "shop_name",	"name_jp"=>"店舗名称(漢字)"],
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
/**
     * File encoding from SJIJ to utf8
     * @param  SJIJ String or array
     * @return utf-8 encoded string
     */
    public static function convert_from_sjis_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            \Log::debug('----- SJIJ to UTF-8 conversion completed -----');
            // $dat=str_replace("\u{00a0}", ' ', $dat);
            if(mb_detect_encoding($dat) != "UTF-8"){
                return mb_convert_encoding($dat, "UTF-8", "sjis-win");
                // return utf8_encode($dat);   
            }else{
                return mb_convert_encoding($dat,"UTF-8","auto");
                // return $dat;
            }
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) {
                $ret[$i] = self::convert_from_sjis_to_utf8_recursively($d);
            }

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) {
                $dat->$i = self::convert_from_sjis_to_utf8_recursively($d);
            }

            return $dat;
        } else {
            return $dat;
        }
    }
    public function csvReader($baseUrl)
    {
        $data = array_map('str_getcsv', file($baseUrl));
        $csv_data = array_slice($data, 1);
        $rowData = $this->convert_from_sjis_to_utf8_recursively($csv_data);
        \Log::debug('----- CSV file read completed from this url: (' . $baseUrl . ')-----');
        return $rowData;
    }

    //
    public function exec($request,$sc)
    {
        $cmn_m_cls = new Common();
        // include(app_path() . '/scenarios/common.php');
        \Log::debug('ouk_order_toj exec start  ---------------');
        // ファイルアップロード
        // echo $request->file('up_file');exit;
       $file_name = $request->file('up_file')->getClientOriginalName();
        $path = $request->file('up_file')->storeAs(config('const.ORDER_DATA_PATH').date('Y-m'), $file_name);
        \Log::debug('save path:'.$path);
        // $custom_paths = storage_path().'/app//'.config('const.ORDER_DATA_PATH').date('Y-m').'/'.$file_name;
        // $file_url = fopen(storage_path().'/app//'.config('const.ORDER_DATA_PATH').date('Y-m').'/'.$file_name, 'r');
        $received_path = storage_path().'/app//'.config('const.ORDER_DATA_PATH').date('Y-m').'/'.$file_name;
        // フォーマット変換
        // byr_orders,byr_order_details格納
        $dataArr = $this->csvReader($received_path);
       
        $data_count=count($dataArr);
       

        $byr_order_id = byr_order::insertGetId(['receive_file_path'=>$received_path,'cmn_connect_id'=>$sc->cmn_connect_id,'data_count'=>$data_count]);
        // $byr_shipment_id = byr_shipment::insertGetId(['send_file_path'=>$received_path,'cmn_connect_id'=>$sc->cmn_connect_id]);


        // print_r($dataArr);
        // return $dataArr;
        $insert_array=array();
        foreach ($dataArr as $key => $value) {
            // $temp_array['file_name']=$fileName;
            $temp_array['byr_order_id']=$byr_order_id;
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

        echo '<pre>';
        print_r($insert_array);
        echo 'save path:'.$path;exit;



        \Log::debug('ouk_order_toj exec end  ---------------');
        return 0;
    }

    public function get_shop_id_by_shop_code($shop_code,$shop_name_kana,$sc){
        if(byr_shop::where('shop_code',$shop_code)->exists()){
             $row = byr_shop::where('shop_code',$shop_code)->first();
             return $row->byr_shop_id;
        }else{
            $id = byr_shop::insertGetId(['shop_code'=>$shop_code,'shop_name_kana'=>$shop_name_kana,'byr_buyer_id'=>$sc->byr_buyer_id,'slr_seller_id'=>$sc->slr_seller_id]);
            return $id;
        }
    }

    /*jacos string analyze*/
    public function mb_str_split($string)
    {
        # Split at all position not after the start: ^
        # and not before the end: $
        return preg_split('/(?<!^)(?!$)/u', $string);
    }
    public function process_array($charlist)
    {
        $total = count($charlist);
        $k = 0;
        $num__index = 0;
        $arr1 = array();
        for ($i = 0; $i < $total; $i++) {
            if ($k <= 128) {
                $arr1[$num__index][] = $charlist[$i];
                $k++;
            }
            if ($k == 128) {
                $num__index++;
                $k = 0;
            }
        }
        return $arr1;
    }

    public function b_array_process($all_array)
    {
        $b = '';
        $voucher_number = '';
        $shop_code = '';
        $category_code = '';
        $voucher_category = '';
        $order_date = '';
        $expected_delivery_date = '';
        $partner_code = '';
        $delivery_service_code = '';
        $shop_name_kana = '';
        $center_flg = '';
        $center_code = '';
        $center_name = '';
        for ($i = 0; $i < count($all_array); $i++) {
            if ($i == 0) {
                $b .= $all_array[$i];
            } elseif ($i >= 4 && $i < 12) {
                $voucher_number .= $all_array[$i];
            } elseif ($i >= 15 && $i < 21) {
                $shop_code .= $all_array[$i];
            } elseif ($i >= 21 && $i < 25) {
                $category_code .= $all_array[$i];
            } elseif ($i >= 25 && $i < 27) {
                $voucher_category .= $all_array[$i];
            } elseif ($i >= 27 && $i < 33) {
                $order_date .= $all_array[$i];
            } elseif ($i >= 33 && $i < 39) {
                $expected_delivery_date .= $all_array[$i];
            } elseif ($i >= 39 && $i < 45) {
                $partner_code .= $all_array[$i];
            } elseif ($i >= 47 && $i < 48) {
                $delivery_service_code .= $all_array[$i];
            } elseif ($i >= 48 && $i < 54) {
                $shop_name_kana .= $all_array[$i];
            } elseif ($i >= 83 && $i < 84) {
                $center_flg .= $all_array[$i];
            } elseif ($i >= 84 && $i < 90) {
                $center_code .= $all_array[$i];
            } elseif ($i >= 90 && $i < 112) {
                $center_name .= $all_array[$i];
            }
        }
        $other_infos = json_encode(array('center_flg'=>$center_flg,'center_code'=>$center_code,'center_name'=>$center_name));
        $insert_array_b = array(
            'voucher_number'=>$voucher_number,
            'shop_code'=>$shop_code,
            'category_code'=>$category_code,
            'voucher_category'=>$voucher_category,
            'expected_delivery_date'=>$expected_delivery_date,
            'order_date'=>$order_date,
            'shop_name_kana'=>$shop_name_kana,
            'partner_code'=>$partner_code,
            'delivery_service_code'=>$delivery_service_code,
            'other_info'=>$other_infos,
        );
        return $insert_array_b;
    }
    public function d_array_process($all_array)
    {
        $d='';
        $list_number='';
       $jan='';
        $inputs='';
         $order_inputs='';
        $order_quantity='';
        $item_name_kana='';
         $cost_price='';
        $selling_price='';
         $cost_unit_price='';
        $selling_unit_price='';
        for ($j = 0; $j < count($all_array); $j++) {
            if ($j == 0) {
                $d .= $all_array[$j];
            } elseif ($j >= 3 && $j < 5) {
                $list_number .= $all_array[$j];
            } elseif ($j >= 5 && $j < 18) {
                $jan .= $all_array[$j];
            } elseif ($j >= 18 && $j < 22) {
                $inputs .= $all_array[$j];
            } elseif ($j >= 22 && $j < 26) {
                $order_inputs .= $all_array[$j];
            } elseif ($j >= 29 && $j < 35) {
                $order_quantity .= $all_array[$j];
            } elseif ($j >= 36 && $j < 44) {
                $cost_unit_price .= $all_array[$j];
            } elseif ($j >= 45 && $j < 51) {
                $selling_unit_price .= $all_array[$j];
            } elseif ($j >= 52 && $j < 61) {
                $cost_price .= $all_array[$j];
            } elseif ($j >= 62 && $j < 71) {
                $selling_price .= $all_array[$j];
            } elseif ($j >= 80 && $j < 105) {
                $item_name_kana .= $all_array[$j];
            }
        }
        $str = str_split($cost_unit_price, strlen($cost_unit_price) - 2);
$new_cost_unit_price = $str[0].'.'.$str[1];
        $insert_array_d = array(
            'list_number' => $list_number,
            'jan' => $jan,
            'inputs' => ltrim($inputs,'0'),
            'order_inputs' => 'バラ',
            'order_quantity' => ltrim($order_quantity,'0'),
            'item_name_kana' => $item_name_kana,
            'cost_price' => ltrim($cost_price,'0'),
            'selling_price' => ltrim($selling_price,'0'),
            'cost_unit_price' => ltrim($new_cost_unit_price,'0'),
            'selling_unit_price' => ltrim($selling_unit_price,'0'),
        );
        return $insert_array_d;
    }

    /*jacos string analyze*/
    /**
     * 発注データ連想配列化
     *
     * @param  txtファイルパス
     * @param  Array フォーマット(連想配列)
     * @return boolean
     */
    public function analyze($filePath, $format)
    {
        $data = null;

        $head = [];		// ヘッダー
        $cdata = [];	// データ
        $foot = [];		// フッター

        // header行
        foreach ($format as $f) {
            if ($f['type']==='header') {
                foreach ($f['fmt'] as $fdata) {
                    $head[$fdata['name']] = $fdata['name_jp'];
                }
            } elseif ($f['type']==='data') {
                foreach ($f['fmt'] as $fdata) {
                    $cdata[$fdata['name']] = $fdata['name_jp'];
                }
            } elseif ($f['type']==='footer') {
                foreach ($f['fmt'] as $fdata) {
                    $foot[$fdata['name']] = $fdata['name_jp'];
                }
            }
        }
        $cnt = 0;
        //		$data[$cnt] = array_merge($head,$cdata,$foot);
        $data[$cnt] = array_merge($cdata, $head, $foot);
        mb_convert_variables('SJIS-win', 'UTF-8', $data[$cnt]);
        $cnt++;

        $head = [];		// ヘッダー
        $cdata = [];	// データ
        $foot = [];		// フッター
        $ccnt = 0;

        // 読み込み
        $lines = file($filePath);
        foreach ($lines as $key => $line) {
            foreach ($format as $f) {

                // key値と指定文字列との比較
                if ($f['key']['value'] == substr($line, $f['key']['start']-1, $f['key']['length'])) {

                    // type判定
                    if ($f['type']==='header') {
                        // ヘッダー行
                        foreach ($f['fmt'] as $fdata) {
                            //							$head[$fdata['name']] = trim(mb_convert_encoding(mb_strcut ($line,$fdata['start']-1,$fdata['length'],'SJIS-win'),'UTF-8', 'SJIS-win'));
                            $head[$fdata['name']] = trim(mb_strcut($line, $fdata['start']-1, $fdata['length'], 'SJIS-win'));
                            //							log_message('info',$fdata['name'].':'.$head[$fdata['name']]);
                        }

                        // クリア
                        $ccnt = 0;
                        $cdata = [];
                    } elseif ($f['type']==='data') {
                        // データ行
                        foreach ($f['fmt'] as $fdata) {
                            //							$cdata[$ccnt][$fdata['name']] = trim(mb_convert_encoding(mb_strcut ($line,$fdata['start']-1,$fdata['length'],'SJIS-win'),'UTF-8', 'SJIS-win'));
                            $cdata[$ccnt][$fdata['name']] = trim(mb_strcut($line, $fdata['start']-1, $fdata['length'], 'SJIS-win'));
                        }
                        // データ行
                        $ccnt++;
                    } elseif ($f['type']==='footer') {
                        // フッター行
                        foreach ($f['fmt'] as $fdata) {
                            //							$foot[$fdata['name']] = trim(mb_convert_encoding(mb_strcut ($line,$fdata['start']-1,$fdata['length'],'SJIS-win'),'UTF-8', 'SJIS-win'));
                            $foot[$fdata['name']] = trim(mb_strcut($line, $fdata['start']-1, $fdata['length'], 'SJIS-win'));
                        }

                        // データ結合
                        foreach ($cdata as $cval) {
                            //							$data[$cnt] = array_merge($head,$cval,$foot);
                            $data[$cnt] = array_merge($cval, $head, $foot);
                            $cnt++;
                        }
                    }
                }
            }
        }
        return $data;
    }
    /**
     * File encoding from utf8 to SJIJ
     * @param utf-8 String or array
     * @return  SJIJ encoded string
     */
    public static function convert_from_utf8_to_sjis__recursively($dat)
    {
        if (is_string($dat)) {
            \Log::debug('----- UTF-8 to SJIJ conversion completed -----');
            // Original
            return mb_convert_encoding($dat, "sjis-win", "UTF-8");
            // return mb_convert_encoding($dat, "SJIS", "UTF-8");
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) {
                $ret[$i] = self::convert_from_utf8_to_sjis__recursively($d);
            }

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) {
                $dat->$i = self::convert_from_utf8_to_sjis__recursively($d);
            }

            return $dat;
        } else {
            return $dat;
        }
    }
}
