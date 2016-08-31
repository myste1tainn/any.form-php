<?php namespace App\Http\Controllers;

use App\Identifier;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class IdentifierController extends Controller {

	public function create() {
		$item = new Identifier();
		$item->id = Request::input('id');
		$item->table = Request::input('table');
		$item->description = Request::input('description');
		$item->relatedIDs = Request::input('relatedIDs');
		$item->save();
		return response()->json([
			'results' => $item,
			'message' => 'Identifier created!'
		], 201);
	}

	public function update() {
		$id = Request::input('id');
		$item = Identifier::find($id);

		if ($item) {
			$item->table = Request::input('table');
			$item->description = Request::input('description');
			$item->relatedIDs = Request::input('relatedIDs');
			$item->save();
			return response()->json([
				'results' => $item,
				'message' => 'Identifier updated!'
			], 202);
		} else {
			return response()->json([
				'results' => null,
				'message' => 'Identifier '.$id.' not found!'
			], 400);
		}
	}

	public function delete() {
		$item = Identifier::destroy($id);
		if ($item) {
			return response()->json([
				'results' => $item,
				'message' => 'Identifier deleted!'
			], 202);
		} else {
			return response()->json([
				'results' => null,
				'message' => 'Identifier '.$id.' not found!'
			], 400);
		}	
	}

	public function load($id = null) {
		if ($id) {

		} else {
			return response()->json([
				'results' => null,
				'message' => 'Identifier '.$id.' not found!'
			], 400);
		}
	}

}
