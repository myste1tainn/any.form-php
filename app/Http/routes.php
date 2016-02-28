
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
Route::get('/forms', 'FormController@index');
Route::get('/form/create', 'FormController@create');
Route::get('/form/edit/{questionaireID}', 'FormController@edit');
Route::get('/api/questionaire/{id}', 'FormController@load');
Route::get('/api/questionaires', 'FormController@all');
Route::get('/api/answers/{questionaireID}/{participantID}', 'FormController@answers');
Route::get('/questionaire/{id}', 'FormController@show');
Route::post('/form/save', 'FormController@store');
Route::post('/api/questionaire/submit', 'FormController@submit');
Route::get('teacher/risk-screening', 'RiskScreeningController@form');
Route::get('teacher/risk-screening/{studentID}', 'RiskScreeningController@form');
Route::get('template/questionaire/{type}/{subType}', 'FormController@template');

// Reports
Route::get('/report', 'ReportController@index');
Route::get('/report/{name}', 'ReportController@index');
Route::get('/report/results', 'ReportController@result');
Route::get('/report/results/{id}/person', 'ReportController@resultByPerson');
Route::get('/report/results/{id}/room/{class}/{room}', 'ReportController@resultByRoom');
Route::get('/report/results/{id}/class/{class}', 'ReportController@resultByClass');
Route::get('/report/results/{id}/school', 'ReportController@resultBySchool');
Route::get('/report/template/{name}', 'ReportController@template');

Route::get('/class/all', 'ClassController@all');


