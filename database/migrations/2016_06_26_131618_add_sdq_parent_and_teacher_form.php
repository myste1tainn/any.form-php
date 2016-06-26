<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSdqParentAndTeacherForm extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$path = database_path().'/seeds/sdq-copy-questionaires.sql';
	    DB::unprepared(file_get_contents($path));

	    $path = database_path().'/seeds/sdq-copy-question-groups.sql';
	    DB::unprepared(file_get_contents($path));

	    $path = database_path().'/seeds/sdq-copy-questions.sql';
	    DB::unprepared(file_get_contents($path));

	    $path = database_path().'/seeds/sdq-copy-choices.sql';
	    DB::unprepared(file_get_contents($path));

	    $path = database_path().'/seeds/sdq-copy-criteria.sql';
	    DB::unprepared(file_get_contents($path));

	    $path = database_path().'/seeds/sdq-copy-additional-inputs.sql';
	    DB::unprepared(file_get_contents($path));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
	}

}
