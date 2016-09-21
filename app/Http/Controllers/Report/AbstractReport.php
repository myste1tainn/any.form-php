<?php namespace App\Http\Controllers\Report;

use App\Questionaire;
use App\Participant;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

abstract class AbstractReport extends Controller {
	abstract public function list($reportID, $year, $from = 0, $num = 10);
	abstract public function detail($reportID, $participantIdentifier);
	abstract public function summaryByRoom($reportID, $class, $room, $year);
	abstract public function summaryByClass($reportID, $class, $room, $year);
	abstract public function summaryBySchool($reportID, $class, $room, $year);

	public function __construct()
	{
		$this->middleware('auth');
	}

	protected function prepareParticipantWithIdentifier() {
		$id = Request::input('identifier')

		if ($id) {
			$participant = Participant::where('identifier', $id)->first();
			if ($participant) {
				return $participant;	
			} else {
				throw new \Exception('Participant: '.$id.' cannot be found');	
			}
		} else {
			throw new \Exception('Expected identifier, null is given.');
		}
	}

	protected function prepareParticipant() {
		$id = Request::input('id') !== false ? Request::input('id') : Request::input('participantID');

		if ($id) {
			$participant = Participant::find($id);
			return $participant;	
		} else {
			throw new \Exception('Expected node id/participantID cannot be found');
		}
	}

	protected function prepareQuestionaire() {
		$id = Request::input('id') !== false ? Request::input('id') : Request::input('questionaireID');

		if ($id) {
			$questionaire = Questionaire::find($id);
			return $questionaire;	
		} else {
			throw new \Exception('Expected node id/questionaireID cannot be found');
		}
	}
}