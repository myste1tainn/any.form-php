<?php

Route::get('/form', 'HomeController@index');
Route::get('/form/list', 'HomeController@index');
Route::get('/form/do/{id}', 'HomeController@index');
Route::get('/questionaire/{id}', 'FormController@show');
Route::get('/form/create', 'FormController@create');
Route::get('/form/edit/{questionaireID}', 'FormController@edit');
Route::post('/form/save', 'FormController@store');
Route::get('/template/form', 'FormController@index');
Route::get('/template/form/do', 'FormController@show');
Route::get('template/questionaire/{type}/{subType}', 'FormController@template');
Route::get('template/questionaire/{type}', 'FormController@template');
Route::get('/template/shared/{name}', 'HomeController@template');
Route::get('/class/all', 'ClassController@all');

