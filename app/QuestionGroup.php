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

	public static function sumValue($groups, $p, $excludeIDs = null) {

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

			$sumval += $g->totalValueWithParticipant($p);
		}

		return $sumval;
	}

	public function totalValueWithParticipant($p) {
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

}
