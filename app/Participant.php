<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model {

	public static $riskMap = [
		'47' => 'study',
		'48' => 'health',
		'49' => 'aggressiveness',
		'50' => 'economy',
		'51' => 'security',
		'52' => 'drugs',
		'53' => 'sexuality',
		'54' => 'games',
		'56' => 'electronics',
	];
	
	//
	public function results() {
		return $this->hasMany('App\QuestionaireResult', 'participantID');
	}

	public function answers() {
		return $this->hasMany('App\ParticipantAnswer', 'participantID');
	}

}
