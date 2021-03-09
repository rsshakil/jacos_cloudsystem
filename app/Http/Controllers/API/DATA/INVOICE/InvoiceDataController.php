<?php

namespace App\Http\Controllers\API\DATA\INVOICE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DATA\INVOICE\data_invoice;

class InvoiceDataController extends Controller
{
    public static function get_invoice_data($request)
    {
        // 対象データ取得
        $data_invoice_id=$request->data_invoice_id;
        $order_info=$request->order_info;
        $request_all=$request->all();

        $csv_data=data_invoice::select('data_invoices.*','data_invoice_pays.*','data_invoice_pay_details.*')
        ->join('data_invoice_pays','data_invoice_pays.data_invoice_id','=','data_invoices.data_invoice_id')
        ->join('data_invoice_pay_details','data_invoice_pay_details.data_invoice_pay_id','=','data_invoice_pays.data_invoice_pay_id')

        ->where('data_invoices.data_invoice_id',$data_invoice_id);
        // filtering
        // ->where('data_shipment_vouchers.mes_lis_shi_log_del_delivery_service_code', $order_info['mes_lis_shi_log_del_delivery_service_code'])
        // ->where('data_shipment_vouchers.mes_lis_shi_par_sel_code', $order_info['mes_lis_shi_par_sel_code'])
        // ->where('data_shipment_vouchers.mes_lis_shi_par_sel_name', $order_info['mes_lis_shi_par_sel_name'])
        // ->where('data_shipment_vouchers.mes_lis_shi_tra_dat_delivery_date', $order_info['mes_lis_shi_tra_dat_delivery_date'])
        // ->where('data_shipment_vouchers.mes_lis_shi_tra_goo_major_category', $order_info['mes_lis_shi_tra_goo_major_category'])
        // ->where('data_shipment_vouchers.mes_lis_shi_tra_ins_temperature_code', $order_info['mes_lis_shi_tra_ins_temperature_code']);
        // receive_datetime not found in shipment tables

        if (!(array_key_exists("downloadType", $request_all))) {
            $csv_data->where('data_invoice_pay_details.decision_datetime','!=',null);
            $csv_data->where('data_invoice_pay_details.send_datetime','=',null);
        }
        $csv_data->groupBy('data_invoice_pay_details.data_invoice_pay_detail_id');
        $csv_data->orderBy("data_invoices.data_invoice_id");
        // 検索
        // $csv_data = $csv_data->limit(100000)->get()->toArray();
        return $csv_data;
    }
    public static function invoiceCsvHeading(){
        return [
            '送信者ＩＤ',
            '送信者ID発行元',
            '受信者ＩＤ',
            '受信者ID発行元',
            '標準名称',
            'バージョン',
            'インスタンスＩＤ',
            'メッセージ種',
            '作成日時',
            'タイプ',
            'テスト区分・最終送信先',
            'テスト区分ＩＤ・最終送信先ＩＤ',
            'メッセージ識別ＩＤ',
            '送信者ステーションアドレス',
            '最終受信者ステーションアドレス',
            '直接受信者ステーションアドレス',
            '取引数',
            'システム情報：キー',
            'システム情報：値',
            'XML内容バージョン：バージョンID',
            'XML構造バージョン：バージョンID',
            '拡張情報：ネームスペース',
            '拡張情報：バージョン番号',
            '支払法人コード',
            '支払法人GLN',
            '支払法人名称',
            '支払法人名称カナ',
            '発注者コード',
            '発注者GLN',
            '発注者名称',
            '発注者名称カナ',
            '取引番号（発注・返品）',
            '取引付属番号',
            '出荷者管理番号',
            '直接納品先コード',
            '直接納品先GLN',
            '直接納品先名称',
            '直接納品先名称カナ',
            '最終納品先コード',
            '最終納品先GLN',
            '最終納品先名称',
            '最終納品先名称カナ',
            '計上部署コード',
            '計上部署GLN',
            '計上部署名称',
            '計上部署名称（カナ）',
            '陳列場所コード',
            '陳列場所名称',
            '陳列場所名称カナ',
            '請求取引先コード',
            '請求取引先GLN',
            '請求取引先名',
            '請求取引先名カナ',
            '取引先コード',
            '取引先GLN',
            '取引先名称',
            '取引先名称カナ',
            '取引先：枝番',
            '出荷先コード',
            '出荷場所GLN',
            '納品経路',
            '便No',
            '通過在庫区分',
            '納品区分',
            '指定納品時刻',
            '輸送手段',
            'バーコード情報',
            'カテゴリー名称1（印字用）',
            'カテゴリー名称2（印字用）',
            '最終納品先略称（印字用）',
            'ラベル自由使用欄（印字用）',
            'ラベル自由使用欄半角カナ（印字用）',
            '入荷管理用メーカーコード',
            'センター納品書番号',
            '商品分類（大）',
            '商品分類（中）',
            '発注日',
            '直接納品先納品日',
            '最終納品先納品日',
            '訂正後直接納品先納品日',
            '計上日',
            '販促開始日',
            '販促終了日',
            '商品区分',
            '発注区分',
            '出荷データ有無区分',
            'EOS区分',
            'PB区分',
            '配送温度区分',
            '酒区分',
            '処理種別',
            '伝票レス区分',
            '取引番号区分',
            'パック区分',
            '不定貫区分',
            '税区分',
            '税率',
            '自由使用欄',
            '自由使用欄半角カナ',
            '原価金額合計',
            '売価金額合計',
            '税額合計金額',
            '数量合計',
            '発注単位数量合計',
            '重量合計',
            '取引明細番号（発注・返品）',
            '取引付属明細番号',
            '元取引番号',
            '元取引明細番号',
            '出荷者管理明細番号',
            '商品分類（小）',
            '商品分類（細）',
            '配達予定日',
            '納品期限',
            'センター納品詳細指示',
            '仮伝フラグ',
            'メーカーコード',
            '商品コード（ＧTIN）',
            '商品コード（発注用）',
            '商品コード区分',
            '商品コード（取引先）',
            '商品名',
            '商品名カナ',
            '商品コード（出荷元）',
            '商品規格：規格',
            '商品規格：規格カナ',
            'カラーコード',
            'カラー名称',
            'カラー名称カナ',
            'サイズコード',
            'サイズ名称',
            'サイズ名称カナ',
            '商品規格.生鮮：入数',
            '商品規格.生鮮：都道府県コード',
            '商品規格.生鮮：国コード',
            '商品規格.生鮮：産地名',
            '商品規格.生鮮：水域コード',
            '商品規格.生鮮：水域名',
            '商品規格.生鮮：原産エリア',
            '商品規格.生鮮：等級',
            '商品規格.生鮮：階級',
            '商品規格.生鮮：銘柄',
            '商品規格.生鮮：商品ＰＲ',
            '商品規格.生鮮：バイオ区分',
            '商品規格.生鮮：品種コード',
            '商品規格.生鮮：養殖区分',
            '商品規格.生鮮：解凍区分',
            '商品規格.生鮮：商品状態区分',
            '商品規格.生鮮：形状・部位',
            '商品規格.生鮮：用途',
            '法定管理義務商材区分',
            '原価金額',
            '原単価',
            '売価金額',
            '売単価',
            '税額',
            '発注単位',
            '発注単位コード',
            '発注荷姿コード',
            '発注数量（バラ）',
            '発注数量（発注単位数）',
            '出荷数量（バラ）',
            '出荷数量（発注単位数）',
            '欠品数量(バラ数)',
            '欠品数量(発注単位数)',
            '欠品区分',
            '取引単位重量',
            '単価登録単位',
            '商品重量',
            '発注重量',
            '出荷重量',
            'ITFコード(集合包装GTIN)',
            '出荷荷姿コード',
            '出荷数量（出荷荷姿数）',
            '賞味期限日',
            '製造日',
            '製造番号'
        ];
    }
}
