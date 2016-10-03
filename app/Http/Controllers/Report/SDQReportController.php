<?php namespace App\Http\Controllers\Report;

use App\Questionaire;
use App\QuestionaireResult;
use App\QuestionGroup;
use App\Criterion;
use App\Participant;
use App\Definition;

use App\Http\Requests;
use Illuminate\Http\Request;

class SDQReportController extends AbstractReport {

	public function participantList($reportID, $year, $from = 0, $num = 10) {
		$participants = Questionaire::participantsForQuestionaire($reportID, $year, $from, $num);
		if ($participants) {
			return response()->json($participants, 200);
		} else {
			return response()->json([
				'message' => 'ไม่พบข้อมูลรายงาน'
			], 404);
		}
	}
	public function participantDetail($participantIdentifier, $reportID, $year) {
		$participant = Participant::where('identifier', $participantIdentifier)->first();
		$form = Questionaire::with('questionGroups.criteria')
							->where('id', $reportID)
							->first();

		if ($participant && $form) {
			$participant->groups = $form->questionGroups;
			$participant->lifeProblems($reportID);
			$participant->chronic($reportID);
			$participant->notease($reportID);
			$participant->comments($reportID);

			foreach ($participant->groups as $g) {
				$g->result = Criterion::riskStringWithModifiers(
					$g->criteria, $g->sumAnswersValueOfParticiant($participant)
				);
			}

			return response()->json($participant, 200);
		} else {
			return response()->json([
				'message' => 'ไม่พบข้อมูลรายงาน'
			], 404);
		}
	}
	public function summaryByRoom($reportID, $class, $room, $year) {
		return $this->resultByType($reportID, $class, $room, $year);
	}
	public function summaryByClass($reportID, $class, $room, $year) {
		return $this->resultByType($reportID, $class, $room, $year);
	}
	public function summaryBySchool($reportID, $class, $room, $year) {
		return $this->resultByType($reportID, $class, $room, $year);
	}

	private function resultByType($id, $class = null, $room = null, $year) {
		$participants = Questionaire::participantsForQuestionaire($id, $year, 0, 1000000, $class, $room);
		$questionaire = Questionaire::with('questionGroups.questions', 'questionGroups.criteria')
									->where('id', $id)
									->first();

		$groups = $questionaire->questionGroups;

		if ($groups) {

			foreach ($groups as $g) {
				
				foreach ($participants as $p) {
				
					$sumval = $g->sumAnswersValueOfParticiant($p);
					$c = $g->criterionForValue($sumval);

					if ($c) {
						if (!isset($c->count)) {
							$c->count = 0;
						}

						$c->count++;
					}

				}

			}

			return response()->json($groups, 200);

		} else {
			return response()->json([
				'message' => 'ไม่พบข้อมูลรายงาน'
			], 404);
		}
	}

}
