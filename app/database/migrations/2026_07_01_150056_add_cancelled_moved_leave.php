<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancelledMovedLeave extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modified_leave', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('extended_id');
			$table->date('from_start');
			$table->date('from_end');
			$table->date('to_start');
			$table->date('to_end');
			$table->integer('status');
			$table->text('modified_by');
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
		Schema::table('modified_leave', function(Blueprint $table)
		{
			//
		});
	}

}
