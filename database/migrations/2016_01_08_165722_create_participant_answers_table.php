<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participant_answers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('participantID')->unsigned();
			$table->integer('questionaireID')->unsigned();
			$table->integer('questionID')->unsigned();
			$table->integer('choiceID')->unsigned();
			$table->timestamps();

			$table->foreign('participantID')->references('id')->on('participants');
			$table->foreign('questionaireID')->references('id')->on('questionaires');
			$table->foreign('questionID')->references('id')->on('questions');
			$table->foreign('choiceID')->references('id')->on('choices');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('participant_answers');
	}

}
