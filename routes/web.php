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

Route::group([
  'namespace' => 'Site',
  'prefix' => LaravelLocalization::setLocale(),
  'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function() {
  Route::get('/', 'HomeController@index')->name('home.site');
  Route::get('contactanos', function () {
    return view('site.contactanos.index');
  });
  Route::get('nosotros', function () {
    return view('site.nosotros.index');
  })->name('nosotros');
  Route::get('faq', function () {
    return view('site.faq.index');
  });
  Route::get('terminos-y-condiciones', function () {
    return view('site.terminos.index');
  });
  Route::resource('registrar', 'Auth\RegisterController');
  Route::get('afiliarme', 'AffiliateController@create')->name('affiliarme');
  Route::post('send', 'AffiliateController@store')->name('affiliate.store');
  Route::resource('categories', 'CategoryController');
  Route::resource('shop', 'ShopController');
  Route::get('shop', 'ShopController@shop'); // Carlos
  // Route::get('shop2', 'ShopController@shop'); // Carlos
  Route::get('shop2/wish/{id}', 'ShopController@toggleWish'); // Carlos
  Route::resource('submit','SubmitController');
  Route::post('changeRate/{slug}', 'HomeController@changeRate')->name('changeRate');
});

Route::group([
  'namespace' => 'Site'
], function() {
  Route::resource('submit','SubmitController');
  Route::post('interesados','InteresadoController@store')->name('interesados.store');
});

Route::group([
  'middleware' => ['auth', 'roles',  'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
  'namespace' => 'Site',
  'roles' => ['client', 'administrator', 'affiliate'],
  'prefix' => LaravelLocalization::setLocale()
], function() {
  Route::resource('cart', 'CartController');
  Route::get('my-orders', 'ProfileController@orders')->name('profile');
  Route::get('promotions', 'ProfileController@coupons')->name('profile');
  Route::resource('profile', 'ProfileController');
  Route::post('changePassword/{id}', 'ProfileController@changePassword')->name('changePassword');
  Route::resource('wishlist', 'WishlistController');
  Route::delete('wishlist/{rowId}/ajax', 'WishlistController@destroyByAjax');
});

Route::group([
  'middleware' => ['auth', 'roles',  'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
  'namespace' => 'Site',
  'roles' => ['affiliate'],
  'prefix' => LaravelLocalization::setLocale()
], function() {
  Route::get('promotions', 'ProfileController@coupons')->name('profile');
});

Route::group([
  'middleware' => ['auth', 'roles'],
  'namespace' => 'Site',
  'roles' => ['client', 'administrator', 'affiliate']
], function() {
  Route::resource('prescriptions', 'PrescriptionController');
  Route::resource('checkout', 'CheckoutController');
  Route::post('discount', 'DiscountController@discount')->name('discount');
});


Auth::routes();

// System Administrator web
Route::group([
  'middleware' => ['auth', 'roles'],
  'prefix' => 'admin',
  'namespace' => 'Admin',
  // 'roles' => ['administrator', 'client']
  'roles' => ['administrator']
], function () {
  Route::get('/', 'HomeController@index')->name('admin');
  Route::resource('users', 'UserController');
  Route::resource('coupons', 'CouponController');
  Route::resource('categories', 'CategoryController');
  Route::resource('sliders', 'SliderController');
  Route::resource('prescriptions', 'PrescriptionController');
  Route::resource('characteristics', 'CharacteristicController');
  Route::resource('types', 'TypeController');
  Route::resource('roles', 'RoleController');
  Route::resource('popups', 'PopupController');
  Route::resource('attributes', 'AttributeController');
  Route::get('attributes/characteristic/{id}', 'AttributeController@createByChar');
  Route::get('attributes/characteristic/{char_id}/edit/{id}', 'AttributeController@editByChar');
  Route::resource('packs', 'PackController');
  Route::resource('typepacks', 'TypepackController');
  Route::resource('products', 'ProductController');
  Route::post('products/refresh-random', 'ProductController@refreshRandom')->name('products.refresh-random');
  Route::post('products/{slug}/asign', 'ProductController@asign')->name('products.asign');
  Route::post('products/{slug}/editasign', 'ProductController@editAsign')->name('products.editasign');
  Route::resource('clients', 'ClientController');
  Route::resource('enterprises', 'EnterpriseController');
  Route::resource('administrators', 'AdministratorController');
  Route::resource('shippings', 'ShippingController');
  Route::resource('orders', 'OrderController');
  Route::get('show-orders/{type}', 'OrderController@index')->name('orders.indexbyStatus');
  Route::get('show-orders/{type}/{id}', 'OrderController@show')->name('orders.showByStatus');
  Route::post('updatePrescription/{order_id}/{product_id}', 'OrderController@updatePrescription')->name('orders.updatePrescription');
  Route::resource('affiliates', 'AffiliateController');
  Route::get('new-affiliates', 'AffiliateController@newAffiliates');
  Route::get('export/{type}', 'ExcelController@export')->name('excel.export');
  Route::get('orderfiles', 'ExcelController@orderFiles')->name('excel.orderfiles');
  Route::post('import-products', 'ExcelController@importProducts')->name('excel.import-products');
  Route::post('import-stock', 'ExcelController@importStock')->name('excel.import-stock');
  Route::post('import-clients', 'ExcelController@importClients')->name('excel.import-clients');
  Route::get('export-clients', 'ExcelController@exportClients')->name('excel.export-clients');
  Route::get('export-interesados', 'ExcelController@exportInteresados')->name('excel.export-interesados');
  Route::get('search/products', 'ProductController@search');
  Route::get('search/attributes', 'AttributeController@search');
  Route::get('discount-allies', 'DiscountAlliesController@index');
  Route::post('promotions/upload', 'PromoContainerController@upload');
  Route::resource('promotions', 'PromoContainerController', ['only' => ['index', 'update']]);
});
