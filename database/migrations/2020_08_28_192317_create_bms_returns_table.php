<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBmsReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bms_returns', function (Blueprint $table) {
            $table->increments('bms_return_id')->comment('返品データID');
            $table->integer('byr_return_id')->comment('byr_return_id');
            // $table->string('file_name',100)->comment('発注ファイル名');
            // $table->string('customer_id', 8)->comment('取引先ID');
            $table->string('sta_sen_identifier', 30)->comment('送信者ＩＤ');
            $table->string('sta_sen_ide_authority', 10)->comment('送信者ＩＤ発行元');
            $table->string('sta_rec_identifier',20)->comment('受信者ＩＤ');
            $table->string('Sta_Rec_identifierAuthority', 10)->comment('受信者ＩＤ発行元');
            $table->string('sta_doc_standard', 20)->comment('標準名称');
            $table->string('sta_doc_typeVersion', 10)->comment('バージョン');
            $table->string('sta_doc_instanceIdentifier', 50)->comment('インスタンスＩＤ');
            $table->string('sta_doc_type', 30)->comment('メッセージ種');
            $table->dateTime('sta_doc_creationDateAndTime')->comment('作成日時');
            $table->string('sta_bus_scope_type', 10)->comment('タイプ');
            $table->string('sta_bus_scope_instanceIdentifier', 10)->comment('テスト区分ＩＤ');
            $table->string('sta_bus_scope_identifier', 10)->comment('最終送信先ＩＤ');
            $table->string('mes_ent_uniqueCreatorIdentification', 80)->comment('メッセージ識別ＩＤ');
            $table->string('mes_mes_senderStationAddress', 8)->comment('送信者ステーションアドレス');
            $table->string('mes_mes_ultimateReceiverStationAddress', 8)->comment('最終受信者ステーションアドレス');
            $table->string('mes_mes_immediateReceiverStationAddres', 8)->comment('直接受信者ステーションアドレス');
            $table->string('mes_mes_numberOfTradingDocuments', 7)->comment('取引数');
            $table->string('mes_mes_sys_key', 20)->comment('キー');
            $table->string('mes_mes_sys_value', 20)->comment('値');
            $table->string('mes_lis_con_version', 20)->comment('バージョン番号');
            $table->string('mes_lis_doc_version', 20)->comment('バージョン番号');
            $table->string('mes_lis_ext_namespace', 80)->comment('名前空間');
            $table->string('mes_lis_ext_version', 20)->comment('バージョン');
            $table->string('mes_lis_pay_code', 13)->comment('支払法人コード');
            $table->string('mes_lis_pay_gln', 13)->comment('支払法人GLN');
            $table->string('mes_lis_pay_name', 20)->comment('支払法人名称');
            $table->string('mes_lis_pay_name_sbcs', 20)->comment('支払法人名称カナ');
            $table->string('mes_lis_ret_code', 13)->comment('発注者コード');
            $table->string('mes_lis_ret_gln', 13)->comment('発注者GLN');
            $table->string('mes_lis_ret_name', 20)->comment('発注者名称');
            $table->string('mes_lis_ret_name_sbcs', 20)->comment('発注者名称カナ');
            $table->string('mes_lis_ret_tra_tradeNumber', 10)->comment('取引番号（発注・返品）');
            $table->string('mes_lis_ret_tra_additionalTradeNumber', 10)->comment('取引付属番号');
            $table->string('mes_lis_ret_fre_shipmentNumber', 10)->comment('出荷者管理番号');
            $table->string('mes_lis_ret_par_returnReceiveFrom_code', 13)->comment('直接納品先コード');
            $table->string('mes_lis_ret_par_returnReceiveFrom_gln', 13)->comment('直接納品先GLN');
            $table->string('mes_lis_ret_par_returnReceiveFrom_name', 20)->comment('直接納品先名称');
            $table->string('mes_lis_ret_par_returnReceiveFrom_name_sbcs', 20)->comment('直接納品先名称カナ');
            $table->string('mes_lis_ret_par_returnFrom_code', 13)->comment('最終納品先コード');
            $table->string('mes_lis_ret_par_returnFrom_gln', 13)->comment('最終納品先GLN');
            $table->string('mes_lis_ret_par_returnFrom_name', 20)->comment('最終納品先名称');
            $table->string('mes_lis_ret_par_returnFrom_name_sbcs', 20)->comment('最終納品先名称カナ');
            $table->string('mes_lis_ret_par_tra_code', 13)->comment('計上部署コード');
            $table->string('mes_lis_ret_par_tra_gln', 13)->comment('計上部署GLN');
            $table->string('mes_lis_ret_par_tra_name', 20)->comment('計上部署名称');
            $table->string('mes_lis_ret_par_tra_name_sbcs', 20)->comment('計上部署名称（カナ）');
            $table->string('mes_lis_ret_par_pay_code', 13)->comment('請求取引先コード');
            $table->string('mes_lis_ret_par_pay_gln', 13)->comment('請求取引先GLN');
            $table->string('mes_lis_ret_par_pay_name', 20)->comment('請求取引先名');
            $table->string('mes_lis_ret_par_pay_name_sbcs', 20)->comment('請求取引先名カナ');
            $table->string('mes_lis_ret_par_sel_code', 13)->comment('取引先コード');
            $table->string('mes_lis_ret_par_sel_gln', 13)->comment('取引先GLN');
            $table->string('mes_lis_ret_par_sel_name', 20)->comment('取引先名称');
            $table->string('mes_lis_ret_par_sel_name_sbcs', 20)->comment('取引先名称カナ');
            $table->string('mes_lis_ret_par_sel_branchNumber', 2)->comment('枝番');
            $table->string('mes_lis_ret_par_sel_shipLocationCode', 4)->comment('出荷先コード');
            $table->string('mes_lis_ret_log_returnGoodsTransferType', 5)->comment('商品移動区分');
            $table->string('mes_lis_ret_tra_goo_majorCategory', 10)->comment('商品分類（大）');
            $table->string('mes_lis_ret_tra_goo_subMajorCategory', 20)->comment('商品分類（中）');
            $table->date('mes_lis_ret_tra_dat_transferOfOwnershipDate')->comment('計上日');
            $table->date('mes_lis_ret_tra_dat_checkingDate')->comment('照合基準日');
            $table->date('mes_lis_ret_tra_dat_checkingDateCode')->comment('照合基準日区分');
            $table->string('mes_lis_ret_tra_ins_goodsClassificationCode',2)->comment('商品区分');
            $table->string('mes_lis_ret_tra_ins_tradeTypeCode',2)->comment('処理種別');
            $table->string('mes_lis_ret_tra_ins_deliveryFeeExemptionCode',2)->comment('配送料免除区分');
            $table->string('mes_lis_ret_tra_ins_paperFormLessCode',2)->comment('伝票レス区分');
            $table->string('mes_lis_ret_tra_fre_tradeNumberRequestCode',4)->comment('取引番号区分');
            $table->string('mes_lis_ret_tra_fre_packageCode',2)->comment('パック区分');
            $table->string('mes_lis_ret_tra_fre_variableMeasureItemCode',5)->comment('不定貫区分');
            $table->string('mes_lis_ret_tra_tax_taxTypeCode',60)->comment('税区分');
            $table->string('mes_lis_ret_tra_tax_taxRate',60)->comment('税率');
            $table->string('mes_lis_ret_tra_packageNumber',10)->comment('梱包NO');
            $table->string('mes_lis_ret_tra_not_text',60)->comment('自由使用欄');
            $table->string('mes_lis_ret_tra_not_text_sbcs',60)->comment('自由使用欄半角カナ');
            $table->integer('mes_lis_ret_tot_tot_netPriceTotal')->comment('原価金額合計');
            $table->integer('mes_lis_ret_tot_tot_sellingPriceTotal')->comment('売価金額合計');
            $table->integer('mes_lis_ret_tot_tot_taxTotal')->comment('税額合計金額');
            $table->integer('mes_lis_ret_tot_tot_itemTotal')->comment('数量合計');
            $table->integer('mes_lis_ret_tot_fre_unitWeightTotal')->comment('重量合計');
            $table->string('mes_lis_ret_lin_lin_lineNumber',10)->comment('取引明細番号（発注・返品）');
            $table->string('mes_lis_ret_lin_lin_additionalLineNumber',10)->comment('取引付属明細番号');
            $table->string('mes_lis_ret_lin_fre_tradeNumber',10)->comment('元取引番号');
            $table->string('mes_lis_ret_lin_fre_lineNumber',10)->comment('元取引明細番号');
            $table->string('mes_lis_ret_lin_fre_shipmentLineNumber',10)->comment('出荷者管理明細番号');
            $table->string('mes_lis_ret_lin_goo_minorCategory',13)->comment('商品分類（小）');
            $table->string('mes_lis_ret_lin_goo_detailedCategory',14)->comment('商品分類（細）');
            $table->string('mes_lis_ret_lin_reasonCode',14)->comment('返品・値引理由コード');
            $table->string('mes_lis_ret_lin_ite_makerCode',3)->comment('メーカーコード');
            $table->string('mes_lis_ret_lin_ite_gtin',14)->comment('商品コード（ＧTIN）');
            $table->string('mes_lis_ret_lin_ite_orderItemCode',25)->comment('商品コード（発注用）');
            $table->string('mes_lis_ret_lin_ite_codeType',25)->comment('商品コード区分');
            $table->string('mes_lis_ret_lin_ite_supplierItemCode',25)->comment('商品コード（取引先）');
            $table->string('mes_lis_ret_lin_ite_name',25)->comment('商品名');
            $table->string('mes_lis_ret_lin_ite_name_sbcs',25)->comment('商品名カナ');
            $table->string('mes_lis_ret_lin_fre_shipmentItemCode',10)->comment('商品コード（出荷元）');
            $table->string('mes_lis_ret_lin_ite_ite_spec',20)->comment('規格');
            $table->string('mes_lis_ret_lin_ite_ite_spec_sbcs',20)->comment('規格カナ');
            $table->string('mes_lis_ret_lin_ite_col_colorCode',20)->comment('カラーコード');
            $table->string('mes_lis_ret_lin_ite_col_description',20)->comment('カラー名称');
            $table->string('mes_lis_ret_lin_ite_col_description_sbcs',20)->comment('カラー名称カナ');
            $table->string('mes_lis_ret_lin_fre_packingQuantity',20)->comment('入数');
            $table->string('mes_lis_ret_lin_fre_prefectureCode',20)->comment('都道府県コード');
            $table->string('mes_lis_ret_lin_fre_countryCode',20)->comment('国コード');
            $table->string('mes_lis_ret_lin_fre_fieldName',20)->comment('産地名');
            $table->string('mes_lis_ret_lin_fre_waterAreaCode',2)->comment('水域コード');
            $table->string('mes_lis_ret_lin_fre_waterAreaName',20)->comment('水域名');
            $table->string('mes_lis_ret_lin_fre_areaOfOrigin',20)->comment('原産エリア');
            $table->string('mes_lis_ret_lin_fre_itemGrade',20)->comment('等級');
            $table->string('mes_lis_ret_lin_fre_itemClass',20)->comment('階級');
            $table->string('mes_lis_ret_lin_fre_brand',20)->comment('銘柄');
            $table->string('mes_lis_ret_lin_fre_itemPR',20)->comment('商品ＰＲ');
            $table->string('mes_lis_ret_lin_fre_bioCode',20)->comment('バイオ区分');
            $table->string('mes_lis_ret_lin_fre_breedCode',20)->comment('品種コード');
            $table->string('mes_lis_ret_lin_fre_cultivationCode',20)->comment('養殖区分');
            $table->string('mes_lis_ret_lin_fre_defrostCode',20)->comment('解凍区分');
            $table->string('mes_lis_ret_lin_fre_itemPreservationCode',20)->comment('商品状態区分');
            $table->string('mes_lis_ret_lin_fre_itemShapeCode',20)->comment('形状・部位');
            $table->string('mes_lis_ret_lin_fre_use',20)->comment('用途');
            $table->string('mes_lis_ret_lin_ite_siz_sizeCode',10)->comment('サイズコード');
            $table->string('mes_lis_ret_lin_ite_siz_description',30)->comment('サイズ名称');
            $table->string('mes_lis_ret_lin_ite_siz_description_sbcs',30)->comment('サイズ名称カナ');
            $table->string('mes_lis_ret_lin_sta_statutoryClassificationCode',2)->comment('法定管理義務商材区分');
            $table->integer('mes_lis_ret_lin_amo_itemNetPrice')->comment('原価金額');
            $table->decimal('mes_lis_ret_lin_amo_itemNetPrice_unitPrice',13,0)->comment('原単価');
            $table->integer('mes_lis_ret_lin_amo_itemSellingPrice')->comment('売価金額');
            $table->integer('mes_lis_ret_lin_amo_itemSellingPrice_unitPrice')->comment('売単価');
            $table->string('mes_lis_ret_lin_amo_itemTax',10)->comment('税額');
            $table->string('mes_lis_ret_lin_qua_quantity',10)->comment('返品数量（バラ）');
            $table->string('mes_lis_ret_lin_fre_unitWeightCode',10)->comment('単価登録単位');
            $table->string('mes_lis_ret_lin_fre_itemWeight',10)->comment('商品重量');
            $table->string('mes_lis_ret_lin_fre_returnWeight',10)->comment('返品重量');
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
        Schema::dropIfExists('bms_returns');
    }
}
