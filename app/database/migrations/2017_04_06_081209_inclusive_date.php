<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InclusiveDate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(Schema::hasTable('inclusive_name')){
			return true;
		}
		Schema::create('inclusive_name', function ($table) {
			$table->increments('id');
			$table->text('route_no');
			$table->text('user_id');
			$table->text('status');
			$table->rememberToken();
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
		Schema::drop('inclusive_name');
	}

}
