<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerAdditionalInput extends Model {

	public function input()
	{
		return $this->belongsTo('App\AdditionalInput', 'inputID');
	}

	public function answer()
	{
		return $this->belongsTo('App\ParticipantAnswer', 'answerID');
	}

	public static function createWith(ParticipantAnswer $answer, $iAnsInputs)
	{
		$ansInputs = [];
		foreach ($iAnsInputs as $iAnsInput) {
			if (array_key_exists('value', $iAnsInput)) {
				$ansInput = new AnswerAdditionalInput();
				$ansInput->value = $iAnsInput['value'];
				$ansInput->inputID = $iAnsInput['id'];
				$ansInput->answerID = $answer->id;
				$ansInput->save();

				$ansInputs[] = $ansInput;
			}
		}

		return $ansInputs;
	}

}
