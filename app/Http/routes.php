
<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/forms', 'HomeController@index');
Route::get('/form/create', 'FormController@create');
Route::get('/form/edit/{questionaireID}', 'FormController@edit');
Route::get('/api/questionaire/{id}', 'FormController@load');
Route::get('/api/questionaires', 'FormController@all');
Route::get('/api/answers/{questionaireID}/{academicYear}/{participantID}', 'FormController@answers');
Route::get('/questionaire/{id}', 'FormController@show');
Route::post('/form/save', 'FormController@store');
Route::post('/api/questionaire/submit', 'FormController@submit');
Route::get('teacher/risk-screening', 'HomeController@index');
Route::get('teacher/risk-screening/year/{year}/participant/{studentID}', 'HomeController@index');
Route::get('teacher/risk-screening/year/{year}', 'HomeController@index');
Route::get('template/questionaire/{type}/{subType}', 'FormController@template');

// Reports
Route::get('/report', 'HomeController@index');
Route::get('/report/type/{name}', 'HomeController@index');
Route::get('/report/type/{name}/form/{id}', 'HomeController@index');
Route::get('/report/{name}/risk-screening', 'HomeController@index');
Route::get('/report/{name}/risk-screening/{aspect}', 'HomeController@index');
Route::get('/report/{name}/risk-screening/list/{year}', 'HomeController@index');
Route::get('/report/{name}/risk-screening/participant/{number}/year/{year}', 'HomeController@index');
Route::get('/report-results', 'ReportController@result');
Route::get('/report/by-person/{id}/year/{year}', 'ReportController@resultByPerson');
Route::get('/report/by-person/{id}/year/{year}/from/{from}/num/{num}', 'ReportController@resultByPerson');
Route::get('/report/by-room/{id}/class/{class}/room/{room}/year/{year}', 'ReportController@resultByRoom');
Route::get('/report/by-class/{id}/class/{class}/year/{year}', 'ReportController@resultByClass');
Route::get('/report/by-school/{id}/year/{year}', 'ReportController@resultBySchool');

Route::get('template/forms', 'FormController@index');
Route::get('/template/report/{name}', 'ReportController@template');
Route::get('/template/risk/do', 'RiskScreeningController@form');
Route::get('/template/report-risk/{name}', 'ReportController@riskTemplate');

Route::get('/class/all', 'ClassController@all');

// APIs
Route::get('api/v1/participant/{identifier}', 'ParticipantController@load');
Route::get('api/v1/participant/{id}/form/{formID}/year/{year}', 'ParticipantController@result');
