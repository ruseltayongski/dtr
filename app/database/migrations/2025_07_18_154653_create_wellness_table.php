<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWellnessTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wellness', function (Blueprint $table) {
			$table->increments('id');
			$table->string('userid');
			$table->string('unique_code')->nullable()->unique();
			$table->date('scheduled_date');
			$table->string('type_of_request');
			$table->enum('status', ['approved', 'pending', 'declined'])->default('pending');
			$table->unsignedBigInteger('approved_by')->nullable();
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
		Schema::dropIfExists('wellness');
	}

}
