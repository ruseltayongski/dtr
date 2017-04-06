<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Calendar extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(Schema::hasTable('calendar')){
			return true;
		}
		Schema::create('calendar', function ($table) {
			$table->increments('id');
			$table->text('route_no');
			$table->text('title');
			$table->text('start');
			$table->text('end');
			$table->text('area');
			$table->text('backgroundColor');
			$table->text('borderColor');
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
		Schema::drop('calendar');
	}

}
