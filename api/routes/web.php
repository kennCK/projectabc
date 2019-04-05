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

//Partners Controller
Route::post('/partners/retrieve', "PartnerController@retrieve");

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
Route::post('/objects/retrieve_dynamic_without_attributes', 'ObjectController@retrieveDynamicWithoutAttributes');

//Attributes
Route::post('/attributes/create', "AttributeController@create");
Route::post('/attributes/retrieve', "AttributeController@retrieve");
Route::post('/attributes/update', "AttributeController@update");
Route::post('/attributes/update_on_table_view', "AttributeController@updateTableView");
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
Route::post('/employees/update_by_profile', "EmployeeController@updateByProfile");
Route::post('/employees/delete', "EmployeeController@delete");
Route::get('/employees/test', 'EmployeeController@test');
Route::post('/employees/upload', "EmployeeController@upload");
Route::post('/employees/retrieve_on_update', "EmployeeController@retrieveOnUpdate");
Route::post('/employees/retreve_table', "EmployeeController@getEmployeesForTable");

//Employee Columns
Route::post('/employee_columns/create', "EmployeeColumnController@create");
Route::post('/employee_columns/retrieve', "EmployeeColumnController@retrieve");
Route::post('/employee_columns/update', "EmployeeColumnController@update");
Route::post('/employee_columns/delete', "EmployeeColumnController@delete");
Route::get('/employee_columns/test', 'EmployeeColumnController@test');

//Marketplace
Route::post('/marketplace/create', "MarketplaceController@create");
Route::post('/marketplace/retrieve', "MarketplaceController@retrieve");
Route::post('/marketplace/update', "MarketplaceController@update");
Route::post('/marketplace/delete', "MarketplaceController@delete");
Route::get('/marketplace/test', 'MarketplaceController@test');

//Checkouts
Route::post('/checkouts/create', "CheckoutController@create");
Route::post('/checkouts/retrieve', "CheckoutController@retrieve");
Route::post('/checkouts/retrieve_summary', "CheckoutController@retrieveSummary");
Route::post('/checkouts/update', "CheckoutController@update");
Route::post('/checkouts/update_remove_partner', "CheckoutController@updateRemovePartner");
Route::post('/checkouts/update_status', "CheckoutController@updateStatus");
Route::post('/checkouts/delete', "CheckoutController@delete");
Route::get('/checkouts/test', 'CheckoutController@test');

//Orders
Route::post('/orders/retrieve_orders', "CheckoutController@retrieveOrders");
Route::post('/orders/retrieve_order_items', "CheckoutController@retrieveOrderItems");


//Checkout Templates
Route::post('/checkout_templates/create', "CheckoutTemplateController@create");
Route::post('/checkout_templates/retrieve', "CheckoutTemplateController@retrieve");
Route::post('/checkout_templates/update', "CheckoutTemplateController@update");
Route::post('/checkout_templates/delete', "CheckoutTemplateController@delete");
Route::get('/checkout_templates/test', 'CheckoutTemplateController@test');

//Clients
Route::post('/clients/create', "ClientController@create");
Route::post('/clients/retrieve', "ClientController@retrieve");
Route::post('/clients/update', "ClientController@update");
Route::post('/clients/delete', "ClientController@delete");
Route::get('/clients/test', 'ClientController@test');

//Guides Controller
Route::post('/guides/create', "GuideController@create");
Route::post('/guides/retrieve', "GuideController@retrieve");
Route::post('/guides/update', "GuideController@update");
Route::post('/guides/delete', "GuideController@delete");
Route::get('/guides/test', 'GuideController@test');

//Emails Controller
Route::post('/emails/create', "EmailController@create");
Route::post('/emails/retrieve', "EmailController@retrieve");
Route::post('/emails/update', "EmailController@update");
Route::post('/emails/delete', "EmailController@delete");
Route::post('/emails/reset_password', 'EmailController@resetPassword');
Route::post('/emails/verification', 'EmailController@verification');
Route::post('/emails/changed_password', 'EmailController@changedPassword');
Route::post('/emails/referral', 'EmailController@referral');
Route::post('/emails/trial', 'EmailController@trial');

//Notification Settings Controller
Route::post('/notification_settings/create', "NotificationSettingController@create");
Route::post('/notification_settings/retrieve', "NotificationSettingController@retrieve");
Route::post('/notification_settings/update', "NotificationSettingController@update");
Route::post('/notification_settings/delete', "NotificationSettingController@delete");
Route::get('/notification_settings/test', 'NotificationSettingController@test');

//Profile Controller
Route::post('/profiles/create', "ProfileController@create");
Route::post('/profiles/retrieve', "ProfileController@retrieve");
Route::post('/profiles/update', "ProfileController@update");
Route::post('/profiles/delete', "ProfileController@delete");
Route::get('/profiles/test', 'ProfileController@test');

//Government Controller
Route::post('/profile_variables/create', "ProfileVariableController@create");
Route::post('/profile_variables/retrieve', "ProfileVariableController@retrieve");
Route::post('/profile_variables/update', "ProfileVariableController@update");
Route::post('/profile_variables/delete', "ProfileVariableController@delete");
Route::get('/profile_variables/test', 'ProfileVariableController@test');

// Google Spreadsheets
Route::get('/gsheets/create', 'GoogleSheetController@generate');
Route::post('/gsheets/auth', 'GoogleSheetController@getAuthUrl');
Route::post('/gsheets/create_file', 'GoogleSheetController@createNewGoogleSheet');
Route::post('/gsheets/read_file', 'GoogleSheetController@readGoogleSheet');
Route::post('/gsheets/save_token', 'GoogleSheetController@setAccessToken');
Route::get('/gsheets/sample', 'GoogleSheetController@sample');

//Account Google Sheet Controller
Route::post('/account_gsheets/create', "AccountGoogleSheetController@create");
Route::post('/account_gsheets/retrieve', "AccountGoogleSheetController@retrieve");
Route::post('/account_gsheets/update', "AccountGoogleSheetController@update");
Route::post('/account_gsheets/delete', "AccountGoogleSheetController@delete");
Route::get('/account_gsheets/test', 'AccountGoogleSheetController@test');

//Active Template Controller
Route::post('/active_templates/create', "ActiveTemplateController@create");
Route::post('/active_templates/retrieve', "ActiveTemplateController@retrieve");
Route::post('/active_templates/update', "ActiveTemplateController@update");
Route::post('/active_templates/delete', "ActiveTemplateController@delete");
Route::get('/active_templates/test', 'ActiveTemplateController@test');
