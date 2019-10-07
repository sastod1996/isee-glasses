<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Rate;
use App\Category;
use App\Characteristic;
use App\Product;
use \Cart as Cart;

class ProductController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $cartArray = array();
    $wishArray = array();
    $cart_products = Cart::content();
    $wish_products = Cart::instance('wishlist')->content();
    $i = 1;
    foreach ($wish_products as $wish_product) {
      $wishArray[$i]['id'] = $wish_product->id;
      $wishArray[$i]['rowId'] = $wish_product->rowId;
      $i++;
    }
    $i = 1;
    foreach ($cart_products as $cart_product) {
      $cartArray[$i]['id'] = $cart_product->id;
      $cartArray[$i]['rowId'] = $cart_product->rowId;
      $i++;
    }
    $products = Product::with('attributes', 'categories')->where('status', '=', 1)->paginate(21);

    // $products = $products->map(function ($product) use ($wishArray, $cartArray) {
    $products->getCollection()->transform(function ($product) use ($wishArray, $cartArray) {
      $product->price = floatval($product->price);
      $product->promo = floatval($product->promo);
      $product->characteristics = DB::table('attribute_product')
                                    ->distinct()
                                    ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                    ->join('characteristics', 'attributes.characteristic_id', '=', 'characteristics.id')
                                    ->where('attribute_product.product_id', '=', $product->id)
                                    ->where('characteristics.status', '=', 1)
                                    ->select('characteristics.id', 'characteristics.name')
                                    ->get();
      $product->characteristics = $product->characteristics->map(function ($characteristic) use ($product) {
        $characteristic->attributes = DB::table('attributes')
                                        ->distinct()
                                        ->join('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
                                        ->where('attribute_product.product_id', '=', $product->id)
                                        ->where('attributes.characteristic_id', '=', $characteristic->id)
                                        ->get();
        return $characteristic;
      });
      $keyNumberWishList = array_search($product->id, array_column($wishArray, 'id'));
      $keyNumberCart = array_search($product->id, array_column($cartArray, 'id'));
      if (false !== $keyNumberWishList || false !== $keyNumberCart) {
        if (false !== $keyNumberWishList && false !== $keyNumberCart) {
          $product->rowId = $cartArray[$keyNumberCart+1]['rowId'];
          $product->wishlist = true;
          $product->cart = true;
        } elseif (false !== $keyNumberCart) {
          $product->rowId = $cartArray[$keyNumberCart+1]['rowId'];
          $product->cart = true;
          $product->wishlist = false;
        } else {
          $product->rowId = $wishArray[$keyNumberWishList+1]['rowId'];
          $product->wishlist = true;
          $product->cart = false;
        }
      }else {
        $product->wishlist = false;
        $product->cart = false;
        $product->rowId = '';
      }
      return $product;
    });

    return response()->json([$products]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //
  }

  public function paginate()
  {
    $cartArray = array();
    $wishArray = array();
    $cart_products = Cart::content();
    $wish_products = Cart::instance('wishlist')->content();
    $i = 1;
    foreach ($wish_products as $wish_product) {
      $wishArray[$i]['id'] = $wish_product->id;
      $wishArray[$i]['rowId'] = $wish_product->rowId;
      $i++;
    }
    $i = 1;
    foreach ($cart_products as $cart_product) {
      $cartArray[$i]['id'] = $cart_product->id;
      $cartArray[$i]['rowId'] = $cart_product->rowId;
      $i++;
    }

    $rates = Rate::all();
    $categories = Category::all();
    $characteristics = Characteristic::with('attributes')->where('status', '=', 1)->get();
    $products = Product::with('attributes', 'categories')->where('status', '=', 1)->paginate(2);

    // $products = $products->map(function ($product) use ($wishArray, $cartArray) {
    $products->getCollection()->transform(function ($product) use ($wishArray, $cartArray) {
      $product->price = floatval($product->price);
      $product->promo = floatval($product->promo);
      $product->characteristics = DB::table('attribute_product')
                                    ->distinct()
                                    ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                    ->join('characteristics', 'attributes.characteristic_id', '=', 'characteristics.id')
                                    ->where('attribute_product.product_id', '=', $product->id)
                                    ->where('characteristics.status', '=', 1)
                                    ->select('characteristics.id', 'characteristics.name')
                                    ->get();
      $product->characteristics = $product->characteristics->map(function ($characteristic) use ($product) {
        $characteristic->attributes = DB::table('attributes')
                                        ->distinct()
                                        ->join('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
                                        ->where('attribute_product.product_id', '=', $product->id)
                                        ->where('attributes.characteristic_id', '=', $characteristic->id)
                                        ->get();
        return $characteristic;
      });
      $keyNumberWishList = array_search($product->id, array_column($wishArray, 'id'));
      $keyNumberCart = array_search($product->id, array_column($cartArray, 'id'));
      if (false !== $keyNumberWishList || false !== $keyNumberCart) {
        if (false !== $keyNumberWishList && false !== $keyNumberCart) {
          $product->rowId = $cartArray[$keyNumberCart+1]['rowId'];
          $product->wishlist = true;
          $product->cart = true;
        } elseif (false !== $keyNumberCart) {
          $product->rowId = $cartArray[$keyNumberCart+1]['rowId'];
          $product->cart = true;
          $product->wishlist = false;
        } else {
          $product->rowId = $wishArray[$keyNumberWishList+1]['rowId'];
          $product->wishlist = true;
          $product->cart = false;
        }
      }else {
        $product->wishlist = false;
        $product->cart = false;
        $product->rowId = '';
      }
      return $product;
    });

    return response()->json($products);
  }
}
