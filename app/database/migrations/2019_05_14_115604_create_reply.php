<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReply extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(Schema::hasTable('reply')){
            return true;
        }
        Schema::create('reply', function(Blueprint $table) {
            $table->increments('id');
            $table->text('userid');
            $table->integer('post_id');
            $table->integer('comment_id');
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
