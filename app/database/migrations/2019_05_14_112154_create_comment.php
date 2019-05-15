<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(Schema::hasTable('comment')){
            return true;
        }
        Schema::create('comment', function(Blueprint $table) {
            $table->increments('id');
            $table->text('userid');
            $table->integer('post_id');
            $table->text('description');
            $table->date('datein');
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
		//
	}

}
