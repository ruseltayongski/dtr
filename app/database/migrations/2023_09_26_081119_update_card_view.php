<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCardView extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        if(Schema::hasTable('card_view')){
            return true;
        }
        Schema::create('card_view', function($table) {
            $table->increments('id');
            $table->string('userid');
            $table->text('ot_hours');
            $table->text('ot_rate');
            $table->text('ot_credits');
            $table->date('ot_date');
            $table->decimal('hours_used');
            $table->string('date_used');
            $table->text('bal_credits');
            $table->string('status');
            $table->string('remarks');
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
        Schema::drop('card_view');
	}

}
