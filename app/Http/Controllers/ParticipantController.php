<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Participant;
use App\Question;
use App\QuestionGroup;
use App\Questionaire;
use App\Criterion;
use Illuminate\Http\Request;

class ParticipantController extends Controller {

	public function load($identifier)
	{
		$participant = Participant::where('identifier', $identifier)->first();
		if ($participant) {
			return response()->json([
				'success' => true,
				'data' => $participant
			]);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'ไม่พบนักเรียนหมายเลข '.$identifier
			]);
		}
	}

	public function result($participantID, $formID, $year) {
		if (Questionaire::is($formID, 'RiskReport')) {
			return $this->riskResult($participantID, $formID, $year);
		} else if (Questionaire::is($formID, 'SDQReports')) {
			return $this->sdqResult($participantID, $formID, $year);
		} else if (Questionaire::is($formID, 'EQReports')) {
			return $this->eqResult($participantID, $formID, $year);
		}
	}

	private function riskResult($participantID, $formID, $year) {
		
	}

	public static function riskNameMappedAnswers($answers) {
		$talent = null;
		$disabilities = [];
		$mappedAnswers = Participant::newMappedAnswer();
		foreach ($answers as $ans) {
			$question = $ans->question()->first();
			$key = $question->id;
			$choice = $ans->choice()->first();
			$parent = $choice->parent;

			if ($choice->isTalent()) {
				$talent = $ans->inputs()->first()->value;
			} else if ($choice->isDisability()) {
				$disabilities[] = $choice->name;
			} else if ($choice->isCustomDisability()) {
				$disabilities[] = $ans->inputs->first()->value;
			}

			$parent = $ans->choice->parent;
			if ($parent == null) continue;

			if (!array_key_exists($key, Question::$riskMap))  continue;	

			$aspect = Question::$riskMap[$key];

			if ($parent) {
				if ($parent->isHighRisk()) {
					$mappedAnswers['countHighRisk']++;
					$mappedAnswers[$aspect['nodeName']]['high'][] = $choice;
				} else if ($parent->isVeryHighRisk()) {
					$mappedAnswers['countVeryHighRisk']++;
					$mappedAnswers[$aspect['nodeName']]['veryHigh'][] = $choice;
				}
			}
		}

		return [
			'talent' => $talent,
			'disabilities' => $disabilities,
			'aspects' => $mappedAnswers
		];
	}

}
