<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Employee extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function ($table) {
			$table->increments('id');
			$table->string('email')->nullable();
			$table->string('userid')->nullable();
			$table->string('fname')->nullable();
			$table->string('lname')->nullable();
			$table->string('mname')->nullable();
			$table->string('sched',10)->nullable();
			$table->string('username')->unique();
			$table->string('password')->nullable();
			$table->string('emptype')->nullable();
			$table->boolean('usertype')->default(0);
			$table->string('unique_row');
			$table->index('id');
			$table->index('userid');
			$table->index('fname');
			$table->index('lname');
			$table->index('mname');
			$table->index('emptype');
			$table->unique('unique_row');
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
		Schema::drop('users');
	}

}
