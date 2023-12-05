<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtoPrivilegeLogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        if(Schema::hasTable('cto_privilege_logs')){
            return true;
        }
        Schema::create('cto_privilege_logs', function($table){
           $table->increments('id');
           $table->integer('cdo_id');
           $table->string('route_no');
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
		//
        Schema::drop('cto_privilege_logs');
	}

}
