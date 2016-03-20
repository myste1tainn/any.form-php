<?php namespace App\Http\Controllers;

use App\Questionaire;
use App\QuestionaireResult;
use App\Criterion;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ReportController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('report/main');
	}

	public function template($name) {
		return view('report/template/'.$name);
	}

	public function riskTemplate($name) {
		return view('report/template/risk-'.$name);
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

		return response()->json([
			'success' => true,
			'data' => $questionaires
		]);
	}

	public function resultByRoom($id, $class, $room) {
		// $results = Questionaire::where('questionaires.id', $id)
		// 						->join(
		// 							'questionaire_results', 
		// 							'questionaires.id', 
		// 							'=', 
		// 							'questionaire_results.questionaireID'
		// 						)
		// 						->join(
		// 							'participants', 
		// 							'questionaire_results.participantID', 
		// 							'=', 
		// 							'participants.id'
		// 						)
		// 						->groupBy(
		// 							'participants.class', 
		// 							'participants.room'
		// 						)
		// 						->selectRaw(
		// 							'
		// 							participants.class as class,
		// 							participants.room as room,
		// 							avg(questionaire_results.value) as value
		// 							'
		// 						)
		// 						->get();

		// $criteria = Criterion::where('questionaireID', $id)->get();

		// $res = [[],[],[],[],[],[]];
		// foreach ($results as $r) {
		// 	$r->risk = Criterion::riskString($criteria, $r->value);
		// 	$r->value = round($r->value, 2);

		// 	$res[$r->class - 1]['class'] = $r->class;
		// 	$res[$r->class - 1]['results'][] = $r;
		// }

		// foreach ($res as &$class) {
		// 	usort($class['results'], function ($a, $b) {
		// 		return intval($a->room) > intval($b->room);
		// 	});

		// 	$sum = 0;
		// 	$count = count($class['results']);
		// 	foreach ($class['results'] as $r) {
		// 		$sum += $r->value;
		// 	}
		// 	$class['avgValue'] = round($sum / $count, 2);
		// 	$class['avgRisk'] = Criterion::riskString($criteria, $class['avgValue']);
		// }

		// return response()->json([
		// 	'success' => true,
		// 	'data' => $res
		// ]); 

		$criteria = Criterion::where('questionaireID', $id)->get();

		$sumnum = 0;
		$sumval = 0;
		$i = 0;
		foreach ($criteria as $c) {
			$r = QuestionaireResult::where('questionaire_results.questionaireID', $id)
									 ->where('questionaire_results.value', '>=', $c->from)
									 ->where('questionaire_results.value', '<=', $c->to)
									 ->where('participants.class', $class)
									 ->where('participants.room', $room)
									 ->join(
									 	'participants', 
									 	'questionaire_results.participantID',
									 	'=',
									 	'participants.id'
									 )
									 // ->toSql();
									 ->groupBy([
									 	'participants.room'
									 ])
									 ->selectRaw('
									 	count(participants.id) as number,
									 	sum(questionaire_results.value) as value
									 ')
									 ->first();

			$c->room = $room;
			$c->class = $class;
			$c->number = $r['number'];
			$c->value = $r['value'];
			$sumval += $c->value;
			$sumnum += $c->number;
		}
        
        if ($sumnum < 1) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูลรายงาน'
            ]);
        }
        
		$avg = round($sumval / $sumnum, 2);

		foreach ($criteria as $c) {
			$c->percent = round($c->number / $sumnum * 100, 2);
		}

		$carr = $criteria->toArray();
		usort($carr, function($a, $b){
			return $a['percent'] < $b['percent'];
		});

		return response()->json([
			'success' => true,
			'data' => [[
				'avgRisk' => Criterion::riskString($criteria, $avg),
				'avgValue' => $avg,
				'total' => $sumnum,
				'criteria' => $carr
			]]
		]);
	}

	public function resultByClass($id, $class) {
		$criteria = Criterion::where('questionaireID', $id)->get();

		$sumnum = 0;
		$sumval = 0;
		$i = 0;
		foreach ($criteria as $c) {
			$r = QuestionaireResult::where('questionaire_results.questionaireID', $id)
									 ->where('questionaire_results.value', '>=', $c->from)
									 ->where('questionaire_results.value', '<=', $c->to)
									 ->where('participants.class', $class)
									 ->join(
									 	'participants', 
									 	'questionaire_results.participantID',
									 	'=',
									 	'participants.id'
									 )
									 ->groupBy([
									 	'participants.class'
									 ])
									 ->selectRaw('
									 	count(participants.id) as number,
									 	sum(questionaire_results.value) as value
									 ')
									 ->first();

			$c->class = $class;
			$c->number = $r['number'];
			$c->value = $r['value'];
			$sumval += $c->value;
			$sumnum += $c->number;
		}

		$avg = round($sumval / $sumnum, 2);

		foreach ($criteria as $c) {
			$c->percent = round($c->number / $sumnum * 100, 2);
		}

		$carr = $criteria->toArray();
		usort($carr, function($a, $b){
			return $a['percent'] < $b['percent'];
		});

		return response()->json([
			'success' => true,
			'data' => [[
				'avgRisk' => Criterion::riskString($criteria, $avg),
				'avgValue' => $avg,
				'total' => $sumnum,
				'criteria' => $carr
			]]
		]);
	}

	public function resultByPerson($id) {
		$q = Questionaire::with('results.participant', 'criteria')
									 ->where('id', $id)
									 ->first();

		if ($q) {
			foreach ($q->results as $r) {
				$rs = Criterion::riskString($q->criteria, $r->value);
				$r->risk =$rs;
			}
			return response()->json([
				'success' => true,
				'data' => $q->results
			]);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'result is empty'
			]);
		}

		
	}

	public function resultBySchool($id) {
		$criteria = Criterion::where('questionaireID', $id)->get();

		$sumnum = 0;
		$sumval = 0;
		$i = 0;
		foreach ($criteria as $c) {
			$r = QuestionaireResult::where('questionaire_results.questionaireID', $id)
									 ->where('questionaire_results.value', '>=', $c->from)
									 ->where('questionaire_results.value', '<=', $c->to)
									 ->join(
									 	'participants', 
									 	'questionaire_results.participantID',
									 	'=',
									 	'participants.id'
									 )
									 ->selectRaw('
									 	count(participants.id) as number,
									 	sum(questionaire_results.value) as value
									 ')
									 ->first();
									 
			$c->number = $r['number'];
			$c->value = $r['value'];
			$sumval += $c->value;
			$sumnum += $c->number;
		}

        if ($sumnum > 0) {
            $avg = round($sumval / $sumnum, 2);

            foreach ($criteria as $c) {
                $c->percent = round($c->number / $sumnum * 100, 2);
            }

            $carr = $criteria->toArray();
            usort($carr, function($a, $b){
                return $a['percent'] < $b['percent'];
            });

            return response()->json([
                'success' => true,
                'data' => [[
                    'avgRisk' => Criterion::riskString($criteria, $avg),
                    'avgValue' => $avg,
                    'total' => $sumnum,
                    'criteria' => $carr
                ]]
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => [[]]
            ]);
        }
	}
}
