<?php

Route::get('/api/v1/user', 'HomeController@user');

/* DEPRECATED */Route::get('/class/all', 'ClassController@all');
/* NEW */Route::get('/api/v1/class/all', 'ClassController@all');

/* DEPRECATED */ Route::get('/api/answers/{questionaireID}/{academicYear}/{participantID}', 'FormController@answers');
/* NEW */ Route::get('/api/answers/{questionaireID}/{academicYear}/{participantID}', 'FormController@answers');

// Report
/* DEPRECATED */ Route::get('/api/v1/report/by-person/{id}/year/{year}', 'ReportController@resultByPerson');
/* DEPRECATED */ Route::get('/api/v1/report/by-person/{id}/year/{year}/from/{from}/num/{num}', 'ReportController@resultByPerson');
/* DEPRECATED */ Route::get('/api/v1/report/by-room/{id}/class/{class}/room/{room}/year/{year}', 'ReportController@resultByRoom');
/* DEPRECATED */ Route::get('/api/v1/report/by-class/{id}/class/{class}/year/{year}', 'ReportController@resultByClass');
/* DEPRECATED */ Route::get('/api/v1/report/by-school/{id}/year/{year}', 'ReportController@resultBySchool');

// Participants
Route::get('api/v1/participant/{identifier}', 'ParticipantController@load');
Route::get('api/v1/participant/{id}/form/{formID}/year/{year}', 'ParticipantController@result');
Route::get('api/v1/report/{id}/year/{year}/number-of-rows/{numRows}/number-of-pages', 'ReportController@numberOfPages');

// API: Question Groups
Route::get('api/v1/form/{formID}/question-groups', 'QuestionController@allGroup');
Route::post('api/v1/question-group', 'QuestionController@createGroup');
Route::put('api/v1/question-group', 'QuestionController@updateGroup');
Route::delete('api/v1/question-group/{id}', 'QuestionController@destroyGroup');

// API: Questions
Route::get('api/v1/form/{formID}/questions', 'QuestionController@all');
Route::post('api/v1/question', 'QuestionController@create');
Route::put('api/v1/question', 'QuestionController@update');
Route::delete('api/v1/question/{id}', 'QuestionController@destroy');

// API: Criteria
Route::get('api/v1/form/{formID}/group/{groupID}/criteria', 'CriterionController@all');
Route::post('api/v1/criterion', 'CriterionController@create');
Route::put('api/v1/criterion', 'CriterionController@update');
Route::delete('api/v1/criterion/{id}', 'CriterionController@destroy');

// API: Definition
Route::get('api/v1/definition/tables', 'DefinitionController@allTables');
Route::get('api/v1/definition/table/{tableName}', 'DefinitionController@allColumns');
Route::get('api/v1/definition/table/{tableName}/column/{columnName}', 'DefinitionController@allValues');
Route::get('api/v1/definition/{id}', 'DefinitionController@load');
Route::get('api/v1/definitions', 'DefinitionController@load');
Route::post('api/v1/definition', 'DefinitionController@create');
Route::put('api/v1/definition/{id}', 'DefinitionController@update');
Route::delete('api/v1/definition/{id}', 'DefinitionController@destroy');