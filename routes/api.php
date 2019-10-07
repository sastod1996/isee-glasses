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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//   return $request->user();
// });

Route::group([
  'namespace' => 'Api',
], function () {

  Route::resource('clients', 'ClientController');
  Route::resource('products', 'ProductController');
  Route::get('productsPaginate', 'ProductController@paginate');
  Route::resource('attributes', 'AttributeController');
  Route::resource('categories', 'CategoryController');

  Route::resource('shop', 'ShopController');
  Route::get('shop-data', 'ShopController@data');
});
