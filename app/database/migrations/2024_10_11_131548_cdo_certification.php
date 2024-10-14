<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CdoCertification extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        if(Schema::hasTable('cdo_certification')){
            return true;
        }
        Schema::create( 'cdo_certification', function(Blueprint $table){
            $table->increments('id');
            $table->text('card_id');
            $table->text('remarks')->nullable();
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
