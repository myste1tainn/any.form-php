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
		if ($formID == env('APP_RISK_ID')) {
			return $this->riskResult($participantID, $formID, $year);
		} else if ($formID == env('APP_SDQ_ID')) {
			return $this->sdqResult($participantID, $formID, $year);
		} else if ($formID == env('APP_EQ_ID')) {
			return $this->eqResult($participantID, $formID, $year);
		}
	}

	private function sdqResult($participantID, $formID, $year) {
		$participant = Participant::find($participantID);
		$form = Questionaire::with('questionGroups.criteria')
							->where('id', $formID)
							->first();

		if ($form) {
			$participant->groups = $form->questionGroups;
			$participant->lifeProblems();
			$participant->chronic();
			$participant->notease();
			$participant->comments();

			foreach ($participant->groups as $g) {
				$g->result = Criterion::riskStringWithModifiers(
					$g->criteria, $g->totalValueWithParticipant($participant)
				);
			}

			return response()->json([
				'status' => 200,
				'success' => true,
				'data' => $participant
			]);
		} else {
			return response()->json([
				'status' => 403,
				'success' => false,
				'message' => 'ไม่พบข้อมูลรายงาน'
			]);
		}

	}

	private function riskResult($participantID, $formID, $year) {
		$participant = Participant::find($participantID);
		$form = Questionaire::find($formID);
		$result = $participant->results()
							  ->where('questionaireID', $formID)
							  ->where('academicYear', $year)
							  ->get();

		$answers = $participant->answers()
							   ->with('choice.parent')
							   ->where('questionaireID', $formID)
							   ->where('academicYear', $year)
							   ->get();

		$mappedAnswers = static::riskNameMappedAnswers($answers);		

		if ($result && $answers) {
			return response()->json([
				'success' => true,
				'data' => [
					'result' => $result,
					'talent' => $mappedAnswers['talent'],
					'disabilities' => $mappedAnswers['disabilities'],
					'aspects' => $mappedAnswers['aspects']
				]
			]);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'ไม่พบข้อมูล '.$form->name.' สำหรับนักเรียนหมายเลข '.$participant->identifier.' ในปีการศึกษา '.$year
			]);
		}
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
