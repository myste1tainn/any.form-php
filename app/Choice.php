<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model {

	public function question() {
		return $this->belongsTo('App\Question', 'questionID');
	}

	public function inputs() {
		return $this->hasMany('App\AdditionalInput', 'choiceID');
	}

	public function subchoices() {
		return $this->hasMany('App\Choice', 'parentID');
	}

	public function parent() {
		return $this->belongsTo('App\Choice', 'parentID');
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
		$choice->type = $iChoice['type'];
		$choice->enabled = $iChoice['enabled'];
		$choice->questionID = $question->id;

		if ($parent) {
			$choice->parentID = $parent->id;
		}

		$choice->save();

		if (isset($iChoice['subchoices']) && count($iChoice['subchoices']) > 0) {
			$choice->subchoices = static::createWith($question, $iChoice['subchoices'], $choice);
		}

		if (isset($iChoice['inputs']) && count($iChoice['inputs']) > 0) {
			$choice->inputs = AdditionalInput::createWith($choice, $iChoice['inputs']);
		}

		return $choice;
	}

	private static function _update($question, $iChoice, $parent = null) {
		$choice = Choice::find($iChoice['id']);
		$choice->label = $iChoice['label'];
		$choice->name = $iChoice['name'];
		$choice->description = $iChoice['description'];
		$choice->note = $iChoice['note'];
		$choice->value = $iChoice['value'];
		$choice->type = $iChoice['type'];
		$choice->enabled = $iChoice['enabled'];
		$choice->questionID = $question->id;

		if ($parent) {
			$choice->parentID = $parent->id;
		}

		$choice->save();

		if (isset($iChoice['subchoices']) && count($iChoice['subchoices']) > 0) {
			$choice->subchoices = static::updateWith($question, $iChoice['subchoices'], $choice);
		}

		if (isset($iChoice['inputs']) && count($iChoice['inputs']) > 0) {
			$choice->inputs = AdditionalInput::updateWith($choice, $iChoice['inputs']);
		}

		return $choice;
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
