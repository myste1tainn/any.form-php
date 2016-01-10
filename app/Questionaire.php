<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionaire extends Model {

	public function criteria() {
		return $this->hasMany('App\Criterion', 'questionaireID');
	}

	public function questions() {
		return $this->hasMany('App\Question', 'questionaireID');
	}

}
