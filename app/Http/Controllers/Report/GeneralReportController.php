<?php namespace App\Http\Controllers;

use App\Questionaire;
use App\QuestionaireResult;
use App\QuestionGroup;
use App\Criterion;
use App\Participant;
use App\Definition;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GeneralReportController extends Controller {

	public function list($reportID, $year, $from = 0, $num = 10) {
		$q = Questionaire::with('criteria')
						 ->where('id', $reportID)
						 ->first();

		if ($q) {
			$q->results($year, $from, $num);
			foreach ($q->results as $r) {
				$rs = Criterion::riskString($q->criteria, $r->value);
				$r->risk =$rs;
			}
			return response()->json($q->results);
		} else {
			return response()->json([], 404);
		}
	}

	public function summaryByRoom($id, $class, $room, $year) {
		return $this->($id, $class, $room, $year);
	}
	public function summaryClass($id, $class, $room, $year) {
		return $this->($id, $class, null, $year);
	}
	public function summarySchool($id, $class, $room, $year) {
		return $this->($id, null, null, $year);
	}

	private function summary($id, $class, $room, $year) {
		$results = $this->fetchDataAndSummation($id, $class, $room, $year);
		if ($results->sumNum > 0) {
			foreach ($results->criteria as $c) {
				$c->percent = round($c->number / $sumnum * 100, 2);
			}

			$carr = $results->criteria->toArray();
			usort($carr, function($a, $b){
				return $a['percent'] < $b['percent'];
			});

			return response()->json([[
				'avgRisk' => Criterion::riskString($criteria, $avg),
				'avgValue' => $results->average,
				'total' => $results->sumNum,
				'criteria' => $carr
			]]);
		} else {
            return response()->json([[]], 404);
        }
	}

	private function fetchDataAndSummation($id, $class, $room, $year) {
		$criteria = Criterion::where('questionaireID', $id)->get();

		$sumNum = 0;
		$sumValue = 0;
		foreach ($criteria as $c) {
			$query = $this->buildQuery($id, $class, $room, $year, $c);
			$r = $query->first();

			$this->injectValues($c, $r, $class, $room);
			
			$sumValue += $c->value;
			$sumNum += $c->number;
		}

		$results->data = $criteria;
		$results->sumValue = $sumValue;
		$results->sumNum = $sumNum;
		$results->average = ($sumNum > 0) ? round($sumval / $sumnum, 2) : -1;

		return $results;
	}

	private function injectValues($c,$r,$room,$class) {
		$c->room = $room;
		$c->class = $class;
		$c->number = $r['number'];
		$c->value = $r['value'];
	}

	private function buildQuery($id, $class, $room, $year$c) {
		$query = QuestionaireResult::where('questionaire_results.questionaireID', $id)
								   ->where('questionaire_results.value', '>=', $c->from)
								   ->where('questionaire_results.value', '<=', $c->to)

		$this->addFilterIfNeed('participants.class', $class);
		$this->addFilterIfNeed('participants.room', $room);
		$this->addFilterIfNeed('academicYear', $year);
		$this->addJoin($query);
		$this->addGroup($query);
		$this->addRaw($query);

		return $query;
	}

	private function addFilterIfNeed($name, $value) {
		if ($value) {
			$query->where($name, $value);
		}
	}
	private function addJoin($query) {
		$query->join('participants', 'questionaire_results.participantID','=','participants.id');
	}
	private function addGroup($query) {
		$query->groupBy(['participants.room'])
	}
	private function addRaw($query) {
		$query->selectRaw('count(participants.id) as number, sum(questionaire_results.value) as value')
	}

}