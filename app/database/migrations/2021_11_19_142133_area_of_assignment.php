<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AreaOfAssignment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(Schema::hasTable('area_of_assignment')){
            		return true;
        	}
       		Schema::create('area_of_assignment', function($table) {
        		$table->increments('id');
			$table->string('name',255);
			$table->string('latitude',255);
			$table->string('longitude',255);
			$table->integer('radius');
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
		Schema::drop('area_of_assignment');
	}

}
