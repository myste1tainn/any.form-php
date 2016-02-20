<?php namespace App\Http\Controllers;

use App\Questionaire;
use App\QuestionaireResult;
use App\Criterion;
use App\Question;
use App\Choice;
use App\Participant;
use App\ParticipantAnswer;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;

class FormController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('questionaire/main');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('questionaire/create');
	}

	public function edit($questionaireID) {
		return view('questionaire/create');
	}

	public function load($id) {
		$questionaire = Questionaire::with('criteria', 'questions')
									->where('id', $id)	
									->first();

		foreach ($questionaire->questions as $q) {
			$q->choices = Choice::with('subchoices', 'inputs')
								->where('questionID', $q->id)
								->whereNull('parentID')
								->get();
		}

		return response()->json($questionaire);
	}

	public function show($id) {
		return view('questionaire/do');
	}

	public function template($type, $subType) {
		return view('questionaire/'.$type.'-'.$subType);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$inputID = intval(Request::input('id'));
		$inputName = Request::input('name');
		$inputHeader = Request::input('header');
		$inputCriteria = Request::input('criteria');
		$inputQuestions = Request::input('questions');
		$inputType = Request::input('type');

		if ($inputID > -1) {
			$questionaire = $this->updateQuestionaire($inputID, 
			                                          $inputName, 
			                                          $inputType, 
			                                          $inputHeader, 
			                                          $inputCriteria, 
			                                          $inputQuestions);
		} else {
			$questionaire = $this->createQuestionaire($inputName, 
			                                          $inputType, 
			                                          $inputHeader, 
			                                          $inputCriteria, 
			                                          $inputQuestions);
		}

		$ans = $questionaire->toArray();
		foreach ($ans['questions'] as &$qq) {
			$qq = $qq->toArray();
			foreach ($qq['choices'] as &$c) {
				$c = $c->toArray();

				if (isset($c['subchoices'])) {
					foreach ($c['subchoices'] as &$sc) {
						$sc = $sc->toArray();
					}
				}
				if (isset($c['inputs'])) {
					foreach ($c['inputs'] as &$i) {
						$i = $i->toArray();
					}
				}
			}
		}

		return response()->json([
			'success' => true,
			'message' => 'บันทึกข้อมูลแบบฟอร์มเสร็จสมบูรณ์',
			'data' => $ans
		]);
	}

	public function createQuestionaire($iName, $iType, $iHeader, $iCriteria, $iQuestions) {
		$questionaire = new Questionaire();
		$questionaire->name = $iName;
		$questionaire->type = $iType;
		if ($iHeader) {
			$questionaire->header = json_encode($iHeader);
		} else {
			$questionaire->header = null;
		}
		$questionaire->save();

		$questionaire->criteria = Criterion::createWith($questionaire, $iCriteria);
		$questionaire->questions = Question::createWith($questionaire, $iQuestions);

		return $questionaire;
	}

	public function updateQuestionaire($iID, $iName, $iType, $iHeader, $iCriteria, $iQuestions) {
		$questionaire = Questionaire::find($iID);
		$questionaire->name = $iName;
		$questionaire->type = $iType;
		if ($iHeader) {
			$questionaire->header = json_encode($iHeader);
		} else {
			$questionaire->header = null;
		}
		$questionaire->save();

		$questionaire->criteria = Criterion::updateWith($questionaire, $iCriteria);
		$questionaire->questions = Question::updateWith($questionaire, $iQuestions);

		return $questionaire;
	}

	public function all()
	{
		$questionaires = Questionaire::with('criteria', 'questions')->get();

		foreach ($questionaires as $qq) {
			foreach ($qq->questions as $q) {
				$q->choices = Choice::with('subchoices', 'inputs')
									->where('questionID', $q->id)
									->whereNull('parentID')
									->get();
			}
		}

		return response()->json([
			'success' => true,
			'data' => $questionaires
		]);
	}

	public function submit()
	{
		$choices 		= Request::input('choices');
		$questionaire	= $this->prepareQuestionaire();
		$participant 	= $this->prepareParticipant();		

		// Retain only one copy of question answers of each participant
		ParticipantAnswer::where('participantID', $participant->id)
						 ->where('questionaireID', $questionaire->id)
						 ->delete();

		QuestionaireResult::where('participantID', $participant->id)
						  ->where('questionaireID', $questionaire->id)
						  ->delete();

		$answers		= ParticipantAnswer::createWith($questionaire, $participant, $choices);
		$summation		= Choice::summationFromChoices($choices);

		$qr					= new QuestionaireResult();
		$qr->participantID 	= $participant->id;
		$qr->questionaireID = $questionaire->id;
		$qr->value			= $summation;
		$qr->save(); 

		return response()->json([
			'success' => true,
			'message' => 'บันทึกข้อมูลแบบฟอร์มเสร็จสมบูรณ์'
		]);
	}

	private function prepareParticipant() {
		$identifier 	= Request::input('identifier');
		$fname 			= Request::input('firstname');
		$lname 			= Request::input('lastname');
		$class 			= Request::input('class');
		$room 			= Request::input('room');

		$participant = Participant::where('identifier', $identifier)->first();
		if (!$participant) {
			$participant = new Participant();
		}

		$participant->identifier = $identifier;
		$participant->firstname = $fname;
		$participant->lastname = $lname;
		$participant->class = $class;
		$participant->room = $room;
		$participant->save();

		return $participant;
	}

	private function prepareQuestionaire() {
		$id = Request::input('questionaireID');
		$questionaire = Questionaire::find($id);

		if (!$questionaire) {
			throw new \Exception('Questionaire does not existed');
		}

		return $questionaire;
	}

}
