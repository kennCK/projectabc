<?php
$apps = '/increment/v1';
$controller = 'Increment\Marketplace\Http';
Route::post($apps.'/marketplaces/create', $controller."\MarketplaceController@create");
Route::post($apps.'/marketplaces/retrieve', $controller."\MarketplaceController@retrieve");
Route::post($apps.'/marketplaces/update', $controller."\MarketplaceController@update");
Route::post($apps.'/marketplaces/delete', $controller."\MarketplaceController@delete");
Route::get($apps.'/marketplaces/test', $controller."\MarketplaceController@test");