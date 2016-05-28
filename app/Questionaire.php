<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionaire extends Model {

	public static $PAGED_FROM = 0;
	public static $PAGED_NUM = 20;

	public function criteria() {
		return $this->hasMany('App\Criterion', 'questionaireID');
	}

	public function questions() {
		return $this->hasMany('App\Question', 'questionaireID');
	}

	public function questionGroups() {
		return $this->hasMany('App\QuestionGroup', 'questionaireID');
	}

	public function results() {
		return $this->hasMany('App\QuestionaireResult', 'questionaireID');
	}

	public function pagedResults() {
		return $this->hasMany('App\QuestionaireResult', 'questionaireID')
					->skip(static::$PAGED_FROM)
					->take(static::$PAGED_NUM);
	}

	public function parent() {
		return $this->belongsTo('App\Questionaire', 'parentID');
	}

	public function childs() {
		return $this->hasMany('App\Questionaire', 'id');
	}

}
