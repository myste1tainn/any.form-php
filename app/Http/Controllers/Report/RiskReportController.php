<?php namespace App\Http\Controllers\Report;

use App\Questionaire;
use App\QuestionaireResult;
use App\QuestionGroup;
use App\Criterion;
use App\Participant;
use App\Definition;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RiskReportController extends AbstractReport {

	private function list($id, $year, $from = 0, $num = 10) {
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

	private function riskResult($id, $class, $room, $year) {
		$results = [];

		$questionaire = Questionaire::find($id);


		$questions = $questionaire->questions()->get();

		// TODO: This is ugly, there should be a way to load definition within
		// Question.php and make it retain and not having to be re-query
		$def = Definition::where('name', 'QuestionRisks')->first();

		foreach ($questions as $question) {
			$choices = $question->choices(true)->get();

			$participants = [];

			// TODO: This shouldn't take parameter, above reason
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
