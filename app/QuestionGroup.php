<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionGroup extends Model {

	//

	public function questions()
	{
		return $this->hasMany('App\Question', 'groupID');
	}

	public function criteria()
	{
		return $this->hasMany('App\Criterion', 'groupID');
	}

	public static function sumOf($groups, $p, $excludeIDs = null) {

		if ($excludeIDs) {
			if (!is_array($excludeIDs)) {
				$excludeIDs = [$excludeIDs];
			}
		}


		$sumval = 0;
		foreach ($groups as $g) {

			if ($excludeIDs) {
				if (in_array($g->id, $excludeIDs)) {
					continue;
				}
			}

			$sumval += $g->sumAnswersValueOfParticiant($p);
		}

		return $sumval;
	}

	public function sumAnswersValueOfParticiant($p) {
		if (!$this->questions) {
			$this->questions();
		}

		$sumval = 0;
		foreach($this->questions as $q) {
			$ans = $q->answer($p->id)->first()->choice()->first();
			if ($ans) {
				$sumval += $ans->value;
			}
		}
		$this->value = $sumval;
		return $sumval;
	}

	public function valueFallsInCriterion($sumval)	 {
		if (!$this->criteria) $this->criteria = $this->criteria()->get();
		return Criterion::criterionThatFallsIntoValue($this->criteria, $sumval);
	}

}
