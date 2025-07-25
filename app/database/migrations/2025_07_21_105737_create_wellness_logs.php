<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWellnessLogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wellness_logs', function (Blueprint $table) {
			$table->increments('id');
            $table->integer('wellness_id');
			$table->dateTime('time_start'); 
			$table->dateTime('time_end'); 
			$table->integer('time_consumed'); 
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
		Schema::dropIfExists('wellness_logs');
	}

}
