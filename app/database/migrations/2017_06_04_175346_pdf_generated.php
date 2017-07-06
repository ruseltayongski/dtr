<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PdfGenerated extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('generated_pdf', function ($table) {
			$table->increments('id');
			$table->string('filename')->nullable();
			$table->date('date_from')->nullable();
			$table->date('date_to')->nullable();
			$table->date('date_created');
			$table->time('time_created');
			$table->string('type')->nullable();
			$table->string('generated',10)->nullable();
			$table->string('is_filtered',10)->nullable();
			$table->string('empid', 10)->nullable();
			$table->index('date_from');
			$table->index('date_to');
			$table->rememberToken();
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
		Schema::drop('generated_pdf');
	}

}
