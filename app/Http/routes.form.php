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

/* DEPRECATED */ Route::get('/form', 'HomeController@index');
/* DEPRECATED */ Route::get('/form/list', 'HomeController@index');
/* DEPRECATED */ Route::get('/form/do/{id}', 'HomeController@index');
/* DEPRECATED */ Route::get('/questionaire/{id}', 'FormController@show');
/* DEPRECATED */ Route::get('/form/create', 'FormController@create');
/* DEPRECATED */ Route::get('/form/edit/{questionaireID}', 'FormController@edit');
/* DEPRECATED */ Route::post('/form/save', 'FormController@store');
/* DEPRECATED */ Route::get('/template/form', 'FormController@index');
/* DEPRECATED */ Route::get('/template/form/do', 'FormController@show');
/* DEPRECATED */ Route::get('template/questionaire/{type}/{subType}', 'FormController@template');
/* DEPRECATED */ Route::get('template/questionaire/{type}', 'FormController@template');
/* DEPRECATED */ Route::get('/template/shared/{name}', 'HomeController@template');
/* DEPRECATED */ Route::get('/class/all', 'ClassController@all');

?>