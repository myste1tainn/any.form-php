<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionMeta extends Model {

	public function question() {
		return $this->belongsTo('App\Question', 'questionID');
	}

	public static function createWith($question, $iMeta) {
		$meta = new static();
		$meta->header = json_encode($iMeta['header']);
		$meta->questionID = $question->id;
		$meta->save();

		return $meta;
	}

	public static function updateWith($question, $iMeta) {
		$meta = static::find($iMeta['id']);

		if ($meta) {
			$meta->header = json_encode($iMeta['header']);
			$meta->questionID = $question->id;
			$meta->save();
			return $meta;
		} else {
			return static::createWith($question, $iMeta);
		}
	}

}
