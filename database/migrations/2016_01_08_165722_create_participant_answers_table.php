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
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

			$table->foreign('participantID')
				  ->references('id')
				  ->on('participants')
				  ->onDelete('cascade');
			$table->foreign('questionaireID')
				  ->references('id')
				  ->on('questionaires')
				  ->onDelete('cascade');
			$table->foreign('questionID')
				  ->references('id')
				  ->on('questions')
				  ->onDelete('cascade');
			$table->foreign('choiceID')
				  ->references('id')
				  ->on('choices')
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
		Schema::drop('participant_answers');
	}

}
