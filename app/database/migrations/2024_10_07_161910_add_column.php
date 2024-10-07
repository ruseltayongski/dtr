<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumn extends Migration {

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
            $table->integer('force_update_btn')->after('force_update');
            $table->text('force_update_title')->after('force_update');
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
