<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveAppliedDates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		if(Schema::hasTable('leave_applied_dates')){
            return true;
        }
        Schema::create( 'leave_applied_dates', function(Blueprint $table){
            $table->increments('id');
            $table->string('leave_id');
            $table->date('startdate');
            $table->date('enddate');
			$table->date('from_date');
            $table->date('to_date');
			$table->text('remarks');
			$table->string('status');
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
		Schema::drop('leave_applied_dates');
	}

}
