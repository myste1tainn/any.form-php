<?php

use App\Questionaire;
use App\Question;
use App\QuestionMeta;
use App\QuestionGroup;
use App\Choice;
use App\AdditionalInput;
use App\Criteria;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImportSdqData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Excel::load(database_path('migrations/data/1_questionaires.csv'), function($sheet) {
			$sheet->each(function($row) {
				// TODO: migrate questionaires data;
			});
		});
		Excel::load(database_path('migrations/data/2_criteria.csv'), function($sheet) {
			$sheet->each(function($row) {
				// TODO: migrate questionaires data;
			});
		});
		Excel::load(database_path('migrations/data/3_questions.csv'), function($sheet) {
			$sheet->each(function($row) {
				// TODO: migrate questionaires data;
			});
		});
		Excel::load(database_path('migrations/data/4_choices.csv'), function($sheet) {
			$sheet->each(function($row) {
				// TODO: migrate questionaires data;
			});
		});
		Excel::load(database_path('migrations/data/5_question_metas.csv'), function($sheet) {
			$sheet->each(function($row) {
				// TODO: migrate questionaires data;
			});
		});
		Excel::load(database_path('migrations/data/6_question_groups.csv'), function($sheet) {
			$sheet->each(function($row) {
				// TODO: migrate questionaires data;
			});
		});
		Excel::load(database_path('migrations/data/7_additional_inputs.csv'), function($sheet) {
			$sheet->each(function($row) {
				// TODO: migrate questionaires data;
			});
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
