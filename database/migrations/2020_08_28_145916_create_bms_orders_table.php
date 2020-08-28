<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBmsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bms_orders', function (Blueprint $table) {
            $table->increments('bms_order_id')->comment('発注データID');
            // $table->string('file_name',100)->comment('発注ファイル名');
            $table->integer('byr_order_id')->comment('Buyer Order ID');
            // $table->string('customer_id', 6)->comment('取引先ID');
            $table->string('sta_sen_identifier', 30)->comment('送信者ＩＤ');
            $table->string('sta_sen_ide_authority', 10)->comment('送信者ＩＤ発行元');
            $table->string('sta_rec_identifier',20)->comment('受信者ＩＤ');
            $table->string('sta_rec_ide_authority', 10)->comment('受信者ＩＤ発行元');
            $table->string('sta_doc_standard', 20)->comment('標準名称');
            $table->string('sta_doc_typeVersion', 10)->comment('バージョン');
            $table->string('sta_doc_instanceIdentifier', 50)->comment('インスタンスＩＤ');
            $table->string('sta_doc_type', 10)->comment('メッセージ種');
            $table->dateTime('sta_doc_creationDateAndTime')->comment('作成日時');
            $table->string('sta_bus_scope_type', 20)->comment('タイプ');
            $table->string('sta_bus_scope_instanceIdentifier', 20)->comment('テスト区分ＩＤ');
            $table->string('sta_bus_scope_identifier', 20)->comment('最終送信先ＩＤ');
            $table->string('mes_ent_uniqueCreatorIdentification', 80)->comment('メッセージ識別ＩＤ');
            $table->string('mes_mes_senderStationAddress', 8)->comment('送信者ステーションアドレス');
            $table->string('mes_mes_ultimateReceiverStationAddress', 8)->comment('最終受信者ステーションアドレス');
            $table->string('mes_mes_immediateReceiverStationAddres', 8)->comment('直接受信者ステーションアドレス');
            $table->string('mes_mes_numberOfTradingDocuments', 7)->comment('取引数');
            $table->string('mes_mes_sys_key', 20)->comment('システム情報キー');
            $table->string('mes_mes_sys_value', 20)->comment('システム情報値');
            $table->string('mes_lis_con_version', 20)->comment('バージョン番号');
            $table->string('mes_lis_doc_version', 20)->comment('バージョン番号');
            $table->string('mes_lis_ext_namespace', 80)->comment('名前空間');
            $table->string('mes_lis_ext_version', 20)->comment('バージョン');
            $table->string('mes_lis_pay_code', 13)->comment('支払法人コード');
            $table->string('mes_lis_pay_gln', 13)->comment('支払法人GLN');
            $table->string('mes_lis_pay_name', 20)->comment('支払法人名称');
            $table->string('mes_lis_pay_name_sbcs', 20)->comment('支払法人名称カナ');
            $table->string('mes_lis_buy_code', 13)->comment('発注者コード');
            $table->string('mes_lis_buy_gln', 13)->comment('発注者GLN');
            $table->string('mes_lis_buy_name', 20)->comment('発注者名称');
            $table->string('mes_lis_buy_name_sbcs', 20)->comment('発注者名称カナ');
            $table->string('mes_lis_ord_tra_tradeNumber', 10)->comment('取引番号（発注・返品）');
            $table->string('mes_lis_ord_tra_additionalTradeNumber', 10)->comment('取引付属番号');
            $table->string('mes_lis_ord_par_shi_code', 13)->comment('直接納品先コード');
            $table->string('mes_lis_ord_par_shi_gln', 13)->comment('直接納品先GLN');
            $table->string('mes_lis_ord_par_shi_name', 20)->comment('直接納品先名称');
            $table->string('mes_lis_ord_par_shi_name_sbcs', 20)->comment('直接納品先名称カナ');
            $table->string('mes_lis_ord_par_rec_code', 13)->comment('最終納品先コード');
            $table->string('mes_lis_ord_par_rec_gln', 13)->comment('最終納品先GLN');
            $table->string('mes_lis_ord_par_rec_name', 20)->comment('最終納品先名称');
            $table->string('mes_lis_ord_par_rec_name_sbcs', 20)->comment('最終納品先名称カナ');
            $table->string('mes_lis_ord_par_tra_code', 13)->comment('計上部署コード');
            $table->string('mes_lis_ord_par_tra_gln', 13)->comment('計上部署GLN');
            $table->string('mes_lis_ord_par_tra_name', 20)->comment('計上部署名称');
            $table->string('mes_lis_ord_par_tra_name_sbcs', 20)->comment('計上部署名称（カナ）');
            $table->string('mes_lis_ord_par_dis_code', 13)->comment('陳列場所コード');
            $table->string('mes_lis_ord_par_dis_name', 20)->comment('陳列場所名称');
            $table->string('mes_lis_ord_par_dis_name_sbcs', 20)->comment('陳列場所名称カナ');
            $table->string('mes_lis_ord_par_pay_code', 13)->comment('請求取引先コード');
            $table->string('mes_lis_ord_par_pay_gln', 13)->comment('請求取引先GLN');
            $table->string('mes_lis_ord_par_pay_name', 20)->comment('請求取引先名');
            $table->string('mes_lis_ord_par_pay_name_sbcs', 20)->comment('請求取引先名カナ');
            $table->string('mes_lis_ord_par_sel_code', 13)->comment('取引先コード');
            $table->string('mes_lis_ord_par_sel_gln', 13)->comment('取引先GLN');
            $table->string('mes_lis_ord_par_sel_name', 20)->comment('取引先名称');
            $table->string('mes_lis_ord_par_sel_name_sbcs', 20)->comment('取引先名称カナ');
            $table->string('mes_lis_ord_par_sel_branchNumber', 2)->comment('枝番');
            $table->string('mes_lis_ord_par_sel_shipLocationCode', 4)->comment('出荷先コード');
            $table->string('mes_lis_ord_log_shi_gln', 13)->comment('出荷場所GLN');
            $table->string('mes_lis_ord_log_del_routeCode', 2)->comment('納品経路');
            $table->string('mes_lis_ord_log_del_deliveryServiceCode', 2)->comment('便No');
            $table->string('mes_lis_ord_log_del_stockTransferCode', 2)->comment('通過在庫区分');
            $table->string('mes_lis_ord_log_del_deliveryCode', 2)->comment('納品区分');
            $table->string('mes_lis_ord_log_del_deliveryTime', 10)->comment('指定納品時刻');
            $table->string('mes_lis_ord_log_del_transportationCode', 2)->comment('輸送手段');
            $table->string('mes_lis_ord_log_log_barcodePrint', 13)->comment('バーコード情報');
            $table->string('mes_lis_ord_log_log_categoryNamePrint1', 5)->comment('カテゴリー名称1（印字用）');
            $table->string('mes_lis_ord_log_log_categoryNamePrint2', 5)->comment('カテゴリー名称2（印字用）');
            $table->string('mes_lis_ord_log_log_receiverAbbrName', 5)->comment('最終納品先略称（印字用）');
            $table->string('mes_lis_ord_log_log_text', 60)->comment('ラベル自由使用欄（印字用）');
            $table->string('mes_lis_ord_log_log_text_sbcs', 60)->comment('ラベル自由使用欄半角カナ（印字用）');
            $table->string('mes_lis_ord_tra_goo_majorCategory', 10)->comment('商品分類（大）');
            $table->string('mes_lis_ord_tra_goo_subMajorCategory', 10)->comment('商品分類（中）');
            $table->date('mes_lis_ord_tra_dat_orderDate')->comment('発注日');
            $table->date('mes_lis_ord_tra_dat_deliveryDate')->comment('直接納品先納品日');
            $table->date('mes_lis_ord_tra_dat_deliveryDateToReceiver')->comment('最終納品先納品日');
            $table->date('mes_lis_ord_tra_dat_transferOfOwnershipDate')->comment('計上日');
            $table->date('mes_lis_ord_tra_dat_campaignStartDate')->comment('販促開始日');
            $table->date('mes_lis_ord_tra_dat_campaignEndDate')->comment('販促終了日');
            $table->date('mes_lis_ord_tra_dat_validUntilDate')->comment('取引（発注・返品）データ有効日');
            $table->string('mes_lis_ord_tra_ins_goodsClassificationCode',2)->comment('商品区分');
            $table->string('mes_lis_ord_tra_ins_orderClassificationCode',2)->comment('発注区分');
            $table->string('mes_lis_ord_tra_ins_shipNotificationRequestCode',2)->comment('出荷データ有無区分');
            $table->string('mes_lis_ord_tra_ins_privateBrandCode',2)->comment('PB区分');
            $table->string('mes_lis_ord_tra_ins_temperatureCode',2)->comment('配送温度区分');
            $table->string('mes_lis_ord_tra_ins_liquorCode',2)->comment('酒区分');
            $table->string('mes_lis_ord_tra_ins_tradeTypeCode',2)->comment('処理種別');
            $table->string('mes_lis_ord_tra_ins_paperFormLessCode',2)->comment('伝票レス区分');
            $table->string('mes_lis_ord_tra_fre_tradeNumberRequestCode',2)->comment('取引番号区分');
            $table->string('mes_lis_ord_tra_fre_packageCode',2)->comment('パック区分');
            $table->string('mes_lis_ord_tra_fre_variableMeasureItemCode',2)->comment('不定貫区分');
            $table->string('mes_lis_ord_tra_tax_taxTypeCode',2)->comment('税区分');
            $table->string('mes_lis_ord_tra_tax_taxRate',4)->comment('税率');
            $table->string('mes_lis_ord_tra_not_text',60)->comment('自由使用欄');
            $table->string('mes_lis_ord_tra_not_text_sbcs',60)->comment('自由使用欄半角カナ');
            $table->string('mes_lis_ord_tot_tot_netPriceTotal',10)->comment('原価金額合計');
            $table->string('mes_lis_ord_tot_tot_sellingPriceTotal',10)->comment('売価金額合計');
            $table->string('mes_lis_ord_tot_tot_taxTotal',10)->comment('税額合計金額');
            $table->string('mes_lis_ord_tot_tot_itemTotal',6)->comment('数量合計');
            $table->string('mes_lis_ord_tot_tot_unitTotal',6)->comment('発注単位数量合計');
            $table->string('mes_lis_ord_tot_fre_unitWeightTotal',14)->comment('重量合計');
            $table->string('mes_lis_ord_lin_lin_lineNumber',4)->comment('取引明細番号（発注・返品）');
            $table->string('mes_lis_ord_lin_lin_additionalLineNumber',4)->comment('取引付属明細番号');
            $table->string('mes_lis_ord_lin_fre_tradeNumber',10)->comment('元取引番号');
            $table->string('mes_lis_ord_lin_fre_lineNumber',4)->comment('元取引明細番号');
            $table->string('mes_lis_ord_lin_goo_minorCategory',10)->comment('商品分類（小）');
            $table->string('mes_lis_ord_lin_goo_detailedCategory',10)->comment('商品分類（細）');
            $table->date('mes_lis_ord_lin_ite_scheduledDate')->comment('配達予定日');
            $table->string('mes_lis_ord_lin_ite_deadlineDate',8)->comment('納品期限');
            $table->string('mes_lis_ord_lin_ite_centerDeliveryInstructionCode',2)->comment('センター納品詳細指示');
            $table->string('mes_lis_ord_lin_ite_makerCode',13)->comment('メーカーコード');
            $table->string('mes_lis_ord_lin_ite_gtin',14)->comment('商品コード（ＧTIN）');
            $table->string('mes_lis_ord_lin_ite_orderItemCode',14)->comment('商品コード（発注用）');
            $table->string('mes_lis_ord_lin_ite_codeType',3)->comment('商品コード区分');
            $table->string('mes_lis_ord_lin_ite_supplierItemCode',14)->comment('商品コード（取引先）');
            $table->string('mes_lis_ord_lin_ite_name',25)->comment('商品名');
            $table->string('mes_lis_ord_lin_ite_name_sbcs',25)->comment('商品名カナ');
            $table->string('mes_lis_ord_lin_ite_ite_spec',25)->comment('規格');
            $table->string('mes_lis_ord_lin_ite_ite_spec_sbcs',25)->comment('規格カナ');
            $table->string('mes_lis_ord_lin_ite_col_colorCode',10)->comment('カラーコード');
            $table->string('mes_lis_ord_lin_ite_col_description',20)->comment('カラー名称');
            $table->string('mes_lis_ord_lin_ite_col_description_sbcs',20)->comment('カラー名称カナ');
            $table->string('mes_lis_ord_lin_ite_siz_sizeCode',10)->comment('サイズコード');
            $table->string('mes_lis_ord_lin_ite_siz_description',30)->comment('サイズ名称');
            $table->string('mes_lis_ord_lin_ite_siz_description_sbcs',30)->comment('サイズ名称カナ');
            $table->string('mes_lis_ord_lin_fre_packingQuantity',4)->comment('入数');
            $table->string('mes_lis_ord_lin_fre_prefectureCode',3)->comment('都道府県コード');
            $table->string('mes_lis_ord_lin_fre_countryCode',3)->comment('国コード');
            $table->string('mes_lis_ord_lin_fre_fieldName',20)->comment('産地名');
            $table->string('mes_lis_ord_lin_fre_waterAreaCode',2)->comment('水域コード');
            $table->string('mes_lis_ord_lin_fre_waterAreaName',20)->comment('水域名');
            $table->string('mes_lis_ord_lin_fre_areaOfOrigin',30)->comment('原産エリア');
            $table->string('mes_lis_ord_lin_fre_itemGrade',8)->comment('等級');
            $table->string('mes_lis_ord_lin_fre_itemClass',8)->comment('階級');
            $table->string('mes_lis_ord_lin_fre_brand',30)->comment('銘柄');
            $table->string('mes_lis_ord_lin_fre_itemPR',30)->comment('商品ＰＲ');
            $table->string('mes_lis_ord_lin_fre_bioCode',2)->comment('バイオ区分');
            $table->string('mes_lis_ord_lin_fre_breedCode',2)->comment('品種コード');
            $table->string('mes_lis_ord_lin_fre_cultivationCode',2)->comment('養殖区分');
            $table->string('mes_lis_ord_lin_fre_defrostCode',2)->comment('解凍区分');
            $table->string('mes_lis_ord_lin_fre_itemPreservationCode',2)->comment('商品状態区分');
            $table->string('mes_lis_ord_lin_fre_itemShapeCode',5)->comment('形状・部位');
            $table->string('mes_lis_ord_lin_fre_use',20)->comment('用途');
            $table->string('mes_lis_ord_lin_sta_statutoryClassificationCode',2)->comment('法定管理義務商材区分');
            $table->integer('mes_lis_ord_lin_amo_itemNetPrice')->comment('原価金額');
            $table->decimal('mes_lis_ord_lin_amo_itemNetPrice_unitPrice',13,2)->comment('原単価');
            $table->integer('mes_lis_ord_lin_amo_itemSellingPrice')->comment('売価金額');
            $table->integer('mes_lis_ord_lin_amo_itemSellingPrice_unitPrice')->comment('売単価');
            $table->string('mes_lis_ord_lin_amo_itemTax',10)->comment('税額');
            $table->string('mes_lis_ord_lin_qua_unitMultiple',4)->comment('発注単位');
            $table->string('mes_lis_ord_lin_qua_unitOfMeasure',2)->comment('発注単位コード');
            $table->string('mes_lis_ord_lin_qua_packageIndicator',2)->comment('発注荷姿コード');
            $table->decimal('mes_lis_ord_lin_qua_ord_quantity',9,1)->comment('発注数量（バラ）');
            $table->integer('mes_lis_ord_lin_qua_ord_numOfOrderUnits')->comment('発注数量（発注単位数）');
            $table->string('mes_lis_ord_lin_fre_unitWeight',15)->comment('取引単位重量');
            $table->string('mes_lis_ord_lin_fre_unitWeightCode',2)->comment('単価登録単位');
            $table->string('mes_lis_ord_lin_fre_itemWeight',13)->comment('商品重量');
            $table->string('mes_lis_ord_lin_fre_orderWeight',15)->comment('発注重量');
            $table->smallInteger('deleted')->comment('削除フラグ');
			$table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('登録日時');
			$table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bms_orders');
    }
}
