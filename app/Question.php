<?php namespace App;

use App\Definition;
use Illuminate\Database\Eloquent\Model;

class Question extends Model {
	public static $riskMap = [
		'47' => [ 
			'name' => 'ด้านการเรียน',
			'shortName' => 'การเรียน',
			'nodeName' => 'study'
		],
		'48' => [ 
			'name' => 'ด้านสุขภาพ',
			'shortName' => 'สุขภาพ',
			'nodeName' => 'health'
		],
		'49' => [ 
			'name' => 'ด้านความก้าวร้าวรุนแรง',
			'shortName' => 'ความก้าวร้าว',
			'nodeName' => 'aggressiveness'
		],
		'50' => [ 
			'name' => 'ด้านเศรษฐกิจ',
			'shortName' => 'ด้านเศรษฐกิจ',
			'nodeName' => 'economy'
		],
		'51' => [ 
			'name' => 'ด้านความปลอดภัย',
			'shortName' => 'ความปลอดภัย',
			'nodeName' => 'security'
		],
		'52' => [ 
			'name' => 'ด้านสารเสพติด',
			'shortName' => 'สารเสพติด',
			'nodeName' => 'drugs'
		],
		'53' => [ 
			'name' => 'ด้านพฤติกรรมทางเพศ',
			'shortName' => 'พฤติกรรมทางเพศ',
			'nodeName' => 'sexuality'
		],
		'54' => [ 
			'name' => 'ด้านการติดเกม',
			'shortName' => 'การติดเกม',
			'nodeName' => 'games'
		],
		'56' => [ 
			'name' => 'ด้านเครื่องมือสื่อสาร',
			'shortName' => 'เครื่องมือสื่อสาร',
			'nodeName' => 'electronics'
		],
	];

	public function info($nodeName) {
		return static::$riskMap[$this->id][$nodeName];
	}

	public function isAspect($def) {
									// To make this is string
		return strpos($def->values, (string)$this->id) !== false;
	}
	public function isAboutTalent() {
		return $this->id == env('APP_QUESTION_TALENT_ID');
	}
	public function isAboutDisability() {
		return $this->id == env('APP_QUESTION_DISABILITY_ID');
	}

	public function meta()
	{
		return $this->hasOne('App\QuestionMeta', 'questionID');
	}

	public function group() {
		$relation = $this->belongsTo('App\QuestionGroup', 'groupID', 'id');
		return $relation;
	}

	public function choices($mainChoicesOnly = false) {
		if ($mainChoicesOnly) {
			return $this->hasMany('App\Choice', 'questionID')->whereNull('parentID');
		} else {
			return $this->hasMany('App\Choice', 'questionID');
		}
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

	public function answer($participantID, $year = null) {
		$query = $this->hasOne('App\ParticipantAnswer', 'questionID');
		if (is_object($participantID)) {
			$participantID = $participantID->id;
		}
		if ($year) {
			$query->where('academicYear', $year);
		}
		return $query->where('participantID', $participantID);
	}

	public function answers($participantID = null, $year = null) {
		$query = $this->hasMany('App\ParticipantAnswer', 'questionID');
		if (is_object($participantID)) {
			$participantID = $participantID->id;
		}
		if ($year) {
			// Answers on the question specific to acacemicYear
			$query->where('academicYear', $year);
		}

		if ($participantID) {
			// Answers on the question specific to participants
			return $query->where('participantID', $participantID);	
		} else {
			// ALL Answers on the question 
			return $query;
		}
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
