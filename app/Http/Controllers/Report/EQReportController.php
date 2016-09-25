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

	}
	public function summaryByClass($reportID, $class, $room, $year) {

	}
	public function summaryBySchool($reportID, $class, $room, $year) {

	}

}
