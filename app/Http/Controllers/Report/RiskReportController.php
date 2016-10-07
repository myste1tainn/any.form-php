<?php namespace App\Http\Controllers\Report;

use App\Questionaire;
use App\QuestionaireResult;
use App\QuestionGroup;
use App\Criterion;
use App\Participant;
use App\Definition;

use App\Http\Requests;
use App\Http\Controllers\ParticipantController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RiskReportController extends AbstractReport {

	public function participantList($id, $year, $from = 0, $num = 10) {
		// Risk screening reports shows with different info
		Questionaire::$PAGED_FROM = $from;
		Questionaire::$PAGED_NUM = $num;
		$questionaire = Questionaire::with('pagedResults.participant.answers.choice.parent')->find($id);
		
		if ($questionaire) {
			$participants = [];
			foreach ($questionaire->pagedResults as $res) {
				$p = $res->participant;
				$mappedAnswers = ParticipantController::riskNameMappedAnswers($p->answers);

				$p->talent = $mappedAnswers['talent'];
				$p->disabilities = $mappedAnswers['disabilities'];
				$p->risks = $mappedAnswers['aspects'];
				$participants[] = $p;
			}

			if ($participants) {
				return response()->json($participants);
			}
		}

		return response()->json([], 404);
	}

	public function participantDetail($participantIdentifier, $reportID, $year) {
		$participant = Participant::where('identifier', $participantIdentifier)->first();

		if (!$participant) {
			return response()->json([
				"message" => 'ไม่พบข้อมูลสำหรับนักเรียนหมายเลข '.$participantIdentifier
			], 404);
		}

		$form = Questionaire::find($reportID);
		$result = $participant->results()
							  ->where('questionaireID', $reportID)
							  ->where('academicYear', $year)
							  ->get();

		$answers = $participant->answers()
							   ->with('choice.parent')
							   ->where('questionaireID', $reportID)
							   ->where('academicYear', $year)
							   ->get();

		$mappedAnswers = ParticipantController::riskNameMappedAnswers($answers);		

		$participant->talent = $mappedAnswers['talent'];
		$participant->disabilities = $mappedAnswers['disabilities'];
		$participant->aspects = $mappedAnswers['aspects'];

		if ($result && $answers) {
			return response()->json($participant);
		} else {
			return response()->json([
				'message' => 'ไม่พบข้อมูล '.$form->name.' สำหรับนักเรียนหมายเลข '.$participant->identifier.' ในปีการศึกษา '.$year
			], 404);
		}
	}
	public function summaryByRoom($reportID, $class, $room, $year) {
		return $this->riskResult($reportID, $class, $room, $year);
	}
	public function summaryByClass($reportID, $class, $room, $year) {
		return $this->riskResult($reportID, $class, $room, $year);
	}
	public function summaryBySchool($reportID, $class, $room, $year) {
		return $this->riskResult($reportID, $class, $room, $year);
	}

	private function riskResult($id, $class, $room, $year) {
		$results = [];
		$questionaire = Questionaire::find($id);
		$questions = $questionaire->questions()->get();

		// TODO: [LATER] This is ugly, there should be a way to load definition within
		// Question.php and make it retain and not having to be re-query
		$def = Definition::where('name', 'QuestionRisks')->first();

		foreach ($questions as $question) {
			$choices = $question->choices(true)->get();

			$participants = [];

			// TODO: [LATER] This shouldn't take parameter, above reason
			if ($question->isAspect($def)) {
				$question->shortName = $question->info('name');

				foreach ($choices as $choice) {
					if ($choice->isHighRisk()) {
						$pp = Participant::allThatChose($choice, $year, $class, $room);

						$question->countHighRisk += count($pp);

						// Extract all participants that choses this choice as answer
						
						foreach ($pp as $p) {
							$participants[] = $p;
						}
					} else if ($choice->isVeryHighRisk()) {
						$pp = Participant::allThatChose($choice, $year, $class, $room);

						$question->countVeryHighRisk += count($pp);

						// Extract all participants that choses this choice as answer
						
						foreach ($pp as $p) {
							$participants[] = $p;
						}
					}
				}

				$question->participants = $participants;

				$results[] = $question;
			}
		}

		if (count($results) > 0) {
			return response()->json($results);
		} else {
			return response()->json([], 404);
		}
	}	

}
