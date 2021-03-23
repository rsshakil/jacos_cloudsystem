<?php

namespace App\Http\Controllers\API\DATA\RECEIVE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DATA\RCV\data_receive;

class DataController extends Controller
{
    public static function getReceiveData($request)
    {
        // 対象データ取得
        $data_receive_id=$request->data_receive_id;
        $request_all=$request->all();

        $csv_data=data_receive::select('data_receives.*','drv.*','dri.*')
        ->join('data_receive_vouchers as drv','drv.data_receive_id','=','data_receives.data_receive_id')
        ->join('data_receive_items as dri','dri.data_receive_voucher_id','=','drv.data_receive_voucher_id');
        if (array_key_exists("data_receive_id", $request_all)) {
            $csv_data=$csv_data->where('data_receives.data_receive_id',$data_receive_id);
        }

        // if (!(array_key_exists("downloadType", $request_all))) {
        //     $csv_data=$csv_data->where('dppd.decision_datetime','!=',null);
        //     $csv_data=$csv_data->where('dppd.send_datetime','=',null);
        // }
        $csv_data=$csv_data->groupBy('drv.data_receive_voucher_id');
        // $csv_data=$csv_data->orderBy("data_payments.data_payment_id");
        // 検索
        // $csv_data = $csv_data->limit(100000)->get()->toArray();
        return $csv_data;
    }

    public static function receiveCsvHeading(){
        return [
            "送信者ＩＤ",
            "送信者ＩＤ発行元",
            "受信者ＩＤ",
            "受信者ＩＤ発行元",
            "標準名称",
            "バージョン",
            "インスタンスＩＤ",
            "メッセージ種",
            "作成日時",
            "タイプ",
            "テスト区分・最終送信先",
            "テスト区分・最終送信先ＩＤ",
            "メッセージ識別ＩＤ",
            "送信者ステーションアドレス",
            "最終受信者ステーションアドレス",
            "直接受信者ステーションアドレス",
            "取引数",
            "システム情報",
            "キー",
            "値",
            "バージョン番号",
            "バージョン番号",
            "名前空間",
            "バージョン",
            "支払法人コード",
            "支払法人GLN",
            "支払法人名称",
            "支払法人名称カナ",
            "発注者コード",
            "発注者GLN",
            "発注者名称",
            "発注者名称カナ",
            "請求書番号",
            "請求取引先コード",
            "請求取引先GLN",
            "請求取引先名",
            "請求取引先名カナ",
            "対象期間開始",
            "対象期間終了",
            "取引番号（発注・返品）",
            "発行区分",
            "連番",
            "計上部署コード",
            "計上部署GLN",
            "計上部署名称",
            "計上部署名称（カナ）",
            "取引先コード",
            "取引先GLN",
            "取引先名称",
            "取引先名称カナ",
            "商品分類（大）",
            "商品分類（中）",
            "計上日",
            "請求金額",
            "請求金額符号",
            "税額合計金額",
            "請求区分",
            "未払買掛区分",
            "支払内容",
            "税区分",
            "税率"
        ];
    }
}
