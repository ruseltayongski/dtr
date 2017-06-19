<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TimeLogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dtr_file', function($table) {
			$table->increments('dtr_id');
			$table->string('userid',200)->nullable();
			$table->date('datein')->nullable();
			$table->time('time')->nullable();
			$table->string('event',200)->nullable();
			$table->string('remark',200)->nullable();
			$table->string('edited',10)->nullable();
			$table->string('holiday',30)->nullable();
			$table->string('so_id',30)->nullable();
			$table->index('so_id',30);
			$table->index('dtr_id');
			$table->index('userid');
			$table->index('datein');
			$table->index('time');
			$table->index('event');
			$table->index('edited');
			$table->index('holiday');
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
