<?php

Route::get('teacher/risk-screening', 'HomeController@index');
Route::get('teacher/risk-screening/year/{year}/participant/{studentID}', 'HomeController@index');
Route::get('teacher/risk-screening/year/{year}', 'HomeController@index');
Route::get('/report', 'HomeController@index');
Route::get('/report/type/{name}', 'HomeController@index');
Route::get('/report/type/{name}/form/{id}/year/{year}', 'HomeController@index');
Route::get('/report/type/{name}/form/{id}/year/', 'HomeController@index');
Route::get('/report/{name}/risk-screening', 'HomeController@index');
Route::get('/report/{name}/risk-screening/{aspect}', 'HomeController@index');
Route::get('/report/{name}/risk-screening/year/{year}', 'HomeController@index');
Route::get('/report/{name}/risk-screening/list/{year}', 'HomeController@index');
Route::get('/report/{name}/risk-screening/participant/{number}/year/{year}', 'HomeController@index');
Route::get('/report/{name}/sdq', 'HomeController@index');
Route::get('/report/{name}/sdq/{aspect}', 'HomeController@index');
Route::get('/report/{name}/sdq/year/{year}', 'HomeController@index');
Route::get('/report/{name}/sdq/list/{year}', 'HomeController@index');
Route::get('/report/{name}/sdq/participant/{number}/year/{year}', 'HomeController@index');
Route::get('/report-results', 'ReportController@result');
Route::get('/report/by-person/{id}/year/{year}', 'ReportController@resultByPerson');
Route::get('/report/by-person/{id}/year/{year}/from/{from}/num/{num}', 'ReportController@resultByPerson');
Route::get('/report/by-room/{id}/class/{class}/room/{room}/year/{year}', 'ReportController@resultByRoom');
Route::get('/report/by-class/{id}/class/{class}/year/{year}', 'ReportController@resultByClass');
Route::get('/report/by-school/{id}/year/{year}', 'ReportController@resultBySchool');

Route::get('/template/report/{name}', 'ReportController@template');
Route::get('/template/report/sdq/{name}', 'ReportController@sdqTemplate');
Route::get('/template/report-risk/{name}', 'ReportController@riskTemplate');
Route::get('/template/risk/do', 'RiskScreeningController@form');
Route::get('/template/question/{name}', 'QuestionController@template');
Route::get('/template/criteria/{name}', 'CriterionController@template');