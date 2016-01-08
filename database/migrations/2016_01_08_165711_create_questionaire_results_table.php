<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionaireResultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questionaire_results', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('questionaireID')->unsigned();
			$table->integer('participantID')->unsigned();
			$table->integer('value');
			$table->timestamps();

			$table->foreign('questionaireID')->references('id')->on('questionaires');
			$table->foreign('participantID')->references('id')->on('participants');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('questionaire_results');
	}

}
