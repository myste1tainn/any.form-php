<?php namespace App\Http\Controllers;

use App\Questionaire;
use App\QuestionaireResult;
use App\QuestionGroup;
use App\Criterion;
use App\Participant;

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
		if ($name == 'main') {
			return view('report/main');
		} else {
			return view('report/template/'.$name);
		}
	}

	public function riskTemplate($name) {
		return view('report/template/risk-'.$name);
	}

	public function sdqTemplate($name) {
		return view('report/sdq/'.$name);
	}

	public function eqTemplate($name) {
		return view('report/eq/'.$name);
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

	public function resultByRoom($id, $class, $room, $year) {
		if ($id == env('APP_RISK_ID')) {
			return $this->riskResult($id, $class, $room, $year);
		} else {
			return $this->normalResultByRoom($id, $class, $room, $year);
		}
	}

	private function riskResult($id, $class, $room, $year) {
		$results = [];

		$questionaire = Questionaire::find($id);

		$questions = $questionaire->questions()->get();

		foreach ($questions as $question) {
			$choices = $question->choices(true)->get();

			$participants = [];

			if ($question->isAspect()) {

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
			return response()->json([
				'success' => true,
				'data' => $results
			]);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'ไม่พบข้อมูลรายงาน'
			]);
		}
	}

	private function normalResultByRoom($id, $class, $room, $year) {
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
									 ->where('academicYear', $year)
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

	public function resultByClass($id, $class, $year) {
		if ($id == env('APP_RISK_ID')) {
			// Passing ull on room parameter will pull a class
			return $this->riskResult($id, $class, null, $year);
		} else {
			return $this->normalResultByClass($id, $class, $year);
		}
	}

	private function normalResultByClass($id, $class, $year) {
		$criteria = Criterion::where('questionaireID', $id)->get();

		$sumnum = 0;
		$sumval = 0;
		$i = 0;
		foreach ($criteria as $c) {
			$r = QuestionaireResult::where('questionaire_results.questionaireID', $id)
									 ->where('questionaire_results.value', '>=', $c->from)
									 ->where('questionaire_results.value', '<=', $c->to)
									 ->where('questionaire_results.academicYear', $year)
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

		$avg = 0;
		$carr = [];
		if ($sumnum > 0) {
			$avg = round($sumval / $sumnum, 2);

			foreach ($criteria as $c) {
				$c->percent = round($c->number / $sumnum * 100, 2);
			}

			$carr = $criteria->toArray();
			usort($carr, function($a, $b){
				return $a['percent'] < $b['percent'];
			});
		}

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

	public function resultByPerson($id, $year, $from = 0, $num = 10) {

		if ($id == env('APP_RISK_ID')) {
			return $this->resultByPersonRisk($id, $year, $from, $num);
		} else if ($id == env('APP_SDQ_ID')) {
			return $this->resultByPersonSDQ($id, $year, $from, $num);
		} else if ($id == env('APP_EQ_ID')) {
			return $this->resultByPersonEQ($id, $year, $from, $num);
		} else  {
			return $this->resultByPersonNormal($id, $year, $from, $num);
		}
	}

	private function resultByPersonSDQ($id, $year, $from = 0, $num = 10) {
		// Risk screening reports shows with different info
		Questionaire::$PAGED_FROM = $from;
		Questionaire::$PAGED_NUM = $num;
		$questionaire = Questionaire::with('pagedResults.participant.answers.choice.parent', 'criteria', 'questionGroups.questions')
									->find($id);


		if ($questionaire) {
			$participants = [];
			foreach ($questionaire->pagedResults as $res) {
				$p = $res->participant;

				$sumval = QuestionGroup::sumValue(
					$questionaire->questionGroups, $p, [env('APP_QUESTION_GROUP_SDQ_SOC_ID')]
				);

				$mappedAnswers = ParticipantController::riskNameMappedAnswers($p->answers);

				$p->talent = $mappedAnswers['talent'];
				$p->disabilities = $mappedAnswers['disabilities'];
				$p->risks = $mappedAnswers['aspects'];
				$participants[] = $p;

				$rs = Criterion::riskString($questionaire->criteria, $sumval);
				$p->risk =$rs." ($sumval)";
			}

			if ($participants) {
				return response()->json([
					'success' => true,
					'data' => $participants
				]);
			}
		}

		return response()->json([
			'success' => false,
			'message' => 'ไม่พบข้อมูลรายงาน'
		]);
	}

	private function resultByPersonNormal($id, $year, $from = 0, $num = 10) {
		$q = Questionaire::with('criteria')
						 ->where('id', $id)
						 ->first();

		if ($q) {
			$results = $q->results()->with('participant')->where('academicYear', $year)->get();
			foreach ($results as $r) {
				$rs = Criterion::riskString($q->criteria, $r->value);
				$r->risk =$rs;
			}
			return response()->json([
				'success' => true,
				'data' => $results
			]);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'result is empty'
			]);
		}
	}

	private function resultByPersonRisk($id, $year, $from = 0, $num = 10) {
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
				return response()->json([
					'success' => true,
					'data' => $participants
				]);
			}
		}

		return response()->json([
			'success' => false,
			'message' => 'ไม่พบข้อมูลรายงาน'
		]);
	}

	public function resultBySchool($id, $year) {
		if ($id == env('APP_RISK_ID')) {
			// Passing class & room as null will results in entire school results
			return $this->riskResult($id, null, null, $year);
		} else {
			return $this->normalResultBySchool($id, $year);
		}
	}

	private function normalResultBySchool($id, $year) {
		$criteria = Criterion::where('questionaireID', $id)->get();

		$sumnum = 0;
		$sumval = 0;
		$i = 0;
		foreach ($criteria as $c) {
			$r = QuestionaireResult::where('questionaire_results.questionaireID', $id)
									 ->where('questionaire_results.value', '>=', $c->from)
									 ->where('questionaire_results.value', '<=', $c->to)
									 ->where('academicYear', $year)
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
