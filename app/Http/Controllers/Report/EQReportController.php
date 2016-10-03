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

	private function return404($message = 'Data not found') {
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
			return $this->return404('ไม่พบข้อมูลรายงาน');
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
			return $this->return404('ไม่พบข้อมูลรายงาน');
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
		$table = (new Participant())->getTable();
		$query = DB::table($table);
		if ($class) $query->where('class', $class);
		if ($room) $query->where('room', $room);

		$participants = $query->get();

		foreach ($participants as $p) {
			$answers = $p->answers($year)->with('choice.question.group')->get();

		}

		if ($class) $where = "WHERE class = $class";
		if ($room) $where .= "AND room = $room";

		$sql = "
		SELECT qg.label as label, SUM(c.value)/COUNT(distinct p.id) as value
		FROM ( SELECT id, COUNT(distinct id) FROM participants $where GROUP BY id ) p
		INNER JOIN ( SELECT * FROM participant_answers WHERE academicYear = $academicYear ) pa 
													ON p.id = pa.participantID
		INNER JOIN choices c 						ON pa.choiceID = c.id
		INNER JOIN questions q 						ON c.questionID = q.id
		INNER JOIN question_groups qg 				ON q.groupID = qg.id
		WHERE pa.questionaireID = $reportID
		GROUP BY q.groupID";

		$results = DB::select($sql);
		foreach ($results as $row) {
			// TODO: Continue on this, see comment after each line

			// Each row is label and value of questions in group

			// Calculate summation of group (because they are child groups)

			// Reconstruct response object to have structure like
			// Partent Group
			// 		-> Child Group
			// 		-> Child Group
			// 		-> Child Group
			// Partent Group
			// 		-> Child Group
			// 		-> Child Group
		}

		// TODO: Remove all codes after this comment line, if above is successfully constructed
		$query = Questionaire::with(['questionGroups' => function($q){
			$q->with('childs.questions.answers.choice')->whereNull('parentID');
		}]);
		
		$questionaire = $query->find($reportID);

		if ($questionaire) {
			
			$firstGroups = [];
			foreach ($questionaire->questionGroups as $group) {
				$secondGroups = [];
				foreach ($group->childs as $child) {
					$secondSum = 0;
					$secondCount = $child->questions[0]->answers->count();
					$secondItem = new \stdClass();
					foreach ($child->questions as $question) {
						foreach ($question->answers as $answer) {
							$secondSum += $answer->choice->value;
						}
					}

					$secondNormCriteria = $child->normalRangeCriteria('ปกติ');

					$value = round($secondSum / $secondCount);

					$secondItem->name = $child->label;
					$secondItem->sum = $secondSum;
					$secondItem->count = $secondCount;
					$secondItem->maxValue = $secondNormCriteria->to;
					$secondItem->minValue = $secondNormCriteria->from;
					$secondItem->value = $value;
					$secondItem->valueString = $child->criterionForValue($value)->label;
					$secondGroups[] = $secondItem;
				}

				$firstSum = 0;
				$firstCount = count($secondGroups);
				foreach ($secondGroups as $seocondItem) {
					$firstSum += $seocondItem->value;
				}
				$firstItem = new \stdClass();
				$firstItem->name = $group->label;
				$firstItem->sum = $firstSum;
				$firstItem->count = $firstCount;
				$firstItem->value = round($firstSum / $firstCount);
				$firstItem->properties = $secondGroups;

				$firstGroups[] = $firstItem;
			}
		}

		return response()->json([
			'name' => 'root',
			'properties' => $firstGroups
		]);
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
