<?php namespace App;

use App\AddtionalInput;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model {

	public function question() {
		return $this->belongsTo('App\Question', 'questionID');
	}

	public static function createWith($question, $iChoices, $parent = null) {
		$choices = [];
		foreach ($iChoices as $iChoice) {
			$choices[] = static::_create($question, $iChoice, $parent);
		}

		return $choices;
	}

	public static function updateWith($question, $iChoices, $parent = null) {
		$choices = [];
		foreach ($iChoices as $iChoice) {
			$item = Choice::find($iChoice['id']);

			if ($item) {
				$choice = static::_update($question, $iChoice, $parent);
			} else {
				$choice = static::_create($question, $iChoice, $parent);
			}

			$choices[] = $choice;
		}

		return $choices;
	}

	private static function _create($question, $iChoice, $parent = null) {
		$choice = new Choice();
		$choice->label = $iChoice['label'];
		$choice->name = $iChoice['name'];
		$choice->description = $iChoice['description'];
		$choice->note = $iChoice['note'];
		$choice->value = $iChoice['value'];
		$choice->enabled = $iChoice['enabled'];
		$choice->questionID = $question->id;

		if ($parent) {
			$choice->parentID = $parent->id;
		}

		$choice->save();

		if (isset($iChoice['subchoices']) && count($iChoice['subchoices']) > 0) {
			static::createWith($question, $iChoice['subchoices'], $choice);
		}

		if (isset($iChoice['inputs']) && count($iChoice['inputs']) > 0) {
			AddtionalInput::createWith($choice, $iChoice['inputs']);
		}

		return $question;
	}

	private static function _update($question, $iChoice, $parent = null) {
		$choice = Choice::find($iChoice['id']);
		$choice->label = $iChoice['label'];
		$choice->name = $iChoice['name'];
		$choice->description = $iChoice['description'];
		$choice->note = $iChoice['note'];
		$choice->value = $iChoice['value'];
		$choice->enabled = $iChoice['enabled'];
		$choice->questionID = $question->id;

		if ($parent) {
			$choice->parentID = $parent->id;
		}

		$choice->save();

		if (isset($iChoice['subchoices']) && count($iChoice['subchoices']) > 0) {
			static::updateWith($question, $iChoice['subchoices'], $choice);
		}

		if (isset($iChoice['inputs']) && count($iChoice['inputs']) > 0) {
			AddtionalInput::updateWith($choice, $iChoice['inputs']);
		}

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
