<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionGroup extends Model {

	//

	public function questions()
	{
		return $this->hasMany('App\Question', 'groupID');
	}

	public function childs() {
		return $this->hasMany('App\QuestionGroup', 'parentID');
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
			$f = $q->answer($p->id)->first();

			if ($f == null) continue;

			$ans = $f->choice()->first();
			if ($ans) {
				$sumval += $ans->value;
			}
		}
		$this->value = $sumval;
		return $sumval;
	}

	public function criterionForValue($sumval)	 {
		if (!$this->criteria) $this->criteria = $this->criteria()->get();
		return Criterion::criterionThatFallsIntoValue($this->criteria, $sumval);
	}

	public function normalRangeCriteria($name) {
		if (!$this->criteria) $this->criteria = $this->criteria()->get();
		$this->normalRangeCriteria = null;
		foreach ($this->criteria as $c) {
			if ($c->label == $name) {
				return $c;
			}
		}
		return null;
	}

	public static $call = 0;

	public function propertyObject($participant) {
		$properties = $this->childProperties($participant);
		$sum = count($properties) > 0 ? QuestionGroup::sumOfGroupsProperties($properties) : $this->sumAnswersValueOfParticiant($participant);
		$criteria = $this->criterionForValue($sum);
		$normCriteria = $this->normalRangeCriteria('ปกติ');

		$valueString = $criteria->label;
		return [
			'name' => $this->label,
			'value' => $sum,
			'minValue' => ($normCriteria) ? $normCriteria->from : null,
			'maxValue' => ($normCriteria) ? $normCriteria->to : null,
			'valueString' => $valueString,
			'properties' => $properties
		];
	}

	public function childProperties($participant) {
		if ($this->childs == null) $this->childs();
		$properties = [];
		foreach ($this->childs as $child) {
			$properties[] = $child->propertyObject($participant);
		}
		return $properties;
	}

	public static function sumOfGroupsProperties($properties) {
		$sum = 0;
		foreach ($properties as $p) { 
			$sum += $p['value'];
		}
		return $sum;
	}

}
