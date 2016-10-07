<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Criterion extends Model {

	public static function createWith($questionaire, $iCriteria) {
		$criteria = [];
		foreach ($iCriteria as $iCriterion) {
			$criterion = new Criterion();
			$criterion->label = $iCriterion['label'];
			$criterion->from = $iCriterion['from'];
			$criterion->to = $iCriterion['to'];
			$criterion->questionaireID = $questionaire->id;
			$criterion->save();

			$criteria[] = $criterion;
		}

		return $criteria;
	}

	public static function updateWith($questionaire, $iCriteria) {
		$criteria = [];
		foreach ($iCriteria as $iCriterion) {
			$criterion = Criterion::find($iCriterion['id']);
			
			if (!$criterion) {
				$criterion = new Criterion();
			}

			$criterion->label = $iCriterion['label'];
			$criterion->from = $iCriterion['from'];
			$criterion->to = $iCriterion['to'];
			$criterion->questionaireID = $questionaire->id;
			$criterion->save();

			$criteria[] = $criterion;
		}

		return $criteria;
	}

	public function inValue($value) {
		$value = round($value);
		return ($value >= $this->from && $value <= $this->to);
	}

	public static function riskString($criteria, $value) {
		foreach ($criteria as $c) {
			if ($c->inValue($value)) {
				return $c->label;
			}
		}

		return "ไม่เข้าเกณฑ์ใดๆ";
	}

	public static function criterionThatFallsIntoValue($criteria, $value) {
		foreach ($criteria as $c) {
			if ($c->inValue($value)) {
				return $c;
			}
		}
		return null;
	}

	public static function riskStringWithModifiers($criteria, $value) {
		$obj = new \stdClass();
		foreach ($criteria as $c) {
			if ($c->inValue($value)) {
				$obj->string = $c->label;

				if ($obj->string == 'ปกติ') {
					$obj->modifier = 'rnormal';
				} else if ($obj->string == 'เสี่ยง') {
					$obj->modifier = 'rhigh';
				} else if ($obj->string == 'มีปัญหา') {
					$obj->modifier = 'rveryhigh';
				} else {
					$obj->modifier = 'rneutral';
				}

				return $obj;
			}
		}

		$obj->string = "ไม่เข้าเกณฑ์ใดๆ";
		$obj->modifier = "unknown";
		return $obj;
	}
}
