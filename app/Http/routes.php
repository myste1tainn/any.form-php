<?php

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

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

require_once('routes.form.php');
require_once('routes.question.php');
require_once('routes.participant.php');
require_once('routes.report.php');
require_once('routes.apis.php');

Route::get('/', 'HomeController@index');
Route::get('/{p1?}/{p2?}/{p3?}/{p4?}/{p5?}/{p6?}/{p7?}/{p8?}/{p9?}', 'HomeController@index');
Route::get('/template/{p1}/{p2?}/{p3?}/{p4?}{p5?}/{p6?}/{p7?}/{p8?}', 'HomeController@template');

?>