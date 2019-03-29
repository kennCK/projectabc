<?php
$incrementRoute = '/increment/v1/';
$controller = 'Increment\Comment\Http';
Route::post($incrementRoute.'comments/create', $controller."\CommentController@create");
Route::post($incrementRoute.'comments/retrieve', $controller."\CommentController@retrieve");
Route::post($incrementRoute.'comments/update', $controller."\CommentController@update");
Route::post($incrementRoute.'comments/delete', $controller."\CommentController@delete");
Route::get($incrementRoute.'comments/test', $controller."\CommentController@test");