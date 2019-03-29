<?php
$incrementRoute = '/increment/v1/';
$controller = 'Increment\Marketplace\Http';
Route::post($incrementRoute.'marketplaces/create', $controller."\MarketplaceController@create");
Route::post($incrementRoute.'marketplaces/retrieve', $controller."\MarketplaceController@retrieve");
Route::post($incrementRoute.'marketplaces/update', $controller."\MarketplaceController@update");
Route::post($incrementRoute.'marketplaces/delete', $controller."\MarketplaceController@delete");
Route::get($incrementRoute.'marketplaces/test', $controller."\MarketplaceController@test");