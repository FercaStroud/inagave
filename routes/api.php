<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api', 'namespace' => 'Auth',], function () {
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');

    Route::post('register', 'RegisterController@register');
});

Route::group(['middleware' => ['auth:sanctum'],], function () {
    Route::get('vue', 'HomeController@vue');
    Route::post('user', 'HomeController@user');

    Route::post('settings', 'SettingController@saveSettings');
    Route::post('checkout', 'PaymentController@preference');
    Route::get('get/user/payments', 'PaymentController@getByUserId');
    Route::get('get/store/products', 'Resources\ProductController@getStoreProducts');
    Route::get('get/user/products', 'Resources\ProductController@getUserProducts');
    Route::get('get/user/wallet', 'Resources\WalletController@getUserWallet');
    Route::post('clone/product', 'Resources\ProductController@cloneProduct');

    Route::resource('prices', 'Resources\PricesController', ['except' => ['create', 'edit', 'show'],]);
    Route::get('get/all/settings', 'SettingController@index');
    Route::post('checkout/maintenance', 'MaintenanceController@preference');
    Route::post('paypal/checkout/maintenance', 'MaintenanceController@paypalPreference');
    Route::post('paypal/checkout', 'PaypalController@preference');
    Route::get('get/user/stats', 'Resources\UserController@getUserStats');
    Route::post('request/withdraw', 'Resources\WalletController@requestWithdraw');

});

Route::group(['middleware' => ['admin'],], function () {

    Route::resource('percentages', 'Resources\PercentageController', ['except' => ['create', 'edit', 'show'],]);
    Route::resource('users', 'Resources\UserController', ['except' => ['create', 'edit', 'show'],]);
    Route::resource('products', 'Resources\ProductController', ['except' => ['create', 'edit', 'show'],]);
    Route::resource('wallets', 'Resources\WalletController', ['except' => ['create', 'edit', 'show'],]);
    Route::resource('product-images', 'Resources\ProductImageController', ['except' => ['create', 'edit', 'show'],]);
    Route::resource('maintenances', 'MaintenanceController', ['except' => ['create', 'edit', 'show'],]);
    Route::get('get/all/payments', 'PaymentController@index');
    Route::get('edit/settings', 'SettingController@update');
    Route::post('approve/user/request', 'Resources\WalletController@approveRequest');

});

Route::any('messages/{type}/{id}', function ($type, $id) {
    $data = array(
       'text' => rand(),
       'message' => 'When you reload this page, it will send a broadcast notification via Pusher, adding a random number on the other tab.',
    );

    if ($type === 'private') {
        $user = \App\User::findOrFail($id);
        $user->notify(new \App\Notifications\PrivateMessageNotification($data));
    } else {
        event(new \App\Events\PublicMessagePusherEvent($data));
    }

    return response()->json($data);
});

Route::get('checkout/feedback', 'PaymentController@feedback');
Route::get('checkout/maintenance/feedback', 'MaintenanceController@feedback');
Route::get('paypal/checkout/maintenance/feedback', 'MaintenanceController@paypalFeedback');
Route::get('paypal/checkout/feedback', 'PaypalController@feedback');
