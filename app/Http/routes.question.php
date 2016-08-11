<?php

Route::get('/question/grouping', 'HomeController@index');
Route::get('/question/grouping/{id}', 'HomeController@index');
Route::get('/question/grouping/form/{fid}/group/{gid}', 'HomeController@index');
Route::get('/question/grouping/form/{fid}/group/', 'HomeController@index');

Route::get('/template/question/{name}', 'QuestionController@template');
Route::get('/template/criteria/{name}', 'CriterionController@template');