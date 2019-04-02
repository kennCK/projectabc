<?php

// Plan
$route = env('PACKAGE_ROUTE', '').'/plans/';
$controller = 'Increment\Plan\Http\PlanController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");

// Plan
$route = env('PACKAGE_ROUTE', '').'/invitations/';
$controller = 'Increment\Plan\Http\InvitationController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");
