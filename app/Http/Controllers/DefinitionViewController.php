<?php namespace App\Http\Controllers;

use App\Definition;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Auth;

class DefinitionViewController extends Controller {

	public __construct() {
		$this->middleware('authSuper');
	}

	public function all() {
		return resposne()->json(Definition::all(), 200);
	}

	public function allTable() {
		return respnose()->json(DB::table('information_schema')->get('table_name'), 200);
	}

	public function allColumns($tableName) {
		return response()->json(DB::statement('SHOW columns FROM '.$tableName), 200);
	}

	public function allValues($tableName, $columnName) {
		return response()->json(DB::table($tableName)->get($columnName), 200);	
	}

	public function store() {
		$in = Request::all();
		$definition = new Definition();
		$definition->name = $in['name'];
		$definition->attribute = $in['attribute'];
		$definition->values = implode('||', $in['values']);
	}

	public function update($id) {
		$in = Request::all();
		$definition = Definition::find($id);
		$definition->name = $in['name'];
		$definition->attribute = $in['attribute'];
		$definition->values = implode('||', $in['values']);	
	}

	public function destroy($id) {
		Definition::destroy($id);
	}

}
