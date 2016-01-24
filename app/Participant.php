<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model {

	//
	public function result() {
		return $this->hasMany('App\QuestionaireResults', 'participantID');
	}

}
