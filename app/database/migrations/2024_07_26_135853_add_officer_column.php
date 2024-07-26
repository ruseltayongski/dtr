<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOfficerColumn extends Migration {

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
            $table->string('officer_1')->after('SPL_total');
            $table->string('officer_2')->after('SPL_total');
            $table->string('officer_3')->after('SPL_total');
            $table->double('vl_deduct', 10, 3)->after('SPL_total');
            $table->double('sl_deduct', 10, 3)->after('SPL_total');
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
