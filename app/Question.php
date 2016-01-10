<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {

	public function choices() {
		return $this->hasMany('App\Choice', 'questionID');
	}

	public static function createWith($questionaire, $iQuestions) {
		$questions = [];
		foreach ($iQuestions as $iQuestion) {
			$question = new Question();
			$question->order = $iQuestion['order'];
			$question->label = $iQuestion['label'];
			$question->name = $iQuestion['name'];
			$question->description = $iQuestion['description'];
			$question->type = $iQuestion['type'];
			$question->questionaireID = $questionaire->id;
			$question->save();

			$question->choices = Choice::createWith($question, $iQuestion['choices']);

			$questions[] =  $question;
		}

		return $questions;
	}

}
