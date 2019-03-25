<?php

Route::post('/comments/create', "CommentController@create");
Route::post('/comments/retrieve', "CommentController@retrieve");
Route::post('/comments/update', "CommentController@update");
Route::post('/comments/delete', "CommentController@delete");
Route::get('/comments/test', function(){
  return 'Comments';
});