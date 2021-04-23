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
        // $order_info=$request->order_info;
        // $request_all=$request->all();
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;

        $csv_data=data_invoice::select('data_invoices.*','dip.*','dipd.*')
        ->join('data_invoice_pays as dip','dip.data_invoice_id','=','data_invoices.data_invoice_id')
        ->join('data_invoice_pay_details as dipd','dipd.data_invoice_pay_id','=','dip.data_invoice_pay_id');
        // filtering
        // if (!(array_key_exists("downloadType", $request_all))) {
        if ($request->page_title=='invoice_list') {

            $table_name='data_invoices.';
            if ($sort_by=="data_invoice_id") {
                $table_name='data_invoices.';
            }else if($sort_by=="mes_lis_inv_lin_det_amo_requested_amount"){
                $table_name='dipd.';
            }else{
                $table_name='dip.';
            }
            // $csv_data=$csv_data->where('dipd.decision_datetime','!=',null);
            // $csv_data=$csv_data->where('dipd.send_datetime','=',null);

            $mes_lis_inv_pay_code=$request->mes_lis_inv_pay_code;
            $send_datetime_status=$request->send_datetime_status;
            $mes_lis_inv_pay_id=$request->mes_lis_inv_pay_id;
            if ($mes_lis_inv_pay_code!=null) {
                $csv_data=$csv_data->where('dip.mes_lis_inv_pay_code','=',$mes_lis_inv_pay_code);
            }
            if ($mes_lis_inv_pay_id!='') {
                $csv_data=$csv_data->where('dip.mes_lis_inv_pay_id','=',$mes_lis_inv_pay_id);
            }
            // if ($mes_lis_inv_per_begin_date && $mes_lis_inv_per_end_date) {
            //     $result=$result->whereBetween('dip.mes_lis_inv_per_end_date', [$mes_lis_inv_per_begin_date, $mes_lis_inv_per_end_date]);
            // }
            // will confirm
            if ($send_datetime_status=='未請求'){
                $csv_data=$csv_data->where('dipd.send_datetime','=',null);
            }else if ($send_datetime_status=='請求済'){
                $csv_data=$csv_data->where('dipd.send_datetime','!=',null);
            }else if ($send_datetime_status=='再請求あり'){
                $csv_data=$csv_data->where('dipd.send_datetime','!=',null);
            }
            $csv_data=$csv_data->orderBy($table_name.$sort_by,$sort_type);

        }else if($request->page_title=='invoice_details_list'){
            // \Log::info("Mayeen");
            $number_reference=$request->mes_lis_inv_lin_lin_trade_number_reference;
            $decision_datetime_status=$request->decision_datetime_status;
            $send_datetime_status=$request->send_datetime_status;
            $mes_lis_inv_lin_tra_code=$request->mes_lis_inv_lin_tra_code;
            $category_code = $request->category_code;
            $category_code =$category_code['category_code'];
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $param_data = $request->param_data;
            $csv_data=$csv_data->where('data_invoices.data_invoice_id',$data_invoice_id);
            if ($decision_datetime_status=='未確定あり'){
                $csv_data=$csv_data->where('dipd.decision_datetime','=',null);
            }else if ($decision_datetime_status=='確定済'){
                $csv_data=$csv_data->where('dipd.decision_datetime','!=',null);
            }
            if ($send_datetime_status=='未確定あり'){
                $csv_data=$csv_data->where('dipd.send_datetime','=',null);
            }else if ($send_datetime_status=='確定済'){
                $csv_data=$csv_data->where('dipd.send_datetime','!=',null);
            }

            if($from_date!=''){
                $csv_data=$csv_data->where('dipd.mes_lis_inv_lin_det_transfer_of_ownership_date','>=',$from_date);
            }

            if($to_date!=''){
                $csv_data=$csv_data->where('dipd.mes_lis_inv_lin_det_transfer_of_ownership_date','<=',$to_date);
            }

            if($number_reference!=null){
                $csv_data=$csv_data->where('dipd.mes_lis_inv_lin_lin_trade_number_reference','=',$number_reference);
            }

            if($category_code!='*'){
                $csv_data=$csv_data->where('dipd.mes_lis_inv_lin_det_goo_major_category','=',$category_code);
            }

            if($mes_lis_inv_lin_tra_code!=''){
                $csv_data=$csv_data->where('dipd.mes_lis_inv_lin_tra_code','=',$mes_lis_inv_lin_tra_code);
            }
            $csv_data=$csv_data->orderBy('dipd.'.$sort_by,$sort_type);
            $csv_data=$csv_data->where('dip.mes_lis_inv_per_end_date',$param_data['end_date'])
            ->where('dip.mes_lis_inv_pay_code',$param_data['pay_code'])
            // ->where('dip.mes_lis_inv_pay_name',$param_data['pay_name'])
            // ->where('dip.mes_lis_buy_code',$param_data['buy_code'])
            // ->where('dip.mes_lis_buy_name',$param_data['buy_name'])
            ->where('dip.status',$param_data['status']);
        }
        $csv_data=$csv_data->groupBy('dipd.data_invoice_pay_detail_id');
        // $csv_data=$csv_data->orderBy("data_invoices.data_invoice_id");
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
    public static function invoiceCompareCsvHeading(){
        return [
            "mes_lis_shi_par_sel_code",
            "mes_lis_shi_tra_trade_number",
            "mes_lis_shi_par_shi_code",
            "mes_lis_shi_par_shi_name",
            "shipment_delivery_date",
            "mes_lis_acc_tra_dat_transfer_of_ownership_date",
            "mes_lis_shi_tot_tot_net_price_total",
            "mes_lis_acc_tot_tot_net_price_total",
            "mes_lis_shi_lin_lin_line_number",
            "mes_lis_shi_lin_ite_order_item_code",
            "mes_lis_shi_lin_ite_name",
            "mes_lis_shi_lin_qua_shi_quantity",
            "mes_lis_acc_lin_qua_rec_quantity",
            "mes_lis_shi_lin_amo_item_net_price",
            "mes_lis_acc_lin_amo_item_net_price",
        ];
    }
}
