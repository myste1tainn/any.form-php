<?php namespace App\Http\Controllers;

use App\Criterion;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;

class CriterionController extends Controller {

	public function template($name) {
		return view('criteria/'.$name);
	}

	public function all($formID, $groupID) {
		if ($formID) {
			$query = Criterion::where('questionaireID', $formID);
		}

		if ($query) {
			if ($groupID) {
				$query = $query->where('groupID', $groupID);
			}
		} else {
			if ($groupID) {
				$query = Criterion::where('groupID', $groupID);
			} else {
				$query = DB::table('criteria');
			}
		}

		return response()->json($query->get());
	}

	public function create() {
		$input = Request::all();
		$criterion = new Criterion();
		$criterion->label = $input['label'];
		$criterion->from = $input['from'];
		$criterion->to = $input['to'];
		$criterion->questionaireID = $input['formID'];
		$criterion->groupID = $input['groupID'];
		$criterion->save();
		return response()->json($criterion);
	}

	public function update() {
		$input = Request::all();
		$criterion = Criterion::find($input['id']);

		if ($criterion) {
			$criterion->label = $input['label'];
			$criterion->from = $input['from'];
			$criterion->to = $input['to'];
			$criterion->questionaireID = $input['questionaireID'];
			$criterion->groupID = $input['groupID'];
			$criterion->save();
		} else {
			return $this->create();
		}
	}

	public function destroy($id) {
		return response()->json(Criterion::destroy($id));
	}

}
