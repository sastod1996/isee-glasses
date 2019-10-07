<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Attribute;
use App\Category;
use App\Characteristic;
use App\Rate;
use App\Product;
use App\Aditional;
use App\Warranty;
use App\Type;
use App\AttributeProduct;
use \Cart as Cart;


class ShopController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $rates = Rate::all();
    $categories = Category::all();
    $characteristics = Characteristic::with('attributes')->where([['status', '=', 1], ['view', '=', 1]])->get();

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

    // return response()->json($products);

    $primaries = [
      [
        'name' => 'Amarillo',
        'value' => 'Amarillo'
      ],
      [
        'name' => 'Azul',
        'value' => 'Azul'
      ],
      [
        'name' => 'Blanco',
        'value' => 'Blanco'
      ],
      [
        'name' => 'Celeste',
        'value' => 'Celeste'
      ],
      [
        'name' => 'Dorado',
        'value' => 'Dorado'
      ],
      [
        'name' => 'Gris',
        'value' => 'Gris'
      ],
      [
        'name' => 'Marrón',
        'value' => 'Marrón'
      ],
      [
        'name' => 'Morado',
        'value' => 'Morado'
      ],
      [
        'name' => 'Naranja',
        'value' => 'Naranja'
      ],
      [
        'name' => 'Negro',
        'value' => 'Negro'
      ],
      [
        'name' => 'Plata',
        'value' => 'Plata'
      ],
      [
        'name' => 'Rojo',
        'value' => 'Rojo'
      ],
      [
        'name' => 'Rosado',
        'value' => 'Rosado'
      ],
      [
        'name' => 'Verde',
        'value' => 'Verde'
      ],
      [
        'name' => 'Vino',
        'value' => 'Vino'
      ]
    ];
    $primaries = json_decode(json_encode($primaries));
    $primaries = collect($primaries);

    $user = Auth::user();

    if (isset($user)) {
      if(Auth::user()->is_administrator()) {
        $user->administrator = DB::table('users')
                                  ->distinct()
                                  ->join('administrators', 'users.id', '=', 'administrators.user_id')
                                  ->where('administrators.user_id', '=', $user->id)
                                  ->select('administrators.*')
                                  ->get();
        // return response()->json([$user]);
      }else {
        $user->client->prescriptions = DB::table('clients')
                                  ->distinct()
                                  ->join('prescriptions', 'clients.id', '=', 'prescriptions.client_id')
                                  ->where('prescriptions.client_id', '=', $user->id)
                                  ->select('prescriptions.*')
                                  ->get();
        // return response()->json([$user]);
      }
      return view('site.shop.index')->with([
        'products' => $products,
        'categories' => $categories,
        'characteristics' => $characteristics,
        'rates' => $rates,
        'user' => $user,
        'primaries' => $primaries
      ]);
    }else {
      return view('site.shop.index')->with([
        'products' => $products,
        'categories' => $categories,
        'characteristics' => $characteristics,
        'rates' => $rates,
        'primaries' => $primaries
      ]);
    }
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
  public function show($slug)
  {
    $rates = Rate::all();
    $product = Product::where('slug', $slug)->firstOrFail();

    // $product->characteristics = $product->getCharacteristics();
    //
    // return response()->json($product);

    $product->characteristics = DB::table('attribute_product')
                                  ->distinct()
                                  ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                  ->join('characteristics', 'attributes.characteristic_id', '=', 'characteristics.id')
                                  ->where('attribute_product.product_id', '=', $product->id)
                                  ->where('characteristics.status', '=', 1)
                                  ->select('characteristics.*')
                                  ->get();
    $product->characteristics = $product->characteristics->map(function ($characteristic) use ($product) {
      $characteristic->attributes = DB::table('attributes')
                                      ->distinct()
                                      ->join('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
                                      ->where('attribute_product.product_id', '=', $product->id)
                                      ->where('attributes.characteristic_id', '=', $characteristic->id)
                                      ->select('attributes.*', 'attribute_product.id as attribute_product_id', 'attribute_product.*')
                                      ->get();

      $characteristic->attributes = $characteristic->attributes->map(function ($attribute) use ($product, $characteristic) {
        $attribute->images = DB::table('images')
                                ->distinct()
                                ->join('attribute_product', 'images.attribute_product_id', '=', 'attribute_product.id')
                                ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                ->join('characteristics', 'attributes.characteristic_id', '=', 'characteristics.id')
                                ->where('characteristics.id', '=', $characteristic->id)
                                ->where('attribute_product.product_id', '=', $product->id)
                                ->where('images.attribute_product_id', '=', $attribute->attribute_product_id)
                                ->select('images.*')
                                ->get();
        $attribute->cameras = DB::table('cameras')
                                ->distinct()
                                ->join('attribute_product', 'cameras.attribute_product_id', '=', 'attribute_product.id')
                                ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                ->join('characteristics', 'attributes.characteristic_id', '=', 'characteristics.id')
                                ->where('characteristics.id', '=', $characteristic->id)
                                ->where('attribute_product.product_id', '=', $product->id)
                                ->where('cameras.attribute_product_id', '=', $attribute->attribute_product_id)
                                ->select('cameras.*')
                                ->get();
        $attribute->colors = DB::table('color_sizes')
                                ->distinct()
                                ->join('attribute_product', 'color_sizes.size_id', '=', 'attribute_product.id')
                                ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
                                ->where('color_sizes.size_id', '=', $attribute->attribute_product_id)
                                // ->where('color_sizes.stock', '>', 0)
                                ->select('color_sizes.*')
                                ->get();
        return $attribute;
      });
      return $characteristic;
    });

    // return response()->json($product);

    $types = Type::all();
    $types = $types->map(function ($type) {
      $type->packs = DB::table('type_packs')
                        ->distinct()
                        ->join('packs', 'packs.id', '=', 'type_packs.pack_id')
                        ->join('types', 'types.id', '=', 'type_packs.type_id')
                        ->where('type_packs.type_id', '=', $type->id)
                        ->select('packs.*', 'type_packs.id as type_pack_id', 'type_packs.*')
                        ->get();
      $type->packs = $type->packs->map(function ($pack) use ($type) {
        $pack->aditionals = DB::table('option_aditionals')
                              ->distinct()
                              ->join('type_packs', 'type_packs.id', '=', 'option_aditionals.type_pack_id')
                              ->join('packs', 'packs.id', '=', 'type_packs.type_id')
                              ->join('aditionals', 'aditionals.id', '=', 'option_aditionals.aditional_id')
                              ->where('type_packs.id', '=', $pack->type_pack_id)
                              ->select('aditionals.*')
                              ->get();
        $pack->aditionals = $pack->aditionals->map(function ($aditional) use ($pack, $type) {
          $aditional->options = DB::table('options')
                                  ->distinct()
                                  ->join('option_aditionals', 'options.id', '=', 'option_aditionals.option_id')
                                  ->join('aditionals', 'option_aditionals.aditional_id', '=', 'aditionals.id')
                                  ->where('option_aditionals.aditional_id', '=', $aditional->id)
                                  ->where('option_aditionals.type_pack_id', '=', $pack->type_pack_id)
                                  ->select('options.*', 'option_aditionals.*')
                                  ->get();
          $aditional->options = $aditional->options->map(function ($option) use ($aditional, $pack) {
            $option->colors = DB::table('optadit_color')
                                ->distinct()
                                ->join('aditcolors', 'optadit_color.aditcolor_id', '=', 'aditcolors.id')
                                ->join('option_aditionals', 'optadit_color.option_aditional_id', '=', 'option_aditionals.id')
                                ->where('optadit_color.option_aditional_id', '=', $option->id)
                                ->select('aditcolors.*')
                                ->get();
            return $option;
          });
          return $aditional;
        });
        return $pack;
      });
      return $type;
    });

    // return response()->json($types);

    $warranties = Warranty::where('view', '=', 1)->get();

    $user = Auth::user();

    // return response()->json($product);
    if (isset($user)) {
      // $user->aliado = true;
      if(Auth::user()->is_administrator()) {
        $user->administrator = DB::table('users')
                                  ->distinct()
                                  ->join('administrators', 'users.id', '=', 'administrators.user_id')
                                  ->where('administrators.user_id', '=', $user->id)
                                  ->select('administrators.*')
                                  ->get();
        // return response()->json([$user]);
      }else {
        $user->client->prescriptions = DB::table('clients')
                                  ->distinct()
                                  ->join('prescriptions', 'clients.id', '=', 'prescriptions.client_id')
                                  ->where('prescriptions.client_id', '=', $user->client->id)
                                  // ->where('prescriptions.name', '!=', ' ')
                                  ->where(function ($query) {
                                      $query->where('prescriptions.name', 'NOT LIKE', 'isee-archivo%')
                                      ->whereNotNull('prescriptions.file');
                                    })
                                  ->select('prescriptions.*')
                                  ->get();
        $user->client->prescriptions = $user->client->prescriptions->map(function ($prescription){
          $prescription->esfod = floatval($prescription->esfod);
          $prescription->esfoi = floatval($prescription->esfoi);
          $prescription->cilod = floatval($prescription->cilod);
          $prescription->ciloi = floatval($prescription->ciloi);
          $prescription->addod = floatval($prescription->addod);
          $prescription->addoi = floatval($prescription->addoi);
          $prescription->filename = $prescription->file != '' ? substr($prescription->file,23) : '';
          $prescription->desc = $prescription->description;
          return $prescription;
        });
        // return response()->json([$user->client->prescriptions]);
      }
      return view('site.shop.show')->with(['product' => $product, 'rates' => $rates, 'types' => $types, 'warranties' => $warranties, 'user' => $user]);
    } else {
      return view('site.shop.show')->with(['product' => $product, 'rates' => $rates, 'types' => $types, 'warranties' => $warranties]);
    }
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

  public function shop(Request $request)
  {
    $rates = Rate::all();

    $query = collect($request->query())->map(function ($q) {
      return collect(explode(',', $q));
    });

    if ($query->get('attrs')) {
      $query->put('attrs', Attribute::whereIn('slug', $query->get('attrs'))->pluck('id'));
    }

    if ($query->get('cats')) {
      $query->put('cats', Category::whereIn('slug', $query->get('cats'))->pluck('id'));
    }

    return view('site.shop.index2', ['query' => $query, 'rates' => $rates]);
  }

  public function toggleWish(Request $request, $id)
  {
    if (Auth::check()) {
      $result = Auth::user()->wishes()->toggle($id);
      $wish = count($result['attached']);
      $message = count($result['attached']) > 0 ? 'Added' : 'Removed';
      return response()->json(['message' => $message, 'wish' => $wish]);
    } else {
      return response()->json(['message' => 'Please, authenticate first'], 401);
    }
  }
}
