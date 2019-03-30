<?php
$apps = '/increment/v1';
$controller = 'Increment\Common\Rating\Http';
Route::post($apps.'/ratings/create', $controller."\RatingController@create");
Route::post($apps.'/ratings/retrieve', $controller."\RatingController@retrieve");
Route::post($apps.'/ratings/update', $controller."\RatingController@update");
Route::post($apps.'/ratings/delete', $controller."\RatingController@delete");
Route::get($apps.'/ratings/test', $controller."\RatingController@test");