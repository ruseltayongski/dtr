<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkSched extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(Schema::hasTable('work_sched')){
            return true;
        }
		Schema::create('work_sched', function($table) {
			$table->increments('id');
			$table->string('description');
			$table->time('am_in');
			$table->time('am_out');
			$table->time('pm_in');
			$table->time('pm_out');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('work_sched');
	}

}
