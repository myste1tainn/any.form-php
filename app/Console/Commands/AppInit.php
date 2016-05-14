<?php namespace App\Console\Commands;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Questionaire;
use App\Question;
use App\QuestionMeta;
use App\QuestionaireResult;
use App\Criterion;
use App\Participant;
use App\ParticipantAnswer;
use App\AnswerAdditionalInput;
use App\AdditionalInput;
use App\Choice;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AppInit extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:init';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Initialize application';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		if ($this->confirm('This will recreate all forms and dropped all results/answers, continue?')) {
			DB::statement("SET foreign_key_checks=0");
			QuestionaireResult::truncate();
			AnswerAdditionalInput::truncate();
			ParticipantAnswer::truncate();
			Participant::truncate();
			AdditionalInput::truncate();
			Choice::truncate();
			Criterion::truncate();
			QuestionMeta::truncate();
			Question::truncate();
			Questionaire::truncate();
			DB::statement("SET foreign_key_checks=1");

			$path = database_path().'/seeds/db-structure.sql';
	        DB::unprepared(file_get_contents($path));
		}
	}

}
