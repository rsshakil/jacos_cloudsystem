<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmnCategoryPathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cmn_category_paths', function (Blueprint $table) {
            $table->integer('cmn_category_id')->unsigned()->comment('category Id');
            $table->integer('path_id')->unsigned()->comment('Path Id');
            $table->integer('lavel')->comment('lavel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cmn_category_paths');
    }
}
