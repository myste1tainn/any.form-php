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
			// e.g.
			$table->increments('id');

			// e.g.
			$table->integer('order');

			// e.g.
			$table->string('label')->nullable();

			// e.g.
			$table->string('name');

			// e.g.
			$table->string('nodeName')->nullable();

			// e.g.
			$table->string('description')->nullable();

			// e.g. abcd choices, quality choices (poor - best)
			$table->integer('type');

			// e.g.
			$table->integer('questionaireID')->unsigned();

			// e.g.
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));


			$table->foreign('questionaireID')
				  ->references('id')
				  ->on('questionaires')
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
		Schema::drop('questions');
	}

}
