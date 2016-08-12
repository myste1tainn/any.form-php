<?php

// Form APIs
/* DECPRECATED */ Route::get('/api/questionaire/{id}', 'FormController@load');
/* DECPRECATED */ Route::get('/api/questionaires', 'FormController@all');
/* DECPRECATED */ Route::get('/api/answers/{questionaireID}/{academicYear}/{participantID}', 'FormController@answers');
/* DECPRECATED */ Route::post('/api/questionaire/submit', 'FormController@submit');
/* NEW */ Route::get('/api/v1/questionaire/{id}', 'FormController@load');
/* NEW */ Route::get('/api/v1/questionaires', 'FormController@all');
/* NEW */ Route::get('/api/v1/answers/{questionaireID}/{academicYear}/{participantID}', 'FormController@answers');
/* NEW */ Route::post('/api/v1/questionaire/submit', 'FormController@submit');

// Participant APIs
Route::get('/api/v1/participant/{identifier}', 'ParticipantController@load');
Route::get('/api/v1/participant/{id}/form/{formID}/year/{year}', 'ParticipantController@result');
// Report APIs
Route::get('/api/v1/report/{id}/year/{year}/number-of-rows/{numRows}/number-of-pages', 'ReportController@numberOfPages');

// API: Question Groups
Route::get('/api/v1/form/{formID}/question-groups', 'QuestionController@allGroup');
Route::post('/api/v1/question-group', 'QuestionController@createGroup');
Route::put('/api/v1/question-group', 'QuestionController@updateGroup');
Route::delete('api/v1/question-group/{id}', 'QuestionController@destroyGroup');

// API: Questions
Route::get('/api/v1/form/{formID}/questions', 'QuestionController@all');
Route::post('/api/v1/question', 'QuestionController@create');
Route::put('/api/v1/question', 'QuestionController@update');
Route::delete('api/v1/question/{id}', 'QuestionController@destroy');

// API: Criteria
Route::get('/api/v1/form/{formID}/group/{groupID}/criteria', 'CriterionController@all');
Route::post('/api/v1/criterion', 'CriterionController@create');
Route::put('/api/v1/criterion', 'CriterionController@update');
Route::delete('api/v1/criterion/{id}', 'CriterionController@destroy');