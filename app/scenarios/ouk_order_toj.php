<?php

namespace App\Scenarios;
use App\scenarios\Common;
use Illuminate\Database\Eloquent\Model;
use App\Models\BYR\byr_order_detail;
use App\Models\BYR\byr_order;
use App\Models\BYR\byr_shipment_detail;
use App\Models\BYR\byr_shipment;
use App\Models\BYR\byr_shop;

class ouk_order_toj extends Model
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
        $get_string = $cmn_m_cls->ebcdic_2_sjis($received_path);
        $get_string = mb_convert_encoding($get_string, "UTF-8", "SJIS");
        // echo $get_string;exit;
        // $charlist = fread($file_url,filesize(storage_path().'/app//'.config('const.ORDER_DATA_PATH').date('Y-m').'/'.$file_name));
        // $charlist = $this->convert_from_sjis_to_utf8_recursively($charlist);
        // $charlist = $this->convert_from_utf8_to_sjis__recursively($charlist);
        // $str_arr = $this->mb_str_split($charlist);
        $str_arr = $this->mb_str_split($get_string);
        // echo '<pre>';
        // print_r($str_arr);exit;
        // $str_arr = str_split($charlist);
        $all_array_data = $this->process_array($str_arr);
        $insert_array_b = array();
        $insert_array_d = array();
        $temp = array();
        $k=0;
        foreach ($all_array_data as $key => $all_array) {
            //    print_r($all_array[0]);
            if ($all_array[0] == "B") {
                $k++;
                $insert_array_b[$k] = $this->b_array_process($all_array);
            } elseif ($all_array[0] == "D") {
                $insert_array_b[$k]['item_data'][] = $this->d_array_process($all_array);
            }
        }
        // echo '<pre>';
        // print_r($insert_array_b);
        // exit;
        $byr_order_id = byr_order::insertGetId(['receive_file_path'=>$received_path,'cmn_connect_id'=>$sc->cmn_connect_id]);
        $byr_shipment_id = byr_shipment::insertGetId(['send_file_path'=>$received_path,'cmn_connect_id'=>$sc->cmn_connect_id]);
        $cnt = 0;
        if($insert_array_b){
            $insert_detail = array();
            $total = 0;
            foreach($insert_array_b as $value){
                $byr_shop_id = $this->get_shop_id_by_shop_code($value['shop_code'],$value['shop_name_kana'],$sc);
                foreach($value['item_data'] as $item){
                    $order_quantity = $item['order_quantity'];
                    $insert_detail['byr_order_id']=$byr_order_id;
                    $insert_detail['byr_shop_id']=$byr_shop_id;
                    $insert_detail['voucher_number']=$value['voucher_number'];
                    $insert_detail['category_code']=$value['category_code'];
                    $insert_detail['voucher_category']=$value['voucher_category'];
                    $insert_detail['other_info']=$value['other_info'];
                    $insert_detail['expected_delivery_date']=$value['expected_delivery_date'];
                    $insert_detail['order_date']=$value['order_date'];
                    $insert_detail['delivery_service_code']=$value['delivery_service_code'];
                    $insert_detail['list_number']=$item['list_number'];
                    $insert_detail['jan']=$item['jan'];
                    $insert_detail['inputs']=$item['inputs'];
                    $insert_detail['order_lot_inputs']=$item['order_inputs'];
                    $insert_detail['order_unit_quantity']=$order_quantity;
                    $insert_detail['item_name_kana']=$item['item_name_kana'];
                    $insert_detail['cost_price']=$item['cost_price'];
                    $insert_detail['selling_price']=$item['selling_price'];
                    $insert_detail['selling_unit_price']=$item['selling_unit_price'];
                    $insert_detail['cost_unit_price']=$item['cost_unit_price'];
                    $byr_order_detail_id = byr_order_detail::insertGetId($insert_detail);
                    byr_shipment_detail::insert(['byr_order_detail_id'=>$byr_order_detail_id,'byr_shipment_id'=>$byr_shipment_id,'order_quantity'=>$order_quantity,'confirm_quantity'=>$order_quantity]);
                    $temp[]= $insert_detail;
                    $total++;
                }
                
            }
            byr_order::where('byr_order_id',$byr_order_id)->update(['data_count'=>$total]);
        }
        echo '<pre>';
        print_r($temp);
        // print_r($insert_array_d);
        exit;
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

    public static function convert_from_sjis_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            \Log::debug('----- SJIJ to UTF-8 conversion completed -----');
            return mb_convert_encoding($dat, "UTF-8", "sjis-win");
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
