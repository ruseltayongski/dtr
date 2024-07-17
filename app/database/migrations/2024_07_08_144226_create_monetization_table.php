<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonetizationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        if(Schema::hasTable('monetization')){
            return true;
        }
        Schema::create('monetization', function($table){
            $table->increments('id');
            $table->string('route_no');
            $table->string('userid');
            $table->decimal('vl', 10,2);
            $table->decimal('sl', 10,2);
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
        Schema::drop('monetization');
	}

}
