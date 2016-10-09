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

class ImportEqData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Model::unguard();
		$this->importExcelToTable('migrations/data/eq/1_questionaires.csv', 'App\Questionaire');
		$this->importExcelToTable('migrations/data/eq/2_criteria.csv', 'App\Criterion');
		$this->importExcelToTable('migrations/data/eq/3_questions.csv', 'App\Question');
		$this->importExcelToTable('migrations/data/eq/4_choices.csv', 'App\Choice');
		$this->importExcelToTable('migrations/data/eq/5_question_groups.csv', 'App\QuestionGroup');
		$this->importExcelToTable('migrations/data/eq/6_definitions.csv', 'App\Definition');
		DB::table('choices')->where('parentID', 0)->update(['parentID' => NULL]);
		DB::table('question_groups')->where('parentID', 0)->update(['parentID' => NULL]);
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
		$this->downFromExcelFile('migrations/data/eq/6_definitions.csv', 'App\Definition');
		$this->downFromExcelFile('migrations/data/eq/5_question_groups.csv', 'App\QuestionGroup');
		$this->downFromExcelFile('migrations/data/eq/4_choices.csv', 'App\Choice');
		$this->downFromExcelFile('migrations/data/eq/3_questions.csv', 'App\Question');
		$this->downFromExcelFile('migrations/data/eq/2_criteria.csv', 'App\Criterion');
		$this->downFromExcelFile('migrations/data/eq/1_questionaires.csv', 'App\Questionaire');
		Model::reguard();
	}

	private function downFromExcelFile($excelFile, $className) {
		Excel::load(database_path($excelFile), function($sheet) use ($className) {
			$sheet->each(function($row) use ($className) {
				$item = new $className();
				DB::table($item->getTable())->where('id', $row->id)->delete();
			});
		});
	}

}
