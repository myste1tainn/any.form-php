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
Route::get('/user', 'HomeController@user');
Route::get('/home', 'HomeController@index');
Route::get('/template/head', 'HomeController@head');
Route::get('/template/shared/{name}', 'HomeController@template');

require_once('routes.form.php');
require_once('routes.question.php');
require_once('routes.participant.php');
require_once('routes.report.php');
require_once('routes.apis.php');