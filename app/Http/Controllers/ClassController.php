<?php namespace App\Http\Controllers;

use App\Participant;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ClassController extends Controller {

	public function all() {
		$classes = Participant::groupBy('class')->get(['class'])->toArray();
		$rooms = Participant::groupBy('room')->get(['room'])->toArray();

		usort($classes, function($a,$b){
			return intval($a['class']) > intval($b['class']);
		});
		usort($rooms, function($a,$b){
			return intval($a['room']) > intval($b['room']);
		});

		foreach ($classes as &$class) {
			$class['name'] = $class['class'];
			$class['value'] = $class['class'];
			unset($class['class']);
		}
		foreach ($rooms as &$room) {
			$room['name'] = $room['room'];
			$room['value'] = $room['room'];
			unset($room['room']);
		}

		return response()->json([
			'classes' => $classes,
			'rooms' => $rooms,
		]);
	}

}
