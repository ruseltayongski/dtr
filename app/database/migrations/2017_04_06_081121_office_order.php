<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OfficeOrder extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(Schema::hasTable('office_order')){
			return true;
		}
		Schema::create('office_order', function ($table) {
			$table->increments('id');
			$table->text('route_no');
			$table->text('so_no');
			$table->text('subject');
			$table->text('header_body');
			$table->text('footer_body');
			$table->text('approved_by');
			$table->text('prepared_by');
			$table->text('prepared_date');
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
		Schema::drop('office_order');
	}

}
