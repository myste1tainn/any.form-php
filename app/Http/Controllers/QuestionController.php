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

	public function update() {
		$inputQuestion = Request::all();
		$question = Question::find($inputQuestion['id']);

		if ($question) {
			if (array_key_exists('order', $inputQuestion)) {
				$question->order = $inputQuestion['order'];
			}
			if (array_key_exists('label', $inputQuestion)) {
				$question->label = $inputQuestion['label'];
			}
			if (array_key_exists('name', $inputQuestion)) {
				$question->name = $inputQuestion['name'];
			}
			if (array_key_exists('description', $inputQuestion)) {
				$question->description = $inputQuestion['description'];
			}
			if (array_key_exists('type', $inputQuestion)) {
				$question->type = $inputQuestion['type'];
			}
			if (array_key_exists('questionaireID', $inputQuestion)) {
				$question->questionaireID = $inputQuestion['questionaireID'];
			}
			if (array_key_exists('groupID', $inputQuestion)) {
				$question->groupID = $inputQuestion['groupID'];
			}

			$question->save();
		}

		return response()->json([]);
	}

	public function allGroup($formID) {
		return response()->json(QuestionGroup::where('questionaireID', $formID)->get());
	}

	public function createGroup() {
		$inputGroup = Request::all();
		$group = new QuestionGroup();
		$group->name = $inputGroup['name'];
		$group->questionaireID = $inputGroup['questionaireID'];
		$group->save();
		return response()->json($group);
	}

	public function updateGroup() {
		$inputGroup = Request::all();
		$group = QuestionGroup::find($inputGroup['id']);

		if ($group) {
			$group->name = $inputGroup['name'];
			$group->label = $inputGroup['label'];
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
