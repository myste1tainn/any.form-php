<?php namespace App\Http\Controllers;

use App\Question;
use App\QuestionGroup;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;

class QuestionController extends Controller {

	public function template($name)
	{
		return view('question/'.$name);
	}

	public function all($formID) {
		if ($formID) {
			return response()->json(Question::where('questionaireID', $formID)->get());
		} else {
			return response()->json(Question::all());
		}
	}

	public function allGroup() {
		return response()->json(QuestionGroup::all());
	}

	public function createGroup() {
		$inputGroup = Request::all();
		$group = new QuestionGroup();
		$group->name = $inputGroup['name'];
		$group->save();
		return response()->json($group);
	}

	public function updateGroup() {
		$inputGroup = Request::all();
		$group = QuestionGroup::find($inputGroup['id']);

		if ($group) {
			$group->name = $inputGroup['name'];
			$group->save();
		} else {
			return $this->createGroup();
		}

		return response()->json($group);	
	}

	public function destroyGroup($id) {
		QuestionGroup::destroy($id);
	}

}
