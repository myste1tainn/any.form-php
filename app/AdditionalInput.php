<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionalInput extends Model {

	public function choice() {
		return $this->belongsTo('App\Choice', 'choiceID');
	}

	public static function createWith($choice, $iInputs) {
		$inputs = [];
		foreach ($iInputs as $iInput) {
			$inputs[] = static::_create($choice, $iInput);
		}

		return $inputs;
	}

	public static function updateWith($choice, $iInputs) {
		$inputs = [];
		foreach ($iInputs as $iInput) {
			$item = Choice::find($iInput['id']);

			if ($item) {
				$input = static::_update($choice, $iInput);
			} else {
				$input = static::_create($choice, $iInput);
			}

			$inputs[] = $input;
		}

		return $inputs;
	}

	private static function _create($choice, $iInput) {
		$input = new AdditionalInput();
		$input->name = $iInput['name'];
		$input->placeholder = $iInput['placeholder'];
		$input->type = $iInput['type'];
		$input->choiceID = $choice->id;
		$input->save();

		return $input;
	}

	private static function _update($choice, $iInput) {
		$input = AdditionalInput::find($iInput['id']);
		$input->name = $iInput['name'];
		$input->placeholder = $iInput['placeholder'];
		$input->type = $iInput['type'];
		$input->choiceID = $choice->id;
		$input->save();

		return $input;
	}

}
