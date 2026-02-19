<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWellness extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('addtnl_leave', function(Blueprint $table)
		{
			//
			$table->integer('wellness')->after('SPL');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('addtnl_leave', function(Blueprint $table)
		{
			//
		});
	}

}
