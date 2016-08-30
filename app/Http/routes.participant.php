<?php

// Participant APIs
Route::get('/api/v1/participant/{identifier}', 'ParticipantController@load');
Route::get('/api/v1/participant/{id}/form/{formID}/year/{year}', 'ParticipantController@result');

/* NEW */ Route::get('/api/v1/participants', 'FormController@load');
/* NEW */ Route::get('/api/v1/participant/{id}', 'FormController@load');
/* NEW */ Route::post('/api/v1/participant', 'FormController@save');
/* NEW */ Route::put('/api/v1/participant/{id}', 'FormController@update');
/* NEW */ Route::delete('/api/v1/participant/{id}', 'FormController@delete');

?>