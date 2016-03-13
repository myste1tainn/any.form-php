<?php namespace App;

use Cache;
use Illuminate\Database\Eloquent\Model;

class ParticipantAnswer extends Model {

	//
	public function inputs()
	{
		return $this->hasMany('App\AnswerAdditionalInput', 'answerID');
	}

	public static function createWith($questionaire, $participant, $ichoices)
	{
		$pas = [];
		foreach ($ichoices as $ichoice) {
			$pa = new ParticipantAnswer();
			$pa->participantID = $participant->id;
			$pa->questionaireID = $questionaire->id;
			$pa->questionID = $ichoice['questionID'];
			$pa->choiceID = $ichoice['id'];
			$pa->academicYear = Cache::get('settings.current_academic_year');
			$pa->save();

			if (array_key_exists('inputs', $ichoice)) {
				$pa->inputs = AnswerAdditionalInput::createWith($pa, $ichoice['inputs']);
			} else {
				$pa->inputs = [];
			}

			$pas[] = $pa;
		}

		return $pas;
	}

}
