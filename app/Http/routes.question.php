<?php

/* DEPRECATED */ Route::get('/question/grouping', 'HomeController@index');
/* DEPRECATED */ Route::get('/question/grouping/{id}', 'HomeController@index');
/* DEPRECATED */ Route::get('/question/grouping/form/{fid}/group/{gid}', 'HomeController@index');
/* DEPRECATED */ Route::get('/question/grouping/form/{fid}/group/', 'HomeController@index');

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

?>