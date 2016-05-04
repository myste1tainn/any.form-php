<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Participant;
use App\Questionaire;
use Illuminate\Http\Request;

class ParticipantController extends Controller {

	public function load($identifier)
	{
		$participant = Participant::where('identifier', $identifier)->first();
		if ($participant) {
			return response()->json([
				'success' => true,
				'data' => $participant
			]);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'ไม่พบนักเรียนหมายเลข '.$identifier
			]);
		}
	}

	public function result($participantID, $formID, $year) {
		$participant = Participant::find($participantID);
		$form = Questionaire::find($formID);
		$result = $participant->results()
							  ->where('questionaireID', $formID)
							  ->where('academicYear', $year)
							  ->get();

		$answers = $participant->answers()
							   ->where('questionaireID', $formID)
							   ->where('academicYear', $year)
							   ->get();

		$mappedAnswers = [
			'study' 			=> [
										'high' => [], 
										'veryHigh' => [],
										'level' => []
									],
			'health' 			=> [
										'high' => [], 
										'veryHigh' => [],
										'level' => []
									],
			'aggressiveness' 	=> [
										'high' => [], 
										'veryHigh' => [],
										'level' => []
									],
			'economy' 			=> [
										'high' => [], 
										'veryHigh' => [],
										'level' => []
									],
			'security' 			=> [
										'high' => [], 
										'veryHigh' => [],
										'level' => []
									],
			'drugs' 			=> [
										'high' => [], 
										'veryHigh' => [],
										'level' => []
									],
			'sexuality' 		=> [
										'high' => [], 
										'veryHigh' => [],
										'level' => []
									],
			'games' 			=> [
										'high' => [], 
										'veryHigh' => [],
										'level' => []
									],
			'electronics' 		=> [
										'high' => [], 
										'veryHigh' => [],
										'level' => []
									],
		];
		foreach ($answers as $ans) {
			$key = $ans->question()->first()->id;
			$choice = $ans->choice()->first();
			$level = $choice->value;

			if (!array_key_exists($key, Participant::$riskMap))  continue;	

			$name = Participant::$riskMap[$key];
			
			if ($level == 0) {
				$parent = $choice->parent()->first();
				if ($parent) {
					if ($parent->value == 1) {
						$mappedAnswers[$name]['high'][] = $choice;
					} else if ($parent->value == 2) {
						$mappedAnswers[$name]['veryHigh'][] = $choice;
					}
				}
			}

			$mappedAnswers[$name]['level'][] = $level;
		}

		if ($result && $answers) {
			return response()->json([
				'success' => true,
				'data' => [
					'result' => $result,
					'answers' => $mappedAnswers
				]
			]);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'ไม่พบข้อมูล '.$form->name.' สำหรับนักเรียนหมายเลข '.$participant->identifier.' ในปีการศึกษา '.$year
			]);
		}
	}

}
