<?php namespace App\Http\Controllers;

use App\Questionaire;
use Cache;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function home()
	{		
		$this->middleware('auth');	
		return view('home');
	}

	public function head()
	{
		return view('head');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index($p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null, $p7 = null, $p8 = null, $p9 = null)
	{
		if ($p1 == 'head') {
			return $this->head();
		} else if ($p1 == 'template') {
			return $this->template($p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9);
		} else {
			return view('app');
		}
	}

	public function template($p1, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null, $p7 = null, $p8 = null)
	{
		if ($p1 == 'head') {
			return $this->head();
		} else if ($p1 == 'definition') {
			$user = \Auth::user();
			if (!$user || $user->level < 999) {
				return response('', 403);
			}
		} else if ($p1 == 'form') {
			if (Questionaire::is($p2, 'RiskReport')) {
				return view('form/risk-screening');
			} else if ($p2 == 'list' || strpos($p2, 'create') !== false) {
				return view($this->constructPath($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8));
			} else {
				return view('form/do');
			}
		} else if ($p1 == 'report') {
			return $this->reportTemplate($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8);
		}
		
		return view($this->constructPath($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8));
	}

	private function constructPath($p1, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null, $p7 = null, $p8 = null) {
		$path = $p1.'/'.$p2.'/'.$p3.'/'.$p4;

		$path = str_replace('//', '', $path);
		if (substr($path, -1) == '/') {
			$path = substr($path, 0, strlen($path) - 1);
		}


		return $path;
	}

	public function user() {
		return response()->json(\Auth::user());
	}

	private function reportTemplate($p1, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null, $p7 = null, $p8 = null) {
		if (is_numeric($p2)) {
			if (Questionaire::is($p2, 'SDQReports')) {
				$part = 'sdq';
			} else if (Questionaire::is($p2, 'RiskReport')) {
				$part = 'risk';
			} else if (Questionaire::is($p2, 'EQReports')) {
				$part = 'eq';
			} else {
				$part = 'common';

				if ($p2 == 'main') {
					$p3 = $p2;
				}
			}	
		} else {
			$part = $p2;
		}

		return view($this->constructPath($p1,$part,$p3,$p4,$p5,$p6,$p7,$p8));
	}

}
