<?php

use App\Questionaire;
use App\QuestionaireResult;
use App\Participant;
use App\ParticipantAnswer;
use App\AnswerAdditionalInput;
use App\Choice;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

	}

}
