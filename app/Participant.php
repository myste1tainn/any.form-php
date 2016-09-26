<?php namespace App;

use Request;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model {

	public static $PAGED_FROM = 0;
	public static $PAGED_NUM = 20;

	public static function newMappedAnswer() {
		return [
			'study' 			=> ['high' => [], 'veryHigh' => [],'level' => []],
			'health' 			=> ['high' => [], 'veryHigh' => [],'level' => []],
			'aggressiveness' 	=> ['high' => [], 'veryHigh' => [],'level' => []],
			'economy' 			=> ['high' => [], 'veryHigh' => [],'level' => []],
			'security' 			=> ['high' => [], 'veryHigh' => [],'level' => []],
			'drugs' 			=> ['high' => [], 'veryHigh' => [],'level' => []],
			'sexuality' 		=> ['high' => [], 'veryHigh' => [],'level' => []],
			'games' 			=> ['high' => [], 'veryHigh' => [],'level' => []],
			'electronics' 		=> ['high' => [], 'veryHigh' => [],'level' => []],
			'countHighRisk'		=> 0,
			'countVeryHighRisk' => 0,
		];
	}
	
	//
	public function results() {
		return $this->hasMany('App\QuestionaireResult', 'participantID');
	}

	public function pagedResults() {
		return $this->hasMany('App\QuestionaireResult', 'participantID')
					->skip(static::$PAGED_FROM)
					->take(static::$PAGED_NUM);
	}

	public function answers() {
		$relation = $this->hasMany('App\ParticipantAnswer', 'participantID');
		return $relation;
	}

	public static function allThatChose(Choice $choice, $year = null, $class = null, $room = null) {
		$query = static::join('participant_answers', 'participant_answers.participantID', '=', 'participants.id');
		$query->where('choiceID', $choice->id);
		
		if ($year) $query->where('academicYear', $year);
		if ($class) $query->where('class', $class);
		if ($room) $query->where('room', $room);

		return $query->get();
	}

	public function getQuestionIDForFormID($formID, $suffix) {
		$prefix = 'QuestionSDQ';
		if (Questionaire::is($formID, 'SDQStudentReport') || $formID == null) {
			$middle = 'Student';
		} else if (Questionaire::is($formID, 'SDQTeacherReport')) {
			$middle = 'Teacher';
		} else if (Questionaire::is($formID, 'SDQParentReport')) {
			$middle = 'Parent';
		}

		return Definition::where('name', $prefix.$middle.$suffix)->first()->values;
	}
	
	public function lifeProblems($id = null) {
		$lifeProblems = [];
		$id = $this->getQuestionIDForFormID($id, 'Life');
		$q = Question::find($id);
		$answers = $q->answers($this->id)->get();

		foreach ($answers as $ans) {
			$prob = new \stdClass();
			$choice = $ans->choice()->first();
			$parent = $choice->parent()->first();
			$prob->name = $parent->name;
			$prob->label = $choice->name;

			$lifeProblems[] = $prob;
		}

		$this->lifeProblems = $lifeProblems;
		return $lifeProblems;
	}

	public function notease($id = null) {
		$notease = new \stdClass();
		$id = $this->getQuestionIDForFormID($id, 'NotEase');
		$q = Question::find($id);
		$answer = $q->answer($this)->first();

		$notease = $answer->choice()->first()->name;

		$this->notease = $notease;
		return $notease;
	}

	public function chronic($id = null) {
		$chronic = new \stdClass();
		$id = $this->getQuestionIDForFormID($id, 'Chronic');
		if (Questionaire::is($id, 'SDQReport') || $id == null) {
			$id = Definition::where('name', 'QuestionSDQChronic')->first()->values;
		}

		$q = Question::find($id);
		$answer = $q->answer($this)->first();

		$chronic = $answer->choice()->first()->name;

		$this->chronic = $chronic;
		return $chronic;
	}

	public function comments($id = null) {
		$comments = new \stdClass();
		$id = $this->getQuestionIDForFormID($id, 'Comment');
		$q = Question::find($id);
		$answer = $q->answer($this)->first();

		if ($answer) {
			$input = $answer->inputs()->first();
			if ($input) $comments = $input->value;
			else $omments = 'N/A';
		} else {
			$comments = 'N/A';
		}

		$this->comments = $comments;
		return $comments;
	}

	public static function createOrUpdateWithRequest() {
		$identifier 	= Request::input('identifier');
		$fname 			= Request::input('firstname');
		$lname 			= Request::input('lastname');
		$number			= Request::input('number');
		$class 			= Request::input('class');
		$room 			= Request::input('room');

		$participant = static::where('identifier', $identifier)->first();
		if (!$participant) {
			$participant = new static();
		}

		$participant->identifier = $identifier;
		$participant->firstname = $fname;
		$participant->lastname = $lname;
		$participant->number = $number;
		$participant->class = $class;
		$participant->room = $room;
		$participant->save();

		if (Request::has('academicYear')) {
			$participant->academicYear = Request::input('academicYear');
		}

		return $participant;
	}

}
