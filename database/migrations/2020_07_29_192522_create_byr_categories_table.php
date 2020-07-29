<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateByrCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('byr_categories', function (Blueprint $table) {
            $table->increments('category_id')->unsigned()->comment('category_id');
            $table->integer('parent_id')->default(0)->unsigned()->comment('parent_id');
            $table->integer('super_market_id')->default(0)->unsigned()->comment('super_market_id');
            $table->tinyInteger('is_deleted')->default(0)->comment('delete status');
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
        Schema::dropIfExists('byr_categories');
    }
}
