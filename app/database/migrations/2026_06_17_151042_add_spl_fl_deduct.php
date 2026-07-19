<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSplFlDeduct extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('leave', function(Blueprint $table)
		{
			//
			$table->integer('fl_deduct')->after('sl_deduct');
			$table->integer('spl_deduct')->after('sl_deduct');
			$table->integer('wl_deduct')->after('sl_deduct');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('leave', function(Blueprint $table)
		{
			//
		});
	}

}
