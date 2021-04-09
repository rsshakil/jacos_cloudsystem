<?php

namespace App\Http\Controllers\API\DATA\RECEIVE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DATA\RCV\data_receive;
use App\Models\DATA\RTN\data_return;
use App\Models\ADM\User;
use App\Http\Controllers\API\AllUsedFunction;

class DataController extends Controller
{
    // private $all_used_fun;
    // public function __construct(){
    //     $this->all_used_fun = new AllUsedFunction();
    // }
    public static function getReceiveData($request)
    {
        $all_used_fun = new AllUsedFunction();
        // 対象データ取得

        // ->where('data_receive_vouchers.data_receive_id','=',$data_receive_id);
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;
        if ($request->page_title=='receive_list') {
            $receive_date_from = $request->receive_date_from; // 受信日時開始
            $receive_date_to = $request->receive_date_to; // 受信日時終了
            $ownership_date_from = $request->ownership_date_from; // 納品日開始
            $ownership_date_to = $request->ownership_date_to; // 納品日終了
            $delivery_service_code = $request->delivery_service_code; // 便
            $temperature_code = $request->temperature_code; // 配送温度区分
            $major_category = $request->major_category; // 印刷
            $sel_code = $request->sel_code; // 印刷
            $sta_doc_type = $request->sta_doc_type; // 印刷
            $check_datetime = $request->check_datetime; // 印刷

            $receive_date_from = $receive_date_from!=null? date('Y-m-d 00:00:00',strtotime($receive_date_from)):$receive_date_from; // 受信日時開始
            $receive_date_to = $receive_date_to!=null? date('Y-m-d 23:59:59',strtotime($receive_date_to)):$receive_date_to; // 受信日時終了
            $ownership_date_from = $ownership_date_from!=null? date('Y-m-d 00:00:00',strtotime($ownership_date_from)):$ownership_date_from; // 受信日時開始
            $ownership_date_to = $ownership_date_to!=null? date('Y-m-d 23:59:59',strtotime($ownership_date_to)):$ownership_date_to; // 受信日時終了
            $check_datetime = $check_datetime!=null? date('Y-m-d 00:00:00',strtotime($check_datetime)):$check_datetime; // 受信日時開始

            $table_name='drv.';
            if ($sort_by=="data_receive_id" || $sort_by=="receive_datetime") {
                $table_name='data_receives.';
                // $table_name2='data_returns.';
            }
            $result1=data_receive::select('data_receives.data_receive_id','data_receives.sta_doc_type','data_receives.receive_datetime','drv.mes_lis_acc_par_sel_code','drv.mes_lis_acc_par_sel_name',
            'drv.mes_lis_acc_tra_dat_transfer_of_ownership_date','drv.mes_lis_acc_tra_dat_delivery_date','drv.mes_lis_acc_tra_goo_major_category',
            'drv.mes_lis_acc_log_del_delivery_service_code','drv.mes_lis_acc_tra_ins_temperature_code','drv.check_datetime',
            \DB::raw('COUNT(drv.data_receive_voucher_id) AS cnt'),'drv.data_receive_voucher_id')
            ->join('data_receive_vouchers as drv','data_receives.data_receive_id','=','drv.data_receive_id');
        // ->where('data_receives.cmn_connect_id','=',$cmn_connect_id);
            // 条件指定検索
                if ($receive_date_from && $receive_date_to) {
                    $result1 =$result1->whereBetween('data_receives.receive_datetime', [$receive_date_from, $receive_date_to]);
                }
                if ($ownership_date_from && $ownership_date_to) {
                    $result1 =$result1->whereBetween('drv.mes_lis_acc_tra_dat_transfer_of_ownership_date', [$ownership_date_from, $ownership_date_to]);
                }
                if ($sel_code) {
                    $result1 =$result1->where('drv.mes_lis_acc_par_sel_code', $sel_code);
                }
                if ($delivery_service_code!='*') {
                    $result1 =$result1->where('drv.mes_lis_acc_log_del_delivery_service_code',$delivery_service_code);
                }
                if ($temperature_code!='*') {
                    $result1 =$result1->where('drv.mes_lis_acc_tra_ins_temperature_code',$temperature_code);
                }
                if ($major_category!='*') {
                    $result1 =$result1->where('drv.mes_lis_acc_tra_goo_major_category',$major_category);
                }
                if ($sta_doc_type!='*') {
                    $result1 =$result1->where('data_receives.sta_doc_type',$sta_doc_type);
                }
                if ($check_datetime!=null) {
                    $result1 =$result1->where('drv.check_datetime',$check_datetime);
                }
                $result =$result1->groupBy('drv.mes_lis_acc_tra_trade_number')
                ->orderBy($table_name.$sort_by,$sort_type);


        }else if($request->page_title=='receive_details_list'){
            $csv_data=data_receive::select('data_receives.*','drv.*','dri.*')
            ->join('data_receive_vouchers as drv','drv.data_receive_id','=','data_receives.data_receive_id')
            ->join('data_receive_items as dri','dri.data_receive_voucher_id','=','drv.data_receive_voucher_id')
            ->leftJoin('data_shipment_vouchers as dsv','dsv.mes_lis_shi_tra_trade_number','=','drv.mes_lis_acc_tra_trade_number');
            $sel_name = $request->par_sel_name;
            $sel_code = $request->sel_code;
            $major_category = $request->major_category;
            $delivery_service_code = $request->delivery_service_code;
            $data_receive_id=$request->data_receive_id;

            $decesion_status=$request->decesion_status;
            $voucher_class=$request->voucher_class;
            $goods_classification_code=$request->goods_classification_code;
            $trade_number=$request->trade_number;
            $table_name='drv.';

            // ->where('data_receive_vouchers.mes_lis_acc_par_sel_name',$sel_name)
            $csv_data=$csv_data->where('data_receives.data_receive_id',$data_receive_id)
            ->where('drv.mes_lis_acc_par_sel_code',$sel_code)
            // ->where('dsv.mes_lis_shi_tra_goo_major_category','=',$major_category);
            ->where('drv.mes_lis_acc_log_del_delivery_service_code','=',$delivery_service_code);
            if($decesion_status!="*"){
                if($decesion_status=="訂正あり"){
                    $csv_data=$csv_data->where('drv.mes_lis_acc_tot_tot_net_price_total','>',0);
                }
                if($decesion_status=="訂正なし"){
                    $csv_data=$csv_data->where('drv.mes_lis_acc_tot_tot_net_price_total',0);
                }
            }
            if($request->mes_lis_acc_par_shi_code!=''){
                $csv_data=$csv_data->where('drv.mes_lis_acc_par_shi_code',$request->mes_lis_acc_par_shi_code);
            }
            if($request->mes_lis_acc_par_rec_code!=''){
                $csv_data=$csv_data->where('drv.mes_lis_acc_par_rec_code',$request->mes_lis_acc_par_rec_code);
            }
            if($voucher_class!="*"){
                $csv_data=$csv_data->where('drv.mes_lis_acc_tra_ins_trade_type_code',$voucher_class);
            }
            if($goods_classification_code!="*"){
                $csv_data=$csv_data->where('drv.mes_lis_acc_tra_ins_goods_classification_code',$goods_classification_code);
            }
            if($trade_number!=null){
                $csv_data=$csv_data->where('drv.mes_lis_acc_tra_trade_number',$trade_number);
            }
            $result=$csv_data->groupBy('drv.mes_lis_acc_tra_trade_number')
            ->orderBy($table_name.$sort_by,$sort_type);
        }

        // $csv_data=$csv_data->groupBy('drv.data_receive_voucher_id');
        return $result;
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
