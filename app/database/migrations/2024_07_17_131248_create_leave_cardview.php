<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveCardview extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		if(Schema::hasTable('leave_cardview')){
            return true;
        }
        Schema::create( 'leave_cardview', function(Blueprint $table){
            $table->increments('id');
            $table->string('userid');
            $table->string('leave_id')->nullable();
            $table->text('period')->nullable();
            $table->text('particulars')->nullable();
            $table->decimal('vl_earned', 10,3)->nullable();
			$table->decimal('vl_abswp', 10,3)->nullable();
            $table->decimal('vl_bal', 10,3)->nullable();
            $table->decimal('vl_abswop', 10,3)->nullable();
			$table->decimal('sl_earned', 10,3)->nullable();
			$table->decimal('sl_abswp', 10,3)->nullable();
            $table->decimal('sl_bal', 10,3)->nullable();
            $table->decimal('sl_abswop', 10,3)->nullable();
            $table->text('date_used')->nullable();
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
		Schema::drop('leave_cardview');
	}

}
