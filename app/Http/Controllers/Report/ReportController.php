<?php namespace App\Http\Controllers\Report;

use App\Questionaire;
use App\QuestionaireResult;
use App\QuestionGroup;
use App\Criterion;
use App\Participant;
use App\Definition;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ReportController extends Controller {

	protected function getReportControllerInstance($id) {
		if (Questionaire::is($id, 'RiskReport')) {
			return new RiskReportController();
		} else if (Questionaire::is($id, 'SDQReports')) {
			return new SDQReportController();
		} else if (Questionaire::is($id, 'EQReports')) {
			return new EQReportController();
		} else {
			return new GeneralReportController();
		}
	}

	public function result()
	{
		$questionaires = Questionaire::with('results.participant', 'criteria')
									 ->get();

		foreach ($questionaires as $q) {
			foreach ($q->results as $r) {
				$rs = Criterion::riskString($q->criteria, $r->value);
				$r->risk =$rs;
			}
		}

		return response()->json($questionaires);
	}

	public function resultByPerson($id, $year, $from = 0, $num = 10) {
		$reportController = $this->getReportControllerInstance($id);
		return $reportController->list($id, $year, $from, $num);
	}

	public function resultByRoom($id, $class, $room, $year) {
		$reportController = $this->getReportControllerInstance($id);
		return $reportController->summaryByRoom($id, $class, $room, $year);
	}

	public function resultByClass($id, $class, $year) {
		$reportController = $this->getReportControllerInstance($id);
		return $reportController->summaryByRoom($id, $class, null, $year);
	}

	public function resultBySchool($id, $year) {
		$reportController = $this->getReportControllerInstance($id);
		return $reportController->summaryBySchool($id, null, null, $num);
	}

	public function numberOfPages($id, $year, $numRows = 10)
	{
		$count = Questionaire::participantsCountForQuestionaire($id, $year);
		$numberOfPages = floor($count / $numRows);
		return $numberOfPages;
	}
}
