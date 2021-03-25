<?php

namespace App\Http\Controllers\API\DATA\PAYMENT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DATA\PAYMENT\data_payment;

class DataController extends Controller
{
    public static function getPaymentData($request)
    {
        // 対象データ取得
        $data_payment_id=$request->data_payment_id;
        $request_all=$request->all();

        $csv_data=data_payment::select(
            // data_payments
            'data_payments.sta_sen_identifier',
            'data_payments.sta_sen_ide_authority',
            'data_payments.sta_rec_identifier',
            'data_payments.sta_rec_ide_authority',
            'data_payments.sta_doc_standard',
            'data_payments.sta_doc_type_version',
            'data_payments.sta_doc_instance_identifier',
            'data_payments.sta_doc_type',
            'data_payments.sta_doc_creation_date_and_time',
            'data_payments.sta_bus_scope_type',
            'data_payments.sta_bus_scope_instance_identifier',
            'data_payments.sta_bus_scope_identifier',
            'data_payments.mes_ent_unique_creator_identification',
            'data_payments.mes_mes_sender_station_address',
            'data_payments.mes_mes_ultimate_receiver_station_address',
            'data_payments.mes_mes_immediate_receiver_station_addres',
            'data_payments.mes_mes_number_of_trading_documents',
            'data_payments.mes_mes_sys_key',
            'data_payments.mes_mes_sys_value',
            'data_payments.mes_lis_con_version',
            'data_payments.mes_lis_doc_version',
            'data_payments.mes_lis_ext_version',
            'data_payments.mes_lis_pay_code',
            'data_payments.mes_lis_pay_gln',
            'data_payments.mes_lis_pay_name',
            'data_payments.mes_lis_pay_name_sbcs',
            // data_payment_pays
            'dpp.mes_lis_buy_code',
            'dpp.mes_lis_buy_gln',
            'dpp.mes_lis_buy_name',
            'dpp.mes_lis_buy_name_sbcs',
            'dpp.mes_lis_pay_pay_code',
            'dpp.mes_lis_pay_pay_id',
            'dpp.mes_lis_pay_pay_gln',
            'dpp.mes_lis_pay_pay_name',
            'dpp.mes_lis_pay_pay_name_sbcs',
            'dpp.mes_lis_pay_per_begin_date',
            'dpp.mes_lis_pay_per_end_date',

            // data_payment_pay_details
            'dppd.mes_lis_pay_lin_lin_trade_number_eference',
            'dppd.mes_lis_pay_lin_lin_issue_classification_code',
            'dppd.mes_lis_pay_lin_lin_sequence_number',
            'dppd.mes_lis_pay_lin_tra_code',
            'dppd.mes_lis_pay_lin_tra_gln',
            'dppd.mes_lis_pay_lin_tra_name',
            'dppd.mes_lis_pay_lin_tra_name_sbcs',
            'dppd.mes_lis_pay_lin_sel_code',
            'dppd.mes_lis_pay_lin_sel_gln',
            'dppd.mes_lis_pay_lin_sel_name',
            'dppd.mes_lis_pay_lin_sel_name_sbcs',
            'dppd.mes_lis_pay_lin_det_goo_major_category',
            'dppd.mes_lis_pay_lin_det_goo_sub_major_category',
            'dppd.mes_lis_pay_lin_det_transfer_of_ownership_date',
            'dppd.mes_lis_pay_lin_det_pay_out_date',
            'dppd.mes_lis_pay_lin_det_amo_requested_amount',
            'dppd.mes_lis_pay_lin_det_amo_req_plus_minus',
            'dppd.mes_lis_pay_lin_det_amo_payable_amount',
            'dppd.mes_lis_pay_lin_det_amo_pay_plus_minus',
            'dppd.mes_lis_pay_lin_det_amo_optional_amount',
            'dppd.mes_lis_pay_lin_det_amo_opt_plus_minus',
            'dppd.mes_lis_pay_lin_det_amo_tax',
            'dppd.mes_lis_pay_lin_det_trade_type_code',
            'dppd.mes_lis_pay_lin_det_balance_carried_code',
            'dppd.mes_lis_pay_lin_det_creditor_unsettled_code',
            'dppd.mes_lis_pay_lin_det_verification_result_code',
            'dppd.mes_lis_pay_lin_det_pay_code',
            'dppd.mes_lis_pay_lin_det_det_code',
            'dppd.mes_lis_pay_lin_det_det_meaning',
            'dppd.mes_lis_pay_lin_det_det_meaning_sbcs',
            'dppd.mes_lis_pay_lin_det_payment_method_code',
            'dppd.mes_lis_pay_lin_det_tax_tax_type_code',
            'dppd.mes_lis_pay_lin_det_tax_tax_rate'
            )
        ->join('data_payment_pays as dpp','dpp.data_payment_id','=','data_payments.data_payment_id')
        ->join('data_payment_pay_details as dppd','dppd.data_payment_pay_id','=','dpp.data_payment_pay_id');
        if (array_key_exists("data_payment_id", $request_all)) {
            $csv_data=$csv_data->where('data_payments.data_payment_id',$data_payment_id);
        }

        // if (!(array_key_exists("downloadType", $request_all))) {
        //     $csv_data=$csv_data->where('dppd.decision_datetime','!=',null);
        //     $csv_data=$csv_data->where('dppd.send_datetime','=',null);
        // }
        $csv_data=$csv_data->groupBy('dppd.data_payment_pay_detail_id');
        $csv_data=$csv_data->orderBy("data_payments.data_payment_id");
        // 検索
        // $csv_data = $csv_data->limit(100000)->get()->toArray();
        return $csv_data;
    }

    public static function paymentCsvHeading(){
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