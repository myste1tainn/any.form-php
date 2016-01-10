<?php namespace App\Http\Controllers;

use App\Questionaire;
use App\Criterion;
use App\Question;
use App\Choice;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;

class FormController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('questionaire/main');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('questionaire/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$inputName = Request::input('name');
		$inputCriteria = Request::input('criteria');
		$inputQuestions = Request::input('questions');

		$questionaire = new Questionaire();
		$questionaire->name = $inputName;
		$questionaire->save();

		$questionaire->criteria = Criterion::createWith($questionaire, $inputCriteria);
		$questionaire->questions = Question::createWith($questionaire, $inputQuestions);

		return response()->json([
			'success' => true,
			'message' => 'บันทึกข้อมูลแบบฟอร์มเสร็จสมบูรณ์'
		]);
	}

	public function all()
	{
		$questionaires = Questionaire::with('criteria', 'questions.choices');
		return response()->json([
			'success' => true,
			'data' => $questionaires
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
