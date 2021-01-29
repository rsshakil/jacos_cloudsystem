<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmnScenarioHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cmn_scenario_histories', function (Blueprint $table) {
            $table->increments('cmn_scenario_history_id')->unsigned()->comment('cmn_scenario_history_id');
            $table->integer('cmn_scenario_id')->unsigned()->comment('cmn_scenario_id');
            $table->integer('adm_user_id')->unsigned()->nullable()->comment('adm_user_id');
            $table->integer('byr_order_id')->unsigned()->nullable()->comment('byr_order_id');
            $table->integer('cmn_job_id')->unsigned()->nullable()->comment('cmn_job_id');
            $table->enum('status',['success','error'])->default('success')->nullable()->comment('status');
            $table->string('information',200)->comment('information');
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
        Schema::dropIfExists('cmn_scenario_histories');
    }
}
