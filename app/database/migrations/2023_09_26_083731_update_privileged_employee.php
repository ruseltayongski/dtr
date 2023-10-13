<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePrivilegedEmployee extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        if(Schema::hasTable('privileged_employee')){
            return true;
        }
        Schema::create('privileged_employee', function($table) {
            $table->increments('id');
            $table->text('supervisor_id');
            $table->text('userid');
            $table->string('status');
            $table->string('remember_token');
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
