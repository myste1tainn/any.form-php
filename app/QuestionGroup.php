<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionGroup extends Model {

	//

	public function questions()
	{
		return $this->hasMany('App\Questions', 'groupID');
	}

	public function criteria()
	{
		return $this->hasMany('App\Criterion', 'groupID');
	}

}
