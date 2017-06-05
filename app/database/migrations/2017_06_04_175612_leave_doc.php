<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeaveDoc extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('leave', function($table){
			$table->increments('id');
			$table->string('route_no');
			$table->string('userid');
			$table->string('office_agency')->nullable();
			$table->string('lastname')->nullable();
			$table->string('firstname')->nullable();
			$table->string('middlename')->nullable();
			$table->date('date_filling')->nullable();
			$table->string('position')->nullable();
			$table->double('salary')->nullable();
			$table->string('leave_type')->nullable();
			$table->string('leave_type_others_1')->nullable();
			$table->string('leave_type_others_2')->nullable();
			$table->string('vication_loc')->nullable();
			$table->string('abroad_others')->nullable();
			$table->string('sick_loc')->nullable();
			$table->string('in_hospital_specify')->nullable();
			$table->string('out_patient_specify')->nullable();
			$table->string('applied_num_days')->nullable();
			$table->date('inc_from')->nullable();
			$table->date('inc_to')->nullable();
			$table->string('com_requested')->nullable();
			$table->date('credit_date')->nullable();
			$table->string('vication_total')->nullable();
			$table->string('sick_total')->nullable();
			$table->string('over_total')->nullable();
			$table->string('a_days_w_pay')->nullable();
			$table->string('a_days_wo_pay')->nullable();
			$table->string('a_others')->nullable();
			$table->string('reco_approval')->nullable();
			$table->text('reco_disaprove_due_to')->nullable();
			$table->text('disaprove_due_to')->nullable();
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
		Schema::drop('leave');
	}

}
