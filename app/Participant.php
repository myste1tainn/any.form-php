<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model {

	public static $PAGED_FROM = 0;
	public static $PAGED_NUM = 20;

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

	public static function newMappedAnswer() {
		return [
			'study' 			=> ['high' => [], 'veryHigh' => [],'level' => []],
			'health' 			=> ['high' => [], 'veryHigh' => [],'level' => []],
			'aggressiveness' 	=> ['high' => [], 'veryHigh' => [],'level' => []],
			'economy' 			=> ['high' => [], 'veryHigh' => [],'level' => []],
			'security' 			=> ['high' => [], 'veryHigh' => [],'level' => []],
			'drugs' 			=> ['high' => [], 'veryHigh' => [],'level' => []],
			'sexuality' 		=> ['high' => [], 'veryHigh' => [],'level' => []],
			'games' 			=> ['high' => [], 'veryHigh' => [],'level' => []],
			'electronics' 		=> ['high' => [], 'veryHigh' => [],'level' => []],
			'countHighRisk'		=> 0,
			'countVeryHighRisk' => 0,
		];
	}
	
	//
	public function results() {
		return $this->hasMany('App\QuestionaireResult', 'participantID');
	}

	public function pagedResults() {
		return $this->hasMany('App\QuestionaireResult', 'participantID')
					->skip(static::$PAGED_FROM)
					->take(static::$PAGED_NUM);
	}

	public function answers() {
		return $this->hasMany('App\ParticipantAnswer', 'participantID');
	}

}
