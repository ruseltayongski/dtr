<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuperviseEmployee extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('supervise_employee', function($table)
        {
            $table->increments('id');
            $table->text('supervisor_id');
            $table->text('userid');
            $table->string('status');
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
        Schema::drop('supervise_employee');
	}

}
