<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCdoAppliedDates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        if(Schema::hasTable('cdo_applied_dates')){
            return true;
        }
        Schema::create('cdo_applied_dates', function($table) {
            $table->increments('id');
            $table->integer('cdo_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('cdo_hours');
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
        Schema::drop('cdo_applied_dates');
	}

}




