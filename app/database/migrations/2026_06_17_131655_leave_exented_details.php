<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeaveExentedDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('leave_extended_details', function (Blueprint $table) {
			$table->increments('id');
			$table->string('userid');
			$table->string('route_no');
			$table->string('details');
			$table->string('identifier');
			$table->string('remarks');
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
		Schema::dropIfExists('leave_extended_details');
	}

}
