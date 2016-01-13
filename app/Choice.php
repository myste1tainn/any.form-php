<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model {

	public function question() {
		return $this->belongsTo('App\Question', 'questionID');
	}

	public static function createWith($question, $iChoices) {
		$choices = [];
		foreach ($iChoices as $iChoice) {
			$choices[] = static::_create($question, $iChoice);
		}

		return $choices;
	}

	public static function updateWith($question, $iChoices) {
		$choices = [];
		foreach ($iChoices as $iChoice) {
			$item = Choice::find($iChoice['id'])->get();

			if ($item) {
				$choice = static::_update($question, $iChoice);
			} else {
				$choice = static::_create($question, $iChoice);
			}

			$choices[] = $choice;
		}

		return $choices;
	}

	private static function _create($question, $iChoice) {
		$choice = new Choice();
		$choice->label = $iChoice['label'];
		$choice->name = $iChoice['name'];
		$choice->description = $iChoice['description'];
		$choice->note = $iChoice['note'];
		$choice->value = $iChoice['value'];
		$choice->questionID = $question->id;
		$choice->save();

		return $question;
	}

	private static function _update($question, $iChoice) {
		$choice = Choice::find($iChoice['id']);
		$choice->label = $iChoice['label'];
		$choice->name = $iChoice['name'];
		$choice->description = $iChoice['description'];
		$choice->note = $iChoice['note'];
		$choice->value = $iChoice['value'];
		$choice->questionID = $question->id;
		$choice->save();

		return $question;
	}

	public static function summationFromChoices($choices)
	{
		$sum = 0;
		foreach ($choices as $c) {
			$sum += intval($c['value']);
		}

		return $sum;
	}

}
