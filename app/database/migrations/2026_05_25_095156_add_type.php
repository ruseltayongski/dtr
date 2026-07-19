<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddType extends Migration {

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
			$table->text('others_type')->nullable()->after('as_of');
			$table->text('app_type')->nullable()->after('as_of');
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
