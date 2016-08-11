<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('questionaireID')->unsigned();
			$table->timestamps();
		});

		Schema::table('criteria', function (Blueprint $table) {
			$table->integer('questionaireID')->unsigned()->nullable()->change();
			$table->integer('groupID')->unsigned()->nullable()->after('questionaireID');
		});

		Schema::table('questions', function (Blueprint $table) {
			$table->integer('groupID')->unsigned()->nullable()->after('questionaireID');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('criteria', function (Blueprint $table) {
			$table->integer('questionaireID')->unsigned()->change();
			$table->dropColumn('groupID');
		});

		Schema::table('questions', function (Blueprint $table) {
			$table->dropColumn('groupID');
		});
		
		Schema::drop('question_groups');
	}

}
