<?php namespace App\Http\Controllers;

use App\Definition;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Auth;
use DB;
use Schema;

class DefinitionController extends Controller {

	public function __construct() {
		$this->middleware('authSuper');
	}

	public function load($id = null) {
		if ($id) {
			$definition = Definition::where('id', $id)->first();
			if ($definition) {
				$definition->values = explode('|', $definition->values);
				return response()->json($definition, 200);
			} else {
				return response()->json([], 404);
			}
		} else {
			$definitions = Definition::all();
			foreach ($definitions as $definition) {
				$definition->values = explode('|', $definition->values);
			}
			return response()->json($definitions, 200);
		}
	}

	public function allTables() {
		$tables = DB::table('information_schema.tables')
					->where('table_schema', env('DB_DATABASE'))
					->get(['table_name as name']);
		return response()->json($tables, 200);
	}

	public function allColumns($tableName) {
		return response()->json(Schema::getColumnListing($tableName), 200);	
		// return response()->json(DB::execute('SHOW columns FROM '.$tableName), 200);
	}

	public function allValues($tableName, $columnName) {
		$values = DB::table($tableName)->get([$columnName.' as name']);
		return response()->json($values, 200);	
	}

	public function create() {
		$in = Request::all();
		$definition = new Definition();
		$definition->name = $in['name'];
		$definition->tableName = $in['tableName'];
		$definition->columnName = $in['columnName'];
		$definition->values = implode('|', $in['values']);
		$definition->save();
		return response()->json($definition, 200);
	}

	public function update($id) {
		$in = Request::all();
		$definition = Definition::find($id);
		$definition->name = $in['name'];
		$definition->tableName = $in['tableName'];
		$definition->columnName = $in['columnName'];
		$definition->values = implode('|', $in['values']);	
		$definition->save();
		return response()->json($definition, 200);
	}

	public function destroy($id) {
		$res = Definition::destroy($id);
		return response()->json($res, 200);
	}

}
