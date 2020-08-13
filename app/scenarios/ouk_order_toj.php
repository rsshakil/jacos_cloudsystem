<?php

namespace App\Scenarios;

use Illuminate\Database\Eloquent\Model;

class ouk_order_toj extends Model
{
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
    public function exec($request)
    {
        \Log::debug('ouk_order_toj exec start  ---------------');
        // ファイルアップロード
       $file_name = $request->file('up_file')->getClientOriginalName();
        $path = $request->file('up_file')->storeAs(config('const.ORDER_DATA_PATH').date('Y-m'), $file_name);
        \Log::debug('save path:'.$path);

        $file_url = fopen(storage_path().'/app//'.config('const.ORDER_DATA_PATH').date('Y-m').'/'.$file_name, 'r');
        // フォーマット変換
        // byr_orders,byr_order_details格納
        $charlist = fread($file_url,filesize(storage_path().'/app//'.config('const.ORDER_DATA_PATH').date('Y-m').'/'.$file_name));
        $charlist = $this->convert_from_sjis_to_utf8_recursively($charlist);
        // $charlist = $this->convert_from_utf8_to_sjis__recursively($charlist);
        // $str_arr = $this->mb_str_split($charlist);
        $str_arr = str_split($charlist);
        $arr_group = $this->process_array($str_arr);
        echo '<pre>';
print_r($arr_group);exit;
        echo 'save path:'.$path;exit;



        \Log::debug('ouk_order_toj exec end  ---------------');
        return 0;
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
            // return mb_convert_encoding($dat, "UTF-8", "sjis-win");
            return mb_convert_encoding($dat, "EUC-JP", "auto");
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
