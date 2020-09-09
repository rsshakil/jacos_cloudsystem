<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmnCategoryDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cmn_category_descriptions', function (Blueprint $table) {
            $table->integer('cmn_category_id')->unsigned()->comment('category Id');
            $table->integer('byr_buyer_id')->unsigned()->default(0)->comment('byr Id');
            $table->string('category_name',80)->comment('category Name');
            $table->string('category_code',6)->comment('category Code');
            $table->string('image',240)->nullable()->comment('Image');
            $table->boolean('is_deleted')->default(0)->comment('delete status');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time of creation');
			$table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('Time of Update');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cmn_category_descriptions');
    }
}
