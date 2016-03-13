<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller {

	public function load($identifier)
	{
		$participant = Participant::where('identifier', $identifier)->first();
		return response()->json([
		                        'success' => true,
								'data' => $participant]);
	}

}
