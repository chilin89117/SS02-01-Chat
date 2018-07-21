<?php
Auth::routes();

Route::get('/', 'ChatController@chat');
Route::post('/send', 'ChatController@send');
Route::post('/messages', 'ChatController@getMessages');
