<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmnConnectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cmn_connects', function (Blueprint $table) {
            $table->increments('cmn_connect_id')->unsigned()->comment('cmn_connect_id');
            $table->integer('byr_buyer_id')->unsigned()->comment('小売ID');
            $table->integer('byr_shop_id')->nullable()->unsigned()->comment('byr_shop_id');
            $table->integer('slr_seller_id')->unsigned()->comment('slr_seller_id');
            $table->integer('slr_ware_house_id')->nullable()->unsigned()->comment('slr_ware_house_id null is all shops');
            $table->string('partner_code',10)->default(0)->comment('取引先コード');
            $table->boolean('is_active')->default(1)->comment('1 active / 0 not active');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time of creation');
			$table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('last updated time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cmn_connects');
    }
}
