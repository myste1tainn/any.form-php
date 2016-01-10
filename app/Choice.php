<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model {

	public function question() {
		return $this->belongsTo('App\Question', 'questionID');
	}

	public static function createWith($question, $iChoices) {
		$choices = [];
		foreach ($iChoices as $iChoice) {
			$choice = new Choice();
			$choice->label = $iChoice['label'];
			$choice->name = $iChoice['name'];
			$choice->description = $iChoice['description'];
			$choice->note = $iChoice['note'];
			$choice->value = $iChoice['value'];
			$choice->questionID = $question->id;
			$choice->save();

			$choices[] = $choice;
		}

		return $choices;
	}

}
