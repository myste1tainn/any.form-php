<?php

// Participant APIs
Route::get('/api/v1/participant/{identifier}', 'ParticipantController@load');
Route::get('/api/v1/participant/{id}/form/{formID}/year/{year}', 'ParticipantController@result');

?>