<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('criteria', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('label', 64);
			$table->integer('from');
			$table->integer('to');
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
		Schema::drop('criteria');
	}

}
