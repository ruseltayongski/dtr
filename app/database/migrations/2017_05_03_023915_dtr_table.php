<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DtrTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dtr_table', function($table){
			$table->increments('id');
			$table->string('desc')->nullable();
			$table->date('date_from')->nullable();
			$table->date('date_to')->nullable();
			$table->string('name')->nullable();
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
		Schema::drop('dtr_table');
	}

}
