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


/*Products*/
Route::get('products/{product}', 'Product\ProductController@product'); //['only' => ['index', 'show']]);

// /*Order */

Route::resource('/orders', 'Order\OrderController', ['except' => ['create', 'edit']]);


Route::resource('orders.customers', 'Order\OrderCustomerController');	





/*Payment*/
Route::post('/charge', 'Payment\PaymentController@charge');
Route::post('/test', 'Payment\PaymentController@test');

/*SaveOrder*/
//Route::post('/saveorders', 'Order\OrderController@addOrder');



/*Route::resource('purchases.products', 'Purchase\PurchaseProductController', ['only' => ['store']]);*/