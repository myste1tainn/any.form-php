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
		$questionaire = Questionaire::find($id)
									->with('criteria', 'questions.choices')
									->first();

		return response()->json($questionaire);
	}

	public function show($id) {
		return view('questionaire/do');
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
		$inputCriteria = Request::input('criteria');
		$inputQuestions = Request::input('questions');

		if ($inputID > -1) {
			$this->updateQuestionaire($inputID, $inputName, $inputCriteria, $inputQuestions);
		} else {
			$this->createQuestionaire($inputName, $inputCriteria, $inputQuestions);
		}

		return response()->json([
			'success' => true,
			'message' => 'บันทึกข้อมูลแบบฟอร์มเสร็จสมบูรณ์'
		]);
	}

	public function createQuestionaire($iName, $iCriteria, $iQuestions) {
		$questionaire = new Questionaire();
		$questionaire->name = $iName;
		$questionaire->save();

		$questionaire->criteria = Criterion::createWith($questionaire, $iCriteria);
		$questionaire->questions = Question::createWith($questionaire, $iQuestions);
	}

	public function updateQuestionaire($iID, $iName, $iCriteria, $iQuestions) {
		$questionaire = Questionaire::find($iID);
		$questionaire->name = $iName;
		$questionaire->save();

		$questionaire->criteria = Criterion::updateWith($questionaire, $iCriteria);
		$questionaire->questions = Question::updateWith($questionaire, $iQuestions);
	}

	public function all()
	{
		$questionaires = Questionaire::with('criteria', 'questions.choices')->get();
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
		$identifier = Request::input('identifier');

		$participant = Participant::where('identifier', $identifier)->first();
		if (!$participant) {
			$participant = new Participant();
			$participant->identifier = $identifier;
			$participant->save();
		}

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
