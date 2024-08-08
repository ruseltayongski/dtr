<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatus extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('leave_cardview', function(Blueprint $table)
		{
			//
            $table->integer('status')->nullable()->after('date_used');
            $table->integer('remarks')->nullable()->after('date_used');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('leave_cardview', function(Blueprint $table)
		{
			//
		});
	}

}
