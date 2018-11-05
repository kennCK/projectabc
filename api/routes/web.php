<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return "heel";//view('welcome');
});
/*
  Accessing uploaded files
*/
Route::get('storage/profiles/{filename}', function ($filename)
{
    $path = storage_path('/app/profiles/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
Route::get('storage/logo/{filename}', function ($filename)
{
    $path = storage_path('/app/logos/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('storage/image/{filename}', function ($filename)
{
    $path = storage_path('/app/images/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});


Route::get('/cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'hey'.$exitCode;

    //
});
Route::get('/clear', function () {
    $exitCode = Artisan::call('config:cache');
    return 'hey'.$exitCode;

    //
});
Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'hey'.$exitCode;

    //
});

/* Authentication Router */
Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
Route::post('authenticate', 'AuthenticateController@authenticate');
Route::post('authenticate/user', 'AuthenticateController@getAuthenticatedUser');
Route::post('authenticate/refresh', 'AuthenticateController@refreshToken');
Route::post('authenticate/invalidate', 'AuthenticateController@deauthenticate');


//Accounts
Route::post('/accounts/create', "AccountController@create");
Route::post('/accounts/retrieve', "AccountController@retrieve");
Route::post('/accounts/update', "AccountController@update");
Route::post('/accounts/update_verification', "AccountController@updateByVerification");
Route::post('/accounts/delete', "AccountController@delete");
Route::get('/accounts/test', 'AccountController@test');
Route::post('/accounts/mail', 'AccountController@testMail');
Route::post('/accounts/verify', 'AccountController@verify');
Route::post('/accounts/request_reset', 'AccountController@requestReset');


//Account Informations
Route::post('/account_informations/create', "AccountInformationController@create");
Route::post('/account_informations/retrieve', "AccountInformationController@retrieve");
Route::post('/account_informations/update', "AccountInformationController@update");
Route::post('/account_informations/delete', "AccountInformationController@delete");
Route::get('/account_informations/test', 'AccountInformationController@test');


//Account Profiles
Route::post('/account_profiles/create', "AccountProfileController@create");
Route::post('/account_profiles/retrieve', "AccountProfileController@retrieve");
Route::post('/account_profiles/update', "AccountProfileController@update");
Route::post('/account_profiles/delete', "AccountProfileController@delete");
Route::get('/account_profiles/test', 'AccountProfileController@test');


//Templates
Route::post('/templates/create', "TemplateController@create");
Route::post('/templates/retrieve', "TemplateController@retrieve");
Route::post('/templates/update', "TemplateController@update");
Route::post('/templates/delete', "TemplateController@delete");
Route::get('/templates/test', 'TemplateController@test');
Route::post('/templates/retrieve_templates_only', 'TemplateController@retriveTemplateOnly');


//Objects
Route::post('/objects/create', "ObjectController@create");
Route::post('/objects/retrieve', "ObjectController@retrieve");
Route::post('/objects/update', "ObjectController@update");
Route::post('/objects/delete', "ObjectController@delete");
Route::get('/objects/test', 'ObjectController@test');
Route::post('/objects/upload', 'ObjectController@upload');

//Attributes
Route::post('/attributes/create', "AttributeController@create");
Route::post('/attributes/retrieve', "AttributeController@retrieve");
Route::post('/attributes/update', "AttributeController@update");
Route::post('/attributes/delete', "AttributeController@delete");
Route::get('/attributes/test', 'AttributeController@test');

//Contents
Route::post('/contents/create', "ContentController@create");
Route::post('/contents/retrieve', "ContentController@retrieve");
Route::post('/contents/update', "ContentController@update");
Route::post('/contents/delete', "ContentController@delete");
Route::get('/contents/test', 'ContentController@test');

//Employees
Route::post('/employees/create', "EmployeeController@create");
Route::post('/employees/retrieve', "EmployeeController@retrieve");
Route::post('/employees/update', "EmployeeController@update");
Route::post('/employees/delete', "EmployeeController@delete");
Route::get('/employees/test', 'EmployeeController@test');
Route::post('/employees/upload', "EmployeeController@upload");

//Employee Columns
Route::post('/employee_columns/create', "EmployeeColumnController@create");
Route::post('/employee_columns/retrieve', "EmployeeColumnController@retrieve");
Route::post('/employee_columns/update', "EmployeeColumnController@update");
Route::post('/employee_columns/delete', "EmployeeColumnController@delete");
Route::get('/employee_columns/test', 'EmployeeColumnController@test');



