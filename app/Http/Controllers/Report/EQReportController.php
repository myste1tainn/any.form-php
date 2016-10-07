<?php namespace App\Http\Controllers\Report;

use App\Questionaire;
use App\QuestionaireResult;
use App\QuestionGroup;
use App\Criterion;
use App\Participant;
use App\ParticipantAnswer;
use App\Choice;
use App\Definition;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use DB;

class EQReportController extends AbstractReport {

	private function responseNotFound($message = 'Data not found') {
		return response()->json(['message' => $message], 404);
	}

	private function injectAttributes($participant, $form) {
		$properties = [];
		foreach ($form->questionGroups as $group) {
			$properties[] = $group->propertyObject($participant);
		}
		$participant['properties'] = $properties;
	}

	public function participantList($reportID, $year, $from = 0, $num = 10) {
		Questionaire::$PAGED_FROM = $from;
		Questionaire::$PAGED_NUM = $num;
		$query = Questionaire::with(['pagedResults.participant']);
		$query->with(['questionGroups' => function($q){
			$q->whereNull('parentID');
		}]);
		$form = $query->where('id', $reportID)->first();

		if (!$form || count($form->pagedResults) == 0) {
			return $this->responseNotFound('ไม่พบข้อมูลรายงาน');
		} else {
			$participants = [];
			foreach ($form->pagedResults as $res) {
				$this->injectAttributes($res->participant, $form);
				$participants[] = $res->participant;
			}
			return response()->json($participants);
		}
	}

	public function participantDetail($participantIdentifier, $reportID, $year) {
		$query = Questionaire::with(['questionGroups' => function($q){
			$q->whereNull('parentID');
		}]);
		$form = $query->find($reportID);
		$participant = Participant::where('identifier', $participantIdentifier)->first();

		if (!$form || !$participant) {
			return $this->responseNotFound('ไม่พบข้อมูลรายงาน');
		} else {
			$this->injectAttributes($participant, $form);
			return response()->json($participant);
		}
	}
	public function summaryByRoom($reportID, $class, $room, $year) {
		return $this->summaryBySchool($reportID, $class, $room, $year);
	}
	public function summaryByClass($reportID, $class, $room, $year) {
		return $this->summaryBySchool($reportID, $class, null, $year);
	}
	public function summaryBySchool($reportID, $class, $room, $year) {
		$where = "";
		if ($class) $where = "WHERE class = $class";
		if ($room) $where .= " AND room = $room";

		$sql = "
		SELECT 		qg.id as id,
					qg.label as name, 
					pqg.label as groupName,
					cri.from as minValue,
					cri.to as `maxValue`,
					ROUND(SUM(c.value)/COUNT(distinct p.id)) as value

		FROM ( SELECT id, COUNT(distinct id) FROM participants $where GROUP BY id ) p
		INNER JOIN ( SELECT * FROM participant_answers WHERE academicYear = $year ) pa 
													ON p.id = pa.participantID
		INNER JOIN choices c 						ON pa.choiceID = c.id
		INNER JOIN questions q 						ON c.questionID = q.id
		INNER JOIN question_groups qg 				ON q.groupID = qg.id
		INNER JOIN question_groups pqg 				ON qg.parentID = pqg.id
		INNER JOIN criteria cri 					ON cri.groupID = qg.id
		WHERE pa.questionaireID = $reportID
		AND cri.label = 'ปกติ'
		GROUP BY q.groupID";

		$groups = [];
		$results = DB::select($sql);

		if (count($results) > 0) {
			foreach ($results as $row) {
				// Each row is label and value of questions in group
				if (!isset($groups[$row->groupName])) {
					$groups[$row->groupName] = new \stdClass();
					$groups[$row->groupName]->value = 0;
					$groups[$row->groupName]->properties = [];
				}

				$row->value = (int) $row->value;
				$criteria = Criterion::where('groupID', $row->id)->get();
				$row->valueString = Criterion::criterionThatFallsIntoValue($criteria, $row->value)->label;

				$groups[$row->groupName]->name = $row->groupName;
				$groups[$row->groupName]->value += $row->value;
				$groups[$row->groupName]->properties[] = $row;
			}

			return response()->json([
				'name' => 'root',
				'properties' => array_values($groups)
			]);
		} else {
			return $this->responseNotFound('ไม่พบข้อมูลรายงาน');
		}

			
	}

	public function countOfGroup($reportID, $groupName, $year, $class = null, $room = null) {
		// TODO: [Later] label should be changed to alias
		// Get criteria & questions for the corresponding group
		$query = QuestionGroup::with('criteria', 'questions', 'childs.questions');
		$query->where('label', $groupName)->where('questionaireID', $reportID)->first();
		$group = $query->first();

		// Get total answers value grouped by participants
		$t_pa = (new ParticipantAnswer())->getTable();
		$t_c = (new Choice())->getTable();
		$a_q_ids = $this->properQuestionIDsString($group);

		$results = DB::select(DB::raw("
			SELECT SUM(c.value) as sum
			FROM $t_pa as pa
			INNER JOIN $t_c c on pa.choiceID = c.id
			WHERE pa.questionID in ($a_q_ids)
			GROUP BY pa.participantID
		"));

		$this->countWithResultsAndGroup($results, $group);

		return response()->json($group->criteria);
	}

	private function countWithResultsAndGroup($results, $group) {
		foreach ($results as $row) {
			$theRightCriterion = Criterion::criterionThatFallsIntoValue($group->criteria, $row->sum);
			if (!$theRightCriterion->count) {
				$theRightCriterion->count = 0;
			}
			$theRightCriterion->count++;
		}
	}

	private function properQuestionIDsString($group) {
		$a_q_ids = '';
		if ($group->childs->count() > 0) {
			$a_q_ids = '';
			foreach ($group->childs as $child) {
				$a_q_ids .= implode(',', $child->questions->lists('id'));

				if ($child != $group->childs->last()) {
					$a_q_ids .= ',';
				}
			}
		} else {
			$a_q_ids = implode(',', $group->questions->lists('id'));
		}

		return $a_q_ids;
	}

}
