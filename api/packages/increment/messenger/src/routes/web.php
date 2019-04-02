<?php

// Messenger
$route = env('PACKAGE_ROUTE', '').'/messenger/';
$controller = 'Increment\Marketplace\Http\MessengerController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");

// Messenger Groups
$route = env('PACKAGE_ROUTE', '').'/messenger_groups/';
$controller = 'Increment\Marketplace\Http\MessengerGroupController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");

// Messenger Members
$route = env('PACKAGE_ROUTE', '').'/messenger_members/';
$controller = 'Increment\Marketplace\Http\MessengerMemberController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");

// Messenger Messages
$route = env('PACKAGE_ROUTE', '').'/messenger_messages/';
$controller = 'Increment\Marketplace\Http\MessengerMessageController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");

// Messenger Message Files
$route = env('PACKAGE_ROUTE', '').'/messenger_message_files/';
$controller = 'Increment\Marketplace\Http\MessengerMessageFileController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");