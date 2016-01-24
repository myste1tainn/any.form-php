<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionaireResult extends Model {

	//
	public function questionaire() {
		return $this->belongsTo('App\Questionaire', 'questionaireID');
	}

	public function participant() {
		return $this->belongsTo('App\Participant', 'participantID')->orderBy('class');
	}

}
