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

//Account Profiles
Route::post('/account_images/create', "AccountImageController@create");
Route::post('/account_images/retrieve', "AccountImageController@retrieve");
Route::post('/account_images/update', "AccountImageController@update");
Route::post('/account_images/delete', "AccountImageController@delete");
Route::get('/account_images/test', 'AccountImageController@test');

//Billing Informations
Route::get('/billing_informations/test', 'BillingInformationController@test');
Route::post('/billing_informations/create', 'BillingInformationController@create');
Route::post('/billing_informations/retrieve', 'BillingInformationController@retrieve');
Route::post('/billing_informations/update', 'BillingInformationController@update');
Route::post('/billing_informations/delete', 'BillingInformationController@delete');


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

//Employee Columns
Route::post('/employee_columns/create', "EmployeeColumnController@create");
Route::post('/employee_columns/retrieve', "EmployeeColumnController@retrieve");
Route::post('/employee_columns/update', "EmployeeColumnController@update");
Route::post('/employee_columns/delete', "EmployeeColumnController@delete");
Route::get('/employee_columns/test', 'EmployeeColumnController@test');


//Comments
Route::post('/comments/create', "CommentController@create");
Route::post('/comments/retrieve', "CommentController@retrieve");
Route::post('/comments/update', "CommentController@update");
Route::post('/comments/delete', "CommentController@delete");
Route::get('/comments/test', 'CommentController@test');

//Comment Replies
Route::post('/comment_replies/create', "CommentReplyController@create");
Route::post('/comment_replies/retrieve', "CommentReplyController@retrieve");
Route::post('/comment_replies/update', "CommentReplyController@update");
Route::post('/comment_replies/delete', "CommentReplyController@delete");
Route::get('/comment_replies/test', 'CommentReplyController@test');


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

//Checkout Items
Route::post('/checkout_items/create', "CheckoutItemController@create");
Route::post('/checkout_items/retrieve', "CheckoutItemController@retrieve");
Route::post('/checkout_items/update', "CheckoutItemController@update");
Route::post('/checkout_items/delete', "CheckoutItemController@delete");
Route::get('/checkout_items/test', 'CheckoutItemController@test');

//Ratings
Route::post('/ratings/create', "RatingController@create");
Route::post('/ratings/retrieve', "RatingController@retrieve");
Route::post('/ratings/update', "RatingController@update");
Route::post('/ratings/delete', "RatingController@delete");
Route::get('/ratings/test', 'RatingController@test');

//Stripes
Route::post('/stripes/create', "StripeController@create");
Route::post('/stripes/retrieve', "StripeController@retrieve");
Route::post('/stripes/update', "StripeController@update");
Route::post('/stripes/delete', "StripeController@delete");
Route::get('/stripes/test', 'StripeController@test');


//Stripe Card
Route::post('/stripe_cards/create', "StripeCardController@create");
Route::post('/stripe_cards/create_charge', "StripeCardController@createCharge");
Route::post('/stripe_cards/retrieve', "StripeCardController@retrieve");
Route::post('/stripe_cards/update', "StripeCardController@update");
Route::post('/stripe_cards/delete', "StripeCardController@delete");
Route::get('/stripe_cards/test', 'StripeCardController@test');


//Payment Methods
Route::post('/payment_methods/create', "PaymentMethodController@create");
Route::post('/payment_methods/retrieve', "PaymentMethodController@retrieve");
Route::post('/payment_methods/update', "PaymentMethodController@update");
Route::post('/payment_methods/delete', "PaymentMethodController@delete");
Route::get('/payment_methods/test', 'PaymentMethodController@test');

//Products
Route::post('/products/create', "ProductController@create");
Route::post('/products/retrieve', "ProductController@retrieve");
Route::post('/products/update', "ProductController@update");
Route::post('/products/delete', "ProductController@delete");
Route::get('/products/test', 'ProductController@test');


//Product Attributes
Route::post('/product_attributes/create', "ProductAttributeController@create");
Route::post('/product_attributes/retrieve', "ProductAttributeController@retrieve");
Route::post('/product_attributes/update', "ProductAttributeController@update");
Route::post('/product_attributes/delete', "ProductAttributeController@delete");
Route::get('/product_attributes/test', 'ProductAttributeController@test');


//Pricing
Route::post('/pricings/create', "PricingController@create");
Route::post('/pricings/retrieve', "PricingController@retrieve");
Route::post('/pricings/update', "PricingController@update");
Route::post('/pricings/delete', "PricingController@delete");
Route::get('/pricings/test', 'PricingController@test');

//Clients
Route::post('/clients/create', "ClientController@create");
Route::post('/clients/retrieve', "ClientController@retrieve");
Route::post('/clients/update', "ClientController@update");
Route::post('/clients/delete', "ClientController@delete");
Route::get('/clients/test', 'ClientController@test');

//Paypal Transactions
Route::post('/paypal_transactions/create', "PaypalTransactionController@create");
Route::post('/paypal_transactions/retrieve', "PaypalTransactionController@retrieve");
Route::post('/paypal_transactions/update', "PaypalTransactionController@update");
Route::post('/paypal_transactions/delete', "PaypalTransactionController@delete");
Route::get('/paypal_transactions/test', 'PaypalTransactionController@test');

//Messenger Controller
Route::post('/messenger_groups/create', "MessengerGroupController@create");
Route::post('/messenger_groups/retrieve', "MessengerGroupController@retrieve");
Route::post('/messenger_groups/retrieve_summary', "MessengerGroupController@retrieveSummary");
Route::post('/messenger_groups/update', "MessengerGroupController@update");
Route::post('/messenger_groups/delete', "MessengerGroupController@delete");
Route::get('/messenger_groups/test', 'MessengerGroupController@test');

//Messenger Controller
Route::post('/messenger_messages/create', "MessengerMessageController@create");
Route::post('/messenger_messages/retrieve', "MessengerMessageController@retrieve");
Route::post('/messenger_messages/update', "MessengerMessageController@update");
Route::post('/messenger_messages/delete', "MessengerMessageController@delete");
Route::get('/messenger_messages/test', 'MessengerMessageController@test');

//Messenger Member Controller
Route::post('/messenger_members/create', "MessengerMemberController@create");
Route::post('/messenger_members/retrieve', "MessengerMemberController@retrieve");
Route::post('/messenger_members/update', "MessengerMemberController@update");
Route::post('/messenger_members/delete', "MessengerMemberController@delete");
Route::get('/messenger_members/test', 'MessengerMemberController@test');

//Messenger Message Controller
Route::post('/messenger_message_files/create', "MessengerMessageFileController@create");
Route::post('/messenger_message_files/retrieve', "MessengerMessageFileController@retrieve");
Route::post('/messenger_message_files/update', "MessengerMessageFileController@update");
Route::post('/messenger_message_files/delete', "MessengerMessageFileController@delete");
Route::get('/messenger_message_files/test', 'MessengerMessageFileController@test');


//Plans Controller
Route::post('/plans/create', "PlanController@create");
Route::post('/plans/retrieve', "PlanController@retrieve");
Route::post('/plans/retrieve_summary', "PlanController@retrieveSummary");
Route::post('/plans/update', "PlanController@update");
Route::post('/plans/delete', "PlanController@delete");
Route::get('/plans/test', 'PlanController@test');

//Partners Controller
Route::post('/partners/retrieve', "AccountController@retrievePartners");

//Coupons Controller
Route::post('/coupons/create', "CouponController@create");
Route::post('/coupons/retrieve', "CouponController@retrieve");
Route::post('/coupons/update', "CouponController@update");
Route::post('/coupons/delete', "CouponController@delete");
Route::get('/coupons/test', 'CouponController@test');

//Guides Controller
Route::post('/guides/create', "GuideController@create");
Route::post('/guides/retrieve', "GuideController@retrieve");
Route::post('/guides/update', "GuideController@update");
Route::post('/guides/delete', "GuideController@delete");
Route::get('/guides/test', 'GuideController@test');
