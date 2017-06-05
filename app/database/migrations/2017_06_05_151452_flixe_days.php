<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FlixeDays extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flixe_day', function($table) {

			$table->increments('id');
			$table->string('userid',50)->nullable();
			$table->string('day')->nullable();
			$table->string('description');
			$table->time('am_in');
			$table->time('am_out');
			$table->time('pm_in');
			$table->time('pm_out');
			$table->index('userid');
			$table->index('day');
			$table->index('am_in');
			$table->index('am_out');
			$table->index('pm_in');
			$table->index('pm_out');
			$table->rememberToken();
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
		Schema::drop('flixe_day');
	}

}
