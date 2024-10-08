<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewColumnAppApi extends Migration {

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
            $table->boolean('announcement_status')->after('device_type');
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
