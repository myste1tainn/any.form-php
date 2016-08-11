<?php namespace App;

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
		return $this->hasMany('App\ParticipantAnswer', 'participantID');
	}

	public static function allThatChose(Choice $choice, $year = null, $class = null, $room = null) {
		$query = static::join('participant_answers', 'participant_answers.participantID', '=', 'participants.id');
		$query->where('choiceID', $choice->id);
		
		if ($year) $query->where('academicYear', $year);
		if ($class) $query->where('class', $class);
		if ($room) $query->where('room', $room);

		return $query->get();
	}

	public function lifeProblems($id = null) {
		$lifeProblems = [];

		if ($id == env('APP_SDQ_ID') || $id == null) {
			$id = env('APP_QUESTION_SDQ_LIFE');
		} else if ($id == env('APP_SDQT_ID')) {
			$id = env('APP_QUESTION_SDQT_LIFE');
		} else if ($id == env('APP_SDQP_ID')) {
			$id = env('APP_QUESTION_SDQP_LIFE');
		}

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
		
		if ($id == env('APP_SDQ_ID') || $id == null) {
			$id = env('APP_QUESTION_SDQ_NOTEASE');
		} else if ($id == env('APP_SDQT_ID')) {
			$id = env('APP_QUESTION_SDQT_NOTEASE');
		} else if ($id == env('APP_SDQP_ID')) {
			$id = env('APP_QUESTION_SDQP_NOTEASE');
		}

		$q = Question::find($id);
		$answer = $q->answer($this)->first();

		$notease = $answer->choice()->first()->name;

		$this->notease = $notease;
		return $notease;
	}

	public function chronic($id = null) {
		$chronic = new \stdClass();

		if ($id == env('APP_SDQ_ID') || $id == null) {
			$id = env('APP_QUESTION_SDQ_CHRONIC');
		} else if ($id == env('APP_SDQT_ID')) {
			$id = env('APP_QUESTION_SDQT_CHRONIC');
		} else if ($id == env('APP_SDQP_ID')) {
			$id = env('APP_QUESTION_SDQP_CHRONIC');
		}

		$q = Question::find($id);
		$answer = $q->answer($this)->first();

		$chronic = $answer->choice()->first()->name;

		$this->chronic = $chronic;
		return $chronic;
	}

	public function comments($id = null) {
		$comments = new \stdClass();
		
		if ($id == env('APP_SDQ_ID') || $id == null) {
			$id = env('APP_QUESTION_SDQ_COMMENTS');
		} else if ($id == env('APP_SDQT_ID')) {
			$id = env('APP_QUESTION_SDQT_COMMENTS');
		} else if ($id == env('APP_SDQP_ID')) {
			$id = env('APP_QUESTION_SDQP_COMMENTS');
		}

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

}
