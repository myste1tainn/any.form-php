<?php

/* DEPRECATED */ Route::get('teacher/risk-screening', 'HomeController@index');
/* DEPRECATED */ Route::get('teacher/risk-screening/year/{year}/participant/{studentID}', 'HomeController@index');
/* DEPRECATED */ Route::get('teacher/risk-screening/year/{year}', 'HomeController@index');
/* DEPRECATED */ Route::get('/report', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/type/{name}', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/type/{name}/form/{id}/year/{year}', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/type/{name}/form/{id}/year/', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/{name}/risk-screening', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/{name}/risk-screening/{aspect}', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/{name}/risk-screening/year/{year}', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/{name}/risk-screening/list/{year}', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/{name}/risk-screening/participant/{number}/year/{year}', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/{name}/sdq', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/{name}/sdq/{aspect}', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/{name}/sdq/year/{year}', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/{name}/sdq/list/{year}', 'HomeController@index');
/* DEPRECATED */ Route::get('/report/{name}/sdq/participant/{number}/year/{year}', 'HomeController@index');
/* DEPRECATED */ Route::get('/report-results', 'ReportController@result');

/* DEPRECATED */ Route::get('/template/report/{name}', 'ReportController@template');
/* DEPRECATED */ Route::get('/template/report/sdq/{name}', 'ReportController@sdqTemplate');
/* DEPRECATED */ Route::get('/template/report-risk/{name}', 'ReportController@riskTemplate');
/* DEPRECATED */ Route::get('/template/risk/do', 'RiskScreeningController@form');
/* DEPRECATED */ Route::get('/template/question/{name}', 'QuestionController@template');
/* DEPRECATED */ Route::get('/template/criteria/{name}', 'CriterionController@template');