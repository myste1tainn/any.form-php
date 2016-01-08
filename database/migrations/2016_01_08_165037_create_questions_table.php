<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order');
			$table->string('label')->nullable();
			$table->string('name');
			$table->string('description')->nullable();
			$table->integer('questionaireID')->unsigned();
			$table->timestamps();

			$table->foreign('questionaireID')->references('id')->on('questionaires');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('questions');
	}

}
