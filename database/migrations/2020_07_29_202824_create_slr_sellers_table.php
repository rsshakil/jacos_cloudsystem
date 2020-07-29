<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlrSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slr_sellers', function (Blueprint $table) {
            $table->increments('slr_seller_id')->unsigned()->comment('slr_seller_id');
            $table->integer('cmn_company_id')->unsigned()->default(0)->comment('cmn_company_id');
            $table->integer('adm_role_id')->unsigned()->default(0)->comment('adm_role_id');
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
        Schema::dropIfExists('slr_sellers');
    }
}
