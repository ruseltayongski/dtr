<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddtnlLeave extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		if(Schema::hasTable('addtnl_leave')){
            return true;
        }
        Schema::create( 'addtnl_leave', function(Blueprint $table){
            $table->increments('id');
            $table->string('userid');
            $table->string('period');
            $table->integer('FL');
			$table->integer('SPL');
            $table->softDeletes();
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
		Schema::drop('addtnl_leave');
	}

}
