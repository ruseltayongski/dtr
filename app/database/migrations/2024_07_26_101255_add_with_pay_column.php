<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWithPayColumn extends Migration {

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
            $table->string('with_pay')->after('approved_for');
            $table->string('without_pay')->after('with_pay');
            $table->date('as_of')->after('SPL_total');

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
