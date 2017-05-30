<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JoDtr extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jo_dtr', function($table) {
			$table->increments('dtr_id');
			$table->string('userid',200)->nullable();
			$table->date('datein')->nullable();
			$table->time('time')->nullable();
			$table->string('event',200)->nullable();
			$table->string('remark',200)->nullable();
			$table->string('edited',10)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('dtr_file');
	}

}
