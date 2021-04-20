<?php

namespace App\Http\Controllers\API\DATA\RECEIVE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DATA\RCV\data_receive;
use App\Models\DATA\RCV\data_receive_voucher;
use App\Models\DATA\RTN\data_return;
use App\Models\ADM\User;
use App\Http\Controllers\API\AllUsedFunction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataController extends Controller
{
    // private $all_used_fun;
    // public function __construct(){
    //     $this->all_used_fun = new AllUsedFunction();
    // }
    public static function getReceiveData($request)
    {
        // return ;
        // Log::info($request->all());

        $all_used_fun = new AllUsedFunction();
        // 対象データ取得

        // ->where('data_receive_vouchers.data_receive_id','=',$data_receive_id);
        $sort_by = $request->sort_by;
        $sort_type = $request->sort_type;
        $adm_user_id = $request->adm_user_id;
        $byr_buyer_id = $request->byr_buyer_id;
        $authUser = User::find($adm_user_id);
            $cmn_company_id = '';
            $cmn_connect_id = '';
            if (!$authUser->hasRole(config('const.adm_role_name'))) {
                $cmn_company_info=$all_used_fun->get_user_info($adm_user_id,$byr_buyer_id);
                $cmn_company_id = $cmn_company_info['cmn_company_id'];
                $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
            }
        // Log::info($byr_buyer_id);
        $result=data_receive::select(
            'data_receives.sta_sen_identifier', //0
            'data_receives.sta_sen_ide_authority', //1
            'data_receives.sta_rec_identifier', //2
            'data_receives.sta_rec_ide_authority', //3
            'data_receives.sta_doc_standard', //4
            'data_receives.sta_doc_type_version', //5
            'data_receives.sta_doc_instance_identifier', //6
            'data_receives.sta_doc_type', //7
            'data_receives.sta_doc_creation_date_and_time', //8
            'data_receives.sta_bus_scope_type', //9
            'data_receives.sta_bus_scope_instance_identifier', //10
            'data_receives.sta_bus_scope_identifier', //11
            'data_receives.mes_ent_unique_creator_identification', //12
            'data_receives.mes_mes_sender_station_address', //13
            'data_receives.mes_mes_ultimate_receiver_station_address', //14
            'data_receives.mes_mes_immediate_receiver_station_addres', //15
            'data_receives.mes_mes_number_of_trading_documents', //16
            'data_receives.mes_mes_sys_key', //17
            'data_receives.mes_mes_sys_value', //18
            'data_receives.mes_lis_con_version', //19
            'data_receives.mes_lis_doc_version', //20
            'data_receives.mes_lis_ext_namespace', //21
            'data_receives.mes_lis_ext_version', //22
            'data_receives.mes_lis_pay_code', //23
            'data_receives.mes_lis_pay_gln', //24
            'data_receives.mes_lis_pay_name', //25
            'data_receives.mes_lis_pay_name_sbcs', //26
            'data_receives.mes_lis_buy_code', //27
            'data_receives.mes_lis_buy_gln', //28
            'data_receives.mes_lis_buy_name', //29
            'data_receives.mes_lis_buy_name_sbcs', //30
            'drv.*',
            )
            ->leftJoin('data_receive_vouchers as drv','data_receives.data_receive_id','=','drv.data_receive_id')
            ->where('data_receives.cmn_connect_id','=',$cmn_connect_id);
        if ($request->page_title=='receive_list') {
            $receive_date_from = $request->receive_date_from; // 受信日時開始
            $receive_date_to = $request->receive_date_to; // 受信日時終了
            $ownership_date_from = $request->ownership_date_from; // 納品日開始
            $ownership_date_to = $request->ownership_date_to; // 納品日終了
            $sel_code = $request->sel_code; // 印刷
            $delivery_service_code = $request->delivery_service_code; // 便
            $temperature_code = $request->temperature_code; // 配送温度区分
            $major_category = $request->major_category; // 印刷

            $sta_doc_type = $request->sta_doc_type; // 印刷
            $check_datetime = $request->check_datetime; // 印刷

            $receive_date_from = $receive_date_from!=null? date('Y-m-d 00:00:00',strtotime($receive_date_from)):$receive_date_from; // 受信日時開始
            $receive_date_to = $receive_date_to!=null? date('Y-m-d 23:59:59',strtotime($receive_date_to)):$receive_date_to; // 受信日時終了
            $ownership_date_from = $ownership_date_from!=null? date('Y-m-d 00:00:00',strtotime($ownership_date_from)):$ownership_date_from; // 受信日時開始
            $ownership_date_to = $ownership_date_to!=null? date('Y-m-d 23:59:59',strtotime($ownership_date_to)):$ownership_date_to; // 受信日時終了
           // $check_datetime = $check_datetime!=null? date('Y-m-d 00:00:00',strtotime($check_datetime)):$check_datetime; // 受信日時開始

            $table_name='drv.';
            if ($sort_by=="data_receive_id" || $sort_by=="receive_datetime") {
                $table_name='data_receives.';
                // $table_name2='data_returns.';
            }


                // ->leftJoin('data_receive_items as dri','dri.data_receive_voucher_id','=','drv.data_receive_voucher_id')
                // $result=$result->where('data_receives.cmn_connect_id','=',$cmn_connect_id);
                    // 条件指定検索
                        if ($receive_date_from && $receive_date_to) {
                            $result =$result->whereBetween('data_receives.receive_datetime', [$receive_date_from, $receive_date_to]);
                        }
                        if ($ownership_date_from && $ownership_date_to) {
                            $result =$result->whereBetween('drv.mes_lis_acc_tra_dat_transfer_of_ownership_date', [$ownership_date_from, $ownership_date_to]);
                        }
                        if ($sel_code) {
                            $result =$result->where('drv.mes_lis_acc_par_sel_code', $sel_code);
                        }
                        if ($delivery_service_code!='*') {
                            $result =$result->where('drv.mes_lis_acc_log_del_delivery_service_code',$delivery_service_code);
                        }
                        if ($temperature_code!='*') {
                            $result =$result->where('drv.mes_lis_acc_tra_ins_temperature_code',$temperature_code);
                        }
                        if ($major_category!='*') {
                            $result =$result->where('drv.mes_lis_acc_tra_goo_major_category',$major_category);
                        }
                        if ($sta_doc_type!='*') {
                            $result =$result->where('data_receives.sta_doc_type',$sta_doc_type);
                        }
                        if ($check_datetime!='*') {
                            if($check_datetime==1){
                                $result= $result->whereNull('drv.check_datetime');
                            }else{
                                $result= $result->whereNotNull('drv.check_datetime');
                            }

                        }

                $result = $result->groupBy(
                    [
                        'drv.mes_lis_acc_tra_trade_number'
                    ]
                )
                ->orderBy('drv.mes_lis_acc_par_sel_code')
                ->orderBy('drv.mes_lis_acc_tra_dat_transfer_of_ownership_date')
                ->orderBy('drv.mes_lis_acc_log_del_delivery_service_code')
                ->orderBy('drv.mes_lis_acc_tra_ins_temperature_code')
                ->orderBy('data_receives.receive_datetime','DESC')
                ->orderBy($table_name.$sort_by,$sort_type)
                ->orderBy('drv.mes_lis_acc_tra_goo_major_category');


        }else if($request->page_title=='receive_details_list'){
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
        $result=$result->where('drv.data_receive_id','=',$data_receive_id)
        // ->where('data_receive_vouchers.mes_lis_acc_par_sel_name',$sel_name)
        ->where('drv.mes_lis_acc_par_sel_code',$sel_code)
        ->where('drv.mes_lis_acc_tra_goo_major_category',$major_category)
        ->where('drv.mes_lis_acc_log_del_delivery_service_code','=',$delivery_service_code);
        if($decesion_status!="*"){
            if($decesion_status=="訂正あり"){
                $result = $result->where('drv.mes_lis_acc_tot_tot_net_price_total','=','data_receive_vouchers.mes_lis_shi_tot_tot_net_price_total');
            }
            if($decesion_status=="訂正なし"){
                $result = $result->where('drv.mes_lis_acc_tot_tot_net_price_total','!=','data_receive_vouchers.mes_lis_shi_tot_tot_net_price_total');
            }
        }
        if($request->mes_lis_acc_par_shi_code!=''){
            $result = $result->where('drv.mes_lis_acc_par_shi_code',$request->mes_lis_acc_par_shi_code);
        }
        if($request->mes_lis_acc_par_rec_code!=''){
            $result = $result->where('drv.mes_lis_acc_par_rec_code',$request->mes_lis_acc_par_rec_code);
        }
        if($voucher_class!="*"){
            $result = $result->where('drv.mes_lis_acc_tra_ins_trade_type_code',$voucher_class);
        }
        if($goods_classification_code!="*"){
            $result = $result->where('drv.mes_lis_acc_tra_ins_goods_classification_code',$goods_classification_code);
        }
        if($trade_number!=null){
            $result = $result->where('drv.mes_lis_acc_tra_trade_number',$trade_number);
        }
        $result=$result->groupBy('drv.mes_lis_acc_tra_trade_number')
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
