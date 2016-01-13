
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

Route::get('/', 'HomeController@index');
Route::get('/forms', 'FormController@index');
Route::get('/form/create', 'FormController@create');
Route::get('/form/edit/{questionaireID}', 'FormController@edit');
Route::get('/api/questionaire/{id}', 'FormController@load');
Route::get('/api/questionaires', 'FormController@all');
Route::post('/form/save', 'FormController@store');
Route::post('/api/questionaire/submit', 'FormController@submit');

Route::get('/questionaire/{id}', 'FormController@show');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);