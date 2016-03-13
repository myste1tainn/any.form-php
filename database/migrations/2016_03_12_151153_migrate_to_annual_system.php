<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateToAnnualSystem extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Migrate all database instance to annual system
		// Collect data base on academic year
		// e.g. Student's evaluation form are editing by specifying
		//		1. Student's ID
		//		2. Questionaire ID
		//		3. Academic year
		//
		// Reports of each students are available annually, 
		// comparable to each other academic year

		// Academic year can be get & set via
		// Config::get('settings.current_academic_year');
		// &
		// Config::set('settings.current_academic_year', 2559);

		Schema::table('questionaire_results', function (Blueprint $table) {
			$table->integer('academicYear')->after('updated_at');
		});
		Schema::table('participant_answers', function (Blueprint $table) {
			$table->integer('academicYear')->after('updated_at');
		});

		// Initially set the academic year to this year
		Cache::forever('settings.current_academic_year', 2559);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('questionaire_results', function (Blueprint $table) {
			$table->dropColumn('academicYear');
		});
	}

}
