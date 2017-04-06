<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DtrFile extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dtr_file', function($table) {
			$table->increments('dtr_id');
			$table->string('userid',200)->nullable();
			$table->string('firstname', 200)->nullable();
			$table->string('lastname', 200)->nullable();
			$table->string('department',200)->nullable();
			$table->date('datein')->nullable();
			$table->integer('date_y')->nullable();
			$table->integer('date_m')->nullable();
			$table->integer('date_d')->nullable();
			$table->time('time')->nullable();
			$table->timestamp('timerecord')->nullable();
			$table->integer('time_h')->nullable();
			$table->integer('time_m')->nullable();
			$table->integer('time_s')->nullable();
			$table->string('event',200)->nullable();
			$table->string('terminal',200)->nullable();
			$table->string('remark',200)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('dtr_file');
	}

}
