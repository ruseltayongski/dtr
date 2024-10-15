<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CdoTransfer extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        if(Schema::hasTable('cdo_transfer')){
            return true;
        }
        Schema::create( 'cdo_transfer', function(Blueprint $table){
            $table->increments('id');
            $table->string('userid');
            $table->integer('reason');
            $table->date('date');
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
	}

}
