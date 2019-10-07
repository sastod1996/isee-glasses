<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use App\User;
use App\Order;
use App\Product;

class HomeController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {

    // if (Auth::user()->is_administrator()) {
    //   $users = User::all();
    //   return view('admin.users.index', ['users' => $users]);
    // }else{
    //   $orders = Order::where('client_id', Auth::id())->get();
    //   return view('admin.orders.index', compact('orders'));
    // }

    // $products = Product::orderBy('code', 'asc')->paginate(10);
    //
    // $products->getCollection()->transform(function ($product) {
    // // $products = $products->map(function($product){
    //   $product->colors = DB::table('attribute_product')
    //                         ->join('attributes', 'attributes.id', '=', 'attribute_product.attribute_id')
    //                         ->join('products', 'products.id', '=', 'attribute_product.product_id')
    //                         ->join('characteristics', 'characteristics.id', '=', 'attributes.characteristic_id')
    //                         ->where('characteristics.slug', '=', 'color')
    //                         ->where('attribute_product.product_id', '=', $product->id)
    //                         ->select('attributes.*', 'attribute_product.id as attribute_product_id')
    //                         ->get();
    //   $product->sizes = DB::table('attribute_product')
    //                         ->join('attributes', 'attributes.id', '=', 'attribute_product.attribute_id')
    //                         ->join('products', 'products.id', '=', 'attribute_product.product_id')
    //                         ->join('characteristics', 'characteristics.id', '=', 'attributes.characteristic_id')
    //                         ->where('characteristics.slug', '=', 'tamanio')
    //                         ->where('attribute_product.product_id', '=', $product->id)
    //                         ->select('attributes.*', 'attribute_product.id as attribute_product_id')
    //                         ->get();
    //   $product->color_sizes = DB::table('attribute_product')
    //                             ->join('products', 'attribute_product.product_id', '=', 'products.id')
    //                             ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
    //                             ->join('characteristics', 'attributes.characteristic_id', '=', 'characteristics.id')
    //                             ->where('attribute_product.product_id', '=', $product->id)
    //                             ->where('characteristics.slug', '=', 'tamanio')
    //                             ->select('attributes.*', 'attribute_product.*', 'attribute_product.id as attribute_product_id')
    //                             ->get();
    //   $product->color_sizes = $product->color_sizes->map(function($color_size) use ($product) {
    //     $color_size->colors = DB::table('color_sizes')
    //                             ->join('attribute_product', 'color_sizes.color_id', '=', 'attribute_product.id')
    //                             ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
    //                             ->where('color_sizes.size_id', '=', $color_size->attribute_product_id)
    //                             ->select('attributes.*', 'attribute_product.*', 'attribute_product.id as attribute_product_id', 'color_sizes.stock as stock', 'color_sizes.id as color_size_id')
    //                             ->get();
    //     return $color_size;
    //   });
    //   return $product;
    // });
    // return response()->json($products);

    // $title = 'Órdenes';
    // $orders = Order::select('orders.*', 'order_state.state_id as current_state')
    //                ->join('order_state', 'order_state.order_id', 'orders.id')
    //                ->where('order_state.active', '=', 1)
    //                ->whereNotIn('order_state.state_id', [5,6])
    //                ->orderBy('orders.created_at', 'desc')
    //                ->get();

    // return view('admin.orders.index', ['title' => $title, 'type' => 1, 'orders' => $orders]);
    return redirect()->route('orders.indexbyStatus', ['type' => 1 ]);
    // return view('admin.products.index', ['products' => $products]);
  }
}
