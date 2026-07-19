<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeaveExtension extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('leave_extension', function (Blueprint $table) {
			$table->increments('id');
			$table->string('userid');
			$table->string('route_no');
			$table->string('leave_type');
			$table->string('type');
			$table->date('start');
			$table->date('end');
			$table->integer('days');
			$table->text('details');
			$table->integer('credit_used');
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
		//
		Schema::dropIfExists('leave_extension');
	}

}
