<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use \Cart as Cart;
use App\Product;
use Auth;

class WishlistController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $wishes = Auth::user()->wishes;
    $wishes = $wishes->map(function ($wish) {
      $wish = Product::find( $wish->product_id);
      if (!file_exists( public_path().$wish->image)) {
        $wish->image = '/images/600x400.png';
      }
      return $wish;
    });

    return view('site.profile.wishlist.index', ['wishes' => $wishes]);
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
    $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($request) {
      return $cartItem->id === $request->product['id'];
    });

    if (!$duplicates->isEmpty()) {
      return response()->json([
        'success' => false
      ]);
    }

    $lastProduct = Cart::instance('wishlist')->add([
      'id' => $request->product['id'],
      'qty' => $request->product['qty'],
      'name' => $request->product['name'],
      'price' => $request->product['price'],
      'options' => [
        'code' => $request->product['code'],
        'slug' => $request->product['slug'],
        'description' => $request->product['description'],
        'status' => $request->product['status'],
        'promo' => $request->product['promo'],
        'image' => $request->product['image'],
      ]
    ])->associate('App\Product');

    $product = Product::find($request->product['id']);
    $product->rowId = $lastProduct->rowId;

    return response()->json([
      'success' => true,
      'product' => $product
    ]);
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
    $wish = DB::table('wishes')
              ->where('user_id', Auth::user()->id)
              ->where('product_id', $id)
              ->delete();
    return redirect('wishlist')->withSuccessMessage('Item has been removed!');
  }

  public function destroyByAjax($rowId)
  {
    Cart::instance('wishlist')->remove($rowId);

    return response()->json([
      'success' => true
    ]);
  }

  public function emptyWishlist()
  {
    Cart::instance('wishlist')->destroy();
    return redirect('wishlist')->withSuccessMessage('Your wishlist has been cleared!');
  }

  /**
  * Switch item from wishlist to shopping cart.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function switchToCart($id)
  {
    $item = Cart::instance('wishlist')->get($id);

    Cart::instance('wishlist')->remove($id);

    $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($id) {
      return $cartItem->id === $id;
    });

    if (!$duplicates->isEmpty()) {
      return redirect('cart')->withSuccessMessage('Item is already in your shopping cart!');
    }

    Cart::instance('default')->add($item->id, $item->name, 1, $item->price)
    ->associate('App\Product');

    return redirect('wishlist')->withSuccessMessage('Item has been moved to your shopping cart!');

  }
}
