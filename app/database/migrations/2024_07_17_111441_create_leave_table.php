<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        if(Schema::hasTable('leave')){
            return true;
        }
        Schema::create( 'leave', function(Blueprint $table){
            $table->increments('id');
            $table->string('route_no');
            $table->string('userid');
            $table->string('office_agency')->nullable();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->date('date_filling');
            $table->string('position')->nullable();
            $table->decimal('salary', 15,2)->nullable();
            $table->string('leave_type')->nullable();
            $table->string('leave_details');
            $table->string('for_others');
            $table->text('leave_specify')->nullable();
            $table->decimal('applied_num_days', 8,2)->nullable();
            $table->string('credit_used');
            $table->string('status');
            $table->string('remarks');
            $table->date('inc_from')->nullable();
            $table->date('inc_to')->nullable();
            $table->integer('commutation');
            $table->integer('approved_for');
            $table->double('vacation_total', 8,3);
            $table->double('sick_total', 8,3);
            $table->integer('FL_total');
            $table->integer('SPL_total');
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
        Schema::drop('leave');
	}

}
