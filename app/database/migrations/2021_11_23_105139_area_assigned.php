<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AreaAssigned extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(Schema::hasTable('area_assigned')){
            		return true;
        }
   		Schema::create('area_assigned', function($table) {
    		$table->increments('id');
			$table->string('userid',100);
			$table->integer('area_of_assignment_id');
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
		Schema::drop('area_assigned');
	}

}
