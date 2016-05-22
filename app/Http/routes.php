
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
Route::get('/form', 'HomeController@index');
Route::get('/form/list', 'HomeController@index');
Route::get('/form/do/{id}', 'HomeController@index');
Route::get('/questionaire/{id}', 'FormController@show');
Route::get('/form/create', 'FormController@create');
Route::get('/form/edit/{questionaireID}', 'FormController@edit');
Route::get('/question/grouping', 'HomeController@index');
Route::get('/question/grouping/{id}', 'HomeController@index');
Route::get('/question/grouping/form/{fid}/group/{gid}', 'HomeController@index');
Route::get('/question/grouping/form/{fid}/group/', 'HomeController@index');
Route::get('/api/questionaire/{id}', 'FormController@load');
Route::get('/api/questionaires', 'FormController@all');
Route::get('/api/answers/{questionaireID}/{academicYear}/{participantID}', 'FormController@answers');
Route::post('/form/save', 'FormController@store');
Route::post('/api/questionaire/submit', 'FormController@submit');
Route::get('teacher/risk-screening', 'HomeController@index');
Route::get('teacher/risk-screening/year/{year}/participant/{studentID}', 'HomeController@index');
Route::get('teacher/risk-screening/year/{year}', 'HomeController@index');
Route::get('template/questionaire/{type}/{subType}', 'FormController@template');

// Reports
Route::get('/report', 'HomeController@index');
Route::get('/report/type/{name}', 'HomeController@index');
Route::get('/report/type/{name}/form/{id}/year/{year}', 'HomeController@index');
Route::get('/report/type/{name}/form/{id}/year/', 'HomeController@index');
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

Route::get('/template/form', 'FormController@index');
Route::get('/template/form/do', 'FormController@show');
Route::get('/template/head', 'HomeController@head');
Route::get('/template/report/{name}', 'ReportController@template');
Route::get('/template/risk/do', 'RiskScreeningController@form');
Route::get('/template/report-risk/{name}', 'ReportController@riskTemplate');
Route::get('/template/question/{name}', 'QuestionController@template');
Route::get('/template/shared/{name}', 'HomeController@template');
Route::get('/class/all', 'ClassController@all');

// APIs
Route::get('api/v1/participant/{identifier}', 'ParticipantController@load');
Route::get('api/v1/participant/{id}/form/{formID}/year/{year}', 'ParticipantController@result');
Route::get('api/v1/question-groups', 'QuestionController@allGroup');
Route::post('api/v1/question-group', 'QuestionController@createGroup');
Route::put('api/v1/question-group', 'QuestionController@updateGroup');
Route::delete('api/v1/question-group/{id}', 'QuestionController@destroyGroup');
Route::get('api/v1/form/{formID}/questions', 'QuestionController@all');
Route::post('api/v1/question', 'QuestionController@create');
Route::put('api/v1/question', 'QuestionController@update');
Route::delete('api/v1/question/{id}', 'QuestionController@destroy');

