<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeviceType extends Migration {

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
            $table->string('device_type')->after('message');
            $table->boolean('force_update')->after('message');
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
