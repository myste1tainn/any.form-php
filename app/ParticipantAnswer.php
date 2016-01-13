<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipantAnswer extends Model {

	//

	public static function createWith($questionaire, $participant, $ichoices)
	{
		$pas = [];
		foreach ($ichoices as $ichoice) {
			$pa = new ParticipantAnswer();
			$pa->participantID = $participant->id;
			$pa->questionaireID = $questionaire->id;
			$pa->questionID = $ichoice['questionID'];
			$pa->choiceID = $ichoice['id'];
			$pa->save();

			$pas[] = $pa;
		}

		return $pas;
	}

}
