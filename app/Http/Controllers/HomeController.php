<?php namespace App\Http\Controllers;

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
	public function index($p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null, $p7 = null, $p8 = null)
	{
		if ($p1 == 'template') {
			return $this->template($p2, $p3, $p4, $p5);
		} else {
			return view('app');
		}
	}

	public function template($p1 = null, $p2 = null, $p3 = null, $p4 = null)
	{
		$path = $p1.'/'.$p2.'/'.$p3.'/'.$p4;
		$path = str_replace('//', '', $path);
		if (substr($path, -1) == '/') {
			$path = substr($path, 0, strlen($path) - 1);
		}
		return view($path);
	}

	public function user() {
		return response()->json(\Auth::user());
	}

}
