<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusExtendedLeave extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('leave_extension', function(Blueprint $table)
		{
			//
			$table->integer('status')->nullable()->after('type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('leave_extension', function(Blueprint $table)
		{
			//
		});
	}

}
