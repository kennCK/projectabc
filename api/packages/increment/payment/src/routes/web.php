<?php

// Messenger Groups
$route = env('PACKAGE_ROUTE', '').'/payment_methods/';
$controller = 'Increment\Messenger\Http\PaymentMethodController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");
