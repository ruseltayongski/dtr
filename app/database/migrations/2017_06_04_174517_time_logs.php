<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TimeLogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(Schema::hasTable('dtr_file')){
            return true;
        }
		Schema::create('dtr_file', function($table) {
			$table->string('userid',200)->nullable();
			$table->date('datein')->nullable();
			$table->time('time')->nullable();
			$table->string('event',200)->nullable();
			$table->string('remark',200)->nullable();
			$table->string('edited',10)->nullable();
			$table->string('holiday',30)->nullable();
			$table->string('type')->nullable();
			$table->string('desc',30)->nullable();
			$table->primary(array('userid','datein', 'time','event',));

			$table->index('userid');
			$table->index('datein');
			$table->index('time');
			$table->index('event');
			$table->index('holiday');


			/*//$table->unique('datein');
			$table->unique('time');
			$table->unique('event');*/
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
		Schema::drop('dtr_file');
	}

}
