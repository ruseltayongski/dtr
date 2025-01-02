<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIncrementalUpdate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('app_version_api', function(Blueprint $table)
		{
			//
			$table->integer('incremental_updates')->after('announcement_status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('app_version_api', function(Blueprint $table)
		{
			//
		});
	}

}
