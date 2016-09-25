<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionaire extends Model {

	public static $PAGED_FROM = 0;
	public static $PAGED_NUM = 20;

	public function criteria() {
		return $this->hasMany('App\Criterion', 'questionaireID');
	}

	public function questions() {
		return $this->hasMany('App\Question', 'questionaireID');
	}

	public function questionGroups() {
		return $this->hasMany('App\QuestionGroup', 'questionaireID')->with('questions');
	}

	public function pagedResults() {
		return $this->hasMany('App\QuestionaireResult', 'questionaireID')
					->skip(static::$PAGED_FROM)
					->take(static::$PAGED_NUM);
	}

	public function parent() {
		return $this->belongsTo('App\Questionaire', 'parentID');
	}

	public function childs() {
		return $this->hasMany('App\Questionaire', 'id');
	}

	// Get all results that is related to this questionaire
	public function results($year = null, $from = null, $num = null, $class = null, $room = null, $eager = true) {
		$query = $this->hasMany('App\QuestionaireResult', 'questionaireID')->join('participants', 'questionaire_results.participantID', '=', 'participants.id');

		if ($from) 	{$query->skip($from);}
		if ($num) 	{$query->take($num);}

		if ($year) {
			$query->where('academicYear', $year);
		}

		if ($class) {
			$query->where('class', $class);
		}
		if ($room) {
			$query->where('room', $room);
		}


		if ($eager) {
			$this->results = $query->get();
		} else {
			return $query;
		}
	}

	public static function participantsCountForQuestionaire($id, $year = null, $class = null, $room = null) {
		$questionaire = Questionaire::find($id);
		return $questionaire->participantsCount($year, $class, $room);
	}

	// Get all participants who did this form 
	public static function participantsForQuestionaire($id, $year, $from, $num, $class = null, $room = null) {
		$questionaire = Questionaire::find($id);
		return $questionaire->participants($year, $from, $num, $class, $room);
	}

	public function participants($year, $from, $num, $class, $room) {
		$this->results($year, $from, $num, $class, $room);
		$this->questionGroups();

		$participants = [];
		foreach ($this->results as $res) {

			// Sum value of answers on the question in group answered by the participant
			// with the specified group ID excluded
			$sumval = QuestionGroup::sumOf(
				$this->questionGroups, 
				$res->participant,
				[env('APP_QUESTION_GROUP_SDQ_SOC_ID')]
			);

			// TODO: Continue from here, use the definition table instead of env('APP_QUESTION_GROUP_SDQ_SOC_ID')
			dd($sumval, env('APP_QUESTION_GROUP_SDQ_SOC_ID'), $res);

			$riskString = Criterion::riskString($this->criteria, $sumval);
			$res->participant->risk = $riskString." ($sumval)";

			$participants[] = $res->participant;
		}

		return $participants;
	}

	public function participantsCount($year, $class, $room) {
		return $this->results($year, null, null, $class, $room, false)->count();
	}

	public static function is($id, $name) {
		$def = Definition::where('name', $name)
						 ->where('tableName',  'questionaires')
						 ->where('columnName', 'id')
						 ->first();

		if ($def) {
			return strpos($def->values, $id) !== false;
		} else {
			return false;
		}
	}
}
