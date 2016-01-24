<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {

	public function meta()
	{
		return $this->hasOne('App\QuestionMeta', 'questionID');
	}

	public function choices() {
		return $this->hasMany('App\Choice', 'questionID');
	}

	public static function createWith($questionaire, $iQuestions) {
		$questions = [];
		foreach ($iQuestions as $iQuestion) {
			$questions[] =  static::_create($questionaire, $iQuestion);
		}

		return $questions;
	}

	public static function updateWith($questionaire, $iQuestions) {
		$questions = [];
		foreach ($iQuestions as $iQuestion) {
			$item = Question::find($iQuestion['id']);

			if ($item) {
				$question = static::_update($questionaire, $iQuestion);
			} else {
				$question = static::_create($questionaire, $iQuestion);
			}

			$questions[] =  $question;
		}

		return $questions;
	}

	private static function _create($questionaire, $iQuestion) {
		$question = new Question();
		$question->order = $iQuestion['order'];
		$question->label = $iQuestion['label'];
		$question->name = $iQuestion['name'];
		$question->description = $iQuestion['description'];
		$question->type = $iQuestion['type'];
		$question->questionaireID = $questionaire->id;
		$question->save();

		$question->meta = QuestionMeta::createWith($question, $iQuestion['meta']);
		$question->choices = Choice::createWith($question, $iQuestion['choices']);

		return $question;
	}

	private static function _update($questionaire, $iQuestion) {
		$question = Question::find($iQuestion['id']);
		$question->order = $iQuestion['order'];
		$question->label = $iQuestion['label'];
		$question->name = $iQuestion['name'];
		$question->description = $iQuestion['description'];
		$question->type = $iQuestion['type'];
		$question->questionaireID = $questionaire->id;
		$question->save();

		if (array_key_exists('meta', $iQuestion)) {
			$question->meta = QuestionMeta::updateWith($question, $iQuestion['meta']);
		}

		$question->choices = Choice::updateWith($question, $iQuestion['choices']);

		return $question;
	}

}
