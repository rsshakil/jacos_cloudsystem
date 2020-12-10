<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataShipmentItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_shipment_item_details', function (Blueprint $table) {
            $table->increments('data_shipment_item_detail_id')->comment('data_shipment_item_detail_id');
            $table->integer('data_shipment_item_id')->comment('data_shipment_item_id');
            $table->string('mes_lis_shi_lin_pac_itf_code',15)->default('')->comment('ITFコード(集合包装GTIN)');
            $table->string('mes_lis_shi_lin_pac_package_indicator',15)->default('')->comment('出荷荷姿コード');
            $table->string('mes_lis_shi_lin_pac_number_of_packages',15)->default('')->comment('出荷数量（出荷荷姿数）');
            $table->string('mes_lis_shi_lin_pac_con_sell_by_date',15)->default('')->comment('賞味期限日');
            $table->string('mes_lis_shi_lin_pac_con_production_date',15)->default('')->comment('製造日');
            $table->string('mes_lis_shi_lin_pac_con_lot_number',15)->default('')->comment('製造番号');
            $table->smallInteger('deleted')->default(1)->comment('削除フラグ');
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
        Schema::dropIfExists('data_shipment_item_details');
    }
}
