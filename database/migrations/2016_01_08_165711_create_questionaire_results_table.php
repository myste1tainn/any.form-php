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
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

			$table->foreign('questionaireID')
				  ->references('id')
				  ->on('questionaires')
				  ->onDelete('cascade');
			$table->foreign('participantID')
				  ->references('id')
				  ->on('participants')
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
		Schema::drop('questionaire_results');
	}

}
