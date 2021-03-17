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
            $csv_data=$csv_data->where('data_invoice_pay_details.decision_datetime','!=',null);
            $csv_data=$csv_data->where('data_invoice_pay_details.send_datetime','=',null);
        }
        $csv_data=$csv_data->groupBy('data_invoice_pay_details.data_invoice_pay_detail_id');
        $csv_data=$csv_data->orderBy("data_invoices.data_invoice_id");
        // 検索
        // $csv_data = $csv_data->limit(100000)->get()->toArray();
        return $csv_data;
    }
    public static function invoiceCsvHeading(){
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
