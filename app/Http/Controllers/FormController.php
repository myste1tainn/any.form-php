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

use Cache;
use Request;

class FormController extends Controller {

	public function load($id = null) {
		if ($id) {
			$questionaire = Questionaire::with('criteria', 'questions.meta')
									->where('id', $id)	
									->first();

			if ($questionaire) {
				foreach ($questionaire->questions as $q) {
					$q->choices = Choice::with('subchoices', 'inputs')
										->where('questionID', $q->id)
										->whereNull('parentID')
										->get();
				}

				return response()->json($questionaire);
			} else {
				return response()->json(null, 404);
			}
		} else {
			return $this->all();
		}
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
		return response()->json($questionaires);
	}

	/**
	 * Submit form results this implies the followings
	 * - Saving answers (the choices that user made)
	 * - Saving answers' addiontal inputs (if any)
	 * - Saving results (the value of the calculation)
	 */
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
		$qr->academicYear 	= Cache::get('settings.current_academic_year');

		if (!$qr->academicYear) {
			$qr->academicYear = $participant->academicYear;
		}

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
		$number			= Request::input('number');
		$class 			= Request::input('class');
		$room 			= Request::input('room');

		$participant = Participant::where('identifier', $identifier)->first();
		if (!$participant) {
			$participant = new Participant();
		}

		$participant->identifier = $identifier;
		$participant->firstname = $fname;
		$participant->lastname = $lname;
		$participant->number = $number;
		$participant->class = $class;
		$participant->room = $room;
		$participant->save();

		if (Request::has('academicYear')) {
			$participant->academicYear = Request::input('academicYear');
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

	public function answers($questionaireID, $academicYear, $participantID)
	{
		if ($academicYear == -999) {
			$academicYear = Cache::get('settings.current_academic_year');
		}

		$participant = Participant::where('identifier', $participantID)
								  ->first();

		if ($participant) {
			$answers = ParticipantAnswer::with('inputs')
										->where('questionaireID', $questionaireID)
										->where('participantID', $participant->id)
										->where('academicYear', $academicYear)
										->get();
		}

		return response()->json([
		                        'success' => true,
		                        'data' => $answers
		                        ]);
	}
}
