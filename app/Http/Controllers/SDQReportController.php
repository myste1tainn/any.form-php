<?php namespace App\Http\Controllers;

use App\Questionaire;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SDQReportController extends Controller {

	public function resultByPerson($id, $year, $from = 0, $num = 10) {
		$participants = Questionaire::participantsForQuestionaire($id, $year, $from, $num);
		if ($participants) {
			return response()->json($participants, 200);
		} else {
			return response()->json([
				'message' => 'ไม่พบข้อมูลรายงาน'
			], 404);
		}
	}

	public function resultByRoom($id, $class, $room, $year) {
		return $this->resultByType($id, $class, $room, $year);
	}

	public function resultByClass($id, $class, $year) {
		return $this->resultByType($id, $class, null, $year);
	}

	public function resultBySchool($id, $year) {
		return $this->resultByType($id, null, null, $year);
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
					$c = $g->valueFallsInCriterion($sumval);

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
