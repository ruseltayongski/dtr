<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cdo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(Schema::hasTable('cdo')){
			Schem::drop('cdo');
		}
		Schema::create('cdo', function(Blueprint $table) {
			$table->increments('id');
			$table->string('route_no','40');
			$table->text('subject');
			$table->string('doc_type','15');
			$table->string('name','25');
			$table->datetime('date');
			$table->string('working_days','5');
			$table->text('start');
			$table->text('end');
			$table->text('beginning_balance');
			$table->text('less_applied_for');
			$table->text('remaining_balance');
			$table->text('recommendation');
			$table->text('immediate_supervisor');
			$table->text('division_chief');
			$table->integer('approved_status');
			$table->integer('status');
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
		Schema::drop('cdo');
	}

}
