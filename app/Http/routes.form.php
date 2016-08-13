<?php

// Form APIs
/* DECPRECATED */ Route::get('/api/questionaire/{id}', 'FormController@load');
/* DECPRECATED */ Route::get('/api/questionaires', 'FormController@all');
/* DECPRECATED */ Route::get('/api/answers/{questionaireID}/{academicYear}/{participantID}', 'FormController@answers');
/* DECPRECATED */ Route::post('/api/questionaire/submit', 'FormController@submit');
/* NEW */ Route::get('/api/v1/forms', 'FormController@load');
/* NEW */ Route::get('/api/v1/form/{id}', 'FormController@load');
/* NEW */ Route::post('/api/v1/form', 'FormController@save');
/* NEW */ Route::put('/api/v1/form/{id}', 'FormController@update');
/* NEW */ Route::delete('/api/v1/form/{id}', 'FormController@delete');
/* NEW */ Route::post('/api/v1/form/submit', 'FormController@submit');
/* NEW */ Route::get('/api/v1/answers/{questionaireID}/{academicYear}/{participantID}', 'FormController@answers');

/* DEPRECATED */ Route::get('/questionaire/{id}', 'FormController@show');
/* DEPRECATED */ Route::get('/form/create', 'FormController@create');
/* DEPRECATED */ Route::get('/form/edit/{questionaireID}', 'FormController@edit');
/* DEPRECATED */ Route::post('/form/save', 'FormController@store');
/* DEPRECATED */ Route::get('/class/all', 'ClassController@all');

?>