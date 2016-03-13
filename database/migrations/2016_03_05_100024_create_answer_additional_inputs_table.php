<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerAdditionalInputsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('answer_additional_inputs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('value', 1024);
			$table->integer('inputID')->unsigned();
			$table->integer('answerID')->unsigned();
			$table->timestamps();

			$table->foreign('inputID')
				  ->references('id')
				  ->on('additional_inputs')
				  ->onDelete('cascade');
				  
			$table->foreign('answerID')
				  ->references('id')
				  ->on('participant_answers')
				  ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('answer_additional_inputs');
	}

}
