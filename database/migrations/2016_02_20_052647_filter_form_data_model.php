<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FilterFormDataModel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('questionaires', function (Blueprint $table) {
			$table->tinyInteger('level')->default(0)->after('header');
		});

		Schema::table('choices', function (Blueprint $table) {
			$table->integer('parentID')->unsigned()->nullable()->after('questionID');
			$table->integer('type')->default(0)->after('value');
		});

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
		Schema::table('questionaires', function (Blueprint $table) {
			$table->dropColumn('level');
		});

		Schema::table('choices', function (Blueprint $table) {
			$table->dropColumn('parentID');
			$table->dropColumn('type');
		});

		Schema::drop('additional_inputs');
	}

}
