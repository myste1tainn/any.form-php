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

	public function lifeProblems() {
		$lifeProblems = [];
		$id = env('APP_QUESTION_SDQ_LIFE');
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

	public function notease() {
		$notease = new \stdClass();
		$id = env('APP_QUESTION_SDQ_NOTEASE');
		$q = Question::find($id);
		$answer = $q->answer($this)->first();

		$notease = $answer->choice()->first()->name;

		$this->notease = $notease;
		return $notease;
	}

	public function chronic() {
		$chronic = new \stdClass();
		$id = env('APP_QUESTION_SDQ_CHRONIC');
		$q = Question::find($id);
		$answer = $q->answer($this)->first();

		$chronic = $answer->choice()->first()->name;

		$this->chronic = $chronic;
		return $chronic;
	}

}
