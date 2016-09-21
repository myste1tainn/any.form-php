<?php namespace App\Http\Controllers\Report;

use App\Questionaire;
use App\QuestionaireResult;
use App\QuestionGroup;
use App\Criterion;
use App\Participant;
use App\Definition;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RiskScreeningController extends Controller {

	public function index()
	{
		return view('questionaire/risk-screening-main');
	}

	public function form()
	{
		return view('questionaire/risk-screening');
	}
}
