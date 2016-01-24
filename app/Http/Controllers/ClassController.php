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
			return intval($a['class']) < intval($b['class']);
		});
		usort($rooms, function($a,$b){
			return intval($a['room']) < intval($b['room']);
		});

		return response()->json([
			'success' => true,
			'data' => [
				'classes' => $classes,
				'rooms' => $rooms,
			]
		]);
	}

}
