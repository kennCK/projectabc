<?php
$apps = '/increment/v1';
$controller = 'Increment\Common\Comment\Http';
//Comments
Route::post($apps.'/comments/create', $controller."\CommentController@create");
Route::post($apps.'/comments/retrieve', $controller."\CommentController@retrieve");
Route::post($apps.'/comments/update', $controller."\CommentController@update");
Route::post($apps.'/comments/delete', $controller."\CommentController@delete");
Route::get($apps.'/comments/test', $controller."\CommentController@test");

//Comment Replies
Route::post($apps.'/comment_replies/create',  $controller."\CommentReplyController@create");
Route::post($apps.'/comment_replies/retrieve',  $controller."\CommentReplyController@retrieve");
Route::post($apps.'/comment_replies/update',  $controller."\CommentReplyController@update");
Route::post($apps.'/comment_replies/delete',  $controller."\CommentReplyController@delete");
Route::get($apps.'/comment_replies/test',  $controller.'\CommentReplyController@test');