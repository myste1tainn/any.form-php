<?php

use App\Questionaire;
use App\Question;
use App\QuestionMeta;
use App\QuestionGroup;
use App\Choice;
use App\AdditionalInput;
use App\Criteria;

use Illuminate\Database\Eloquent\Model;
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
		Model::unguard();
		$this->importExcelToTable('migrations/data/1_questionaires.csv', 'App\Questionaire');
		$this->importExcelToTable('migrations/data/2_criteria.csv', 'App\Criterion');
		$this->importExcelToTable('migrations/data/3_questions.csv', 'App\Question');
		$this->importExcelToTable('migrations/data/4_choices.csv', 'App\Choice');
		$this->importExcelToTable('migrations/data/5_question_metas.csv', 'App\QuestionMeta');
		$this->importExcelToTable('migrations/data/6_question_groups.csv', 'App\QuestionGroup');
		$this->importExcelToTable('migrations/data/7_additional_inputs.csv', 'App\AdditionalInput');
		$this->importExcelToTable('migrations/data/8_definitions.csv', 'App\Definition');
		DB::table('choices')->where('parentID', 0)->update(['parentID' => NULL]);
		Model::reguard();
	}

	private function importExcelToTable($excelFile, $className) {
		echo $excelFile.PHP_EOL.$className.PHP_EOL.(new $className())->getTable().PHP_EOL;
		Excel::load(database_path($excelFile), function($sheet) use ($className) {
			$sheet->each(function($row) use ($className) {
				$item = new $className();
				foreach ($row as $key => $value) {
					echo $className.' set:'.$key.',value:'.$value.PHP_EOL;
					$item[$key] = $value;
				}
				echo $className.' save'.$value.PHP_EOL;
				$item->save();
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
		Model::unguard();
		$this->downFromExcelFile('migrations/data/8_definitions.csv', 'App\Definition');
		$this->downFromExcelFile('migrations/data/7_additional_inputs.csv', 'App\AdditionalInput');
		$this->downFromExcelFile('migrations/data/6_question_groups.csv', 'App\QuestionGroup');
		$this->downFromExcelFile('migrations/data/5_question_metas.csv', 'App\QuestionMeta');
		$this->downFromExcelFile('migrations/data/4_choices.csv', 'App\Choice');
		$this->downFromExcelFile('migrations/data/3_questions.csv', 'App\Question');
		$this->downFromExcelFile('migrations/data/2_criteria.csv', 'App\Criteria');
		$this->downFromExcelFile('migrations/data/1_questionaires.csv', 'App\Questionaire');
		Model::reguard();
	}

	private function downFromExcelFile($excelFile, $className) {
		Excel::load(database_path($excelFile), function($sheet) use ($className) {
			$sheet->each(function($row) use ($className) {
				$item = new $className();
				DB::table($item->getTable())->destroy($row->id);
			});
		});
	}

}
