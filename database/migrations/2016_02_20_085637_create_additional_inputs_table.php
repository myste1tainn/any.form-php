<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalInputsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('additional_inputs', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 64);
			$table->string('placeholder', 128);
			$table->string('type', 16);
			$table->integer('choiceID')->unsigned();
			$table->timestamps();

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
		Schema::drop('additional_inputs');
	}

}
