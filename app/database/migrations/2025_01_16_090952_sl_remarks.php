<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SlRemarks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(Schema::hasTable('sl_remarks')){
            return true;
        }
        Schema::create( 'sl_remarks', function(Blueprint $table){
            $table->increments('id');
            $table->string('leave_id');
            $table->dateTime('date');
            $table->text('remarks');
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
