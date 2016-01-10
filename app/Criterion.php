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
			$criterion->label = $iCriterion['label'];
			$criterion->from = $iCriterion['from'];
			$criterion->to = $iCriterion['to'];
			$criterion->questionaireID = $questionaire->id;
			$criterion->save();

			$criteria[] = $criterion;
		}

		return $criteria;
	}

	public function pass($value) {
		return ($value >= $from && $value <= $to);
	}
}
