<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeavePriviledgeLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('leave_priviledge_logs', function (Blueprint $table) {
			$table->increments('id');
			$table->text('userid');
			$table->text('route_no');
			$table->date('added_on');
			$table->text('added_by');
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
	}

}
