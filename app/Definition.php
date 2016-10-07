<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Definition extends Model {

	public static function valueOf($name) {
		$def = static::where('name', $name)->first();
		if ($def) return $def->value;
		else return null;
	}

}
