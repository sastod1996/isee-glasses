<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Type;
use App\Pack;
use App\Typepack;
use App\Product;
use App\Aditcolor;
use App\Prescription;
use App\Warranty;
use App\Attribute;
use App\AttributeProduct;
use App\Option;
use App\Order;
use \Cart as Cart;

class CartController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $user = Auth::user()->load('client');
    $preorder = new Order();
    $monofocales = collect('de-distancia', 'de-cerca','sin-medida');
    $bifocales = collect('bifocales');
    $multifocales = collect('progresivo');

    $articles = collect();
    $discountTotal = 0;
    // return response()->json(Cart::content());
    foreach (Cart::content() as $item) {
      $article = Product::with('categories')->where('id', '=', $item->id)->first();
      $article->rowId = $item->rowId;
      $article->color = Attribute::where('id', '=', $item->options->color_attr)->first();
      $article->color_attr = AttributeProduct::where('id', '=',$item->options->color)->first(); //id attribute_product
      $article->size = Attribute::where('id', '=', $item->options->size_attr)->first();
      $article->size_attr = $item->options->size; //id attribute_product
      $article->sizecolor_id = $item->options->sizecolor_id;
      $article->image = $item->options->image;
      $article->rowId = $item->rowId;
      $article->code_color = $item->options->code_color;
      $article->type = Type::where('id', '=', $item->options->type_id)->first();
      $article->pack = Pack::where('id', '=', $item->options->pack_id)->first();
      $article->typepack = Typepack::where('id', '=', $item->options->type_pack_id)->first();
      $article->prescription = Prescription::where('id', '=', $item->options->prescription_id)->first();
      $article->option = Option::where('id', '=', $item->options->opt_id)->first();
      $article->optcolor = Aditcolor::where('id', '=', $item->options->optcolor_id)->first();
      $article->opt_price = $item->options->opt_price;
      $article->warranty = Warranty::where('id', '=', $item->options->warranty_id)->first();
      $article->prodprice = $item->options->prod_price;
      $article->pack_price = $item->options->pack_price;
      $article->warr_price = $item->options->warranty_price;
      $article->subtotal = $item->subtotal;
      $article->comission = 0;
      $article->totalprice = $item->price;
      $article->uso = $article->attributes->where('characteristic_id', '=',3)->first();
      $articles->push($article);

      // Si es ALIADO se aplica el descuento automatico
      if($user->client->ally){
        $article->allDcts = collect(); // Todos los dctos que aplican
        $discountFinal = 0;
        $dcto = (object)[ 'amount' => 0, 'msg' => '' ];

        // Descuento por tipo de lunas (Monofocal - Multifocal - Bifocales)
        $type = $article->type->slug;
        if ($monofocales->contains($type)){
          $dcto->amount = $article->typepack->price * 0.3;
          if ($dcto->amount > 60) $dcto->amount = 60;
          $dcto->msg = 'Dcto Lunas Monofocales';

        }else if ($bifocales->contains($type)) {
          $dcto->amount = $article->typepack->price * 0.25;
          if ($dcto->amount > 80) $dcto->amount = 80;
          $dcto->msg = 'Dcto Lunas Bifocales';

        }else if ($multifocales->contains($type)) {
          $dcto->amount = $article->typepack->price * 0.2;
          if ($dcto->amount > 100) $dcto->amount = 100;
          $dcto->msg = 'Dcto Lunas Multifocales';

        }
        $article->allDcts->push($dcto);
        $discountFinal = $dcto->amount;
        $dcto = (object)[ 'amount' => 0, 'msg' => '' ];

        if ($article->uso->slug === 'lentes-de-contacto'){
          $dcto->amount = $article->prodprice * 0.3; // No tiene maximo descuento
          $dcto->msg = 'Dcto Lentes de contacto';
          $article->allDcts->push($dcto);
          $discountFinal += $dcto->amount;
        }

        // Descuento por lentes de contacto y tipo de Montura
        foreach ($article->attributes as $attribute) {
          if ($attribute->characteristic_id === 1) { // Si es un atributo de Marca (Premium o Regular)
            $dcto = (object)[ 'amount' => 0, 'msg' => '' ];
            if ($attribute->premium) {
              $dcto->amount = $article->prodprice * 0.3;
              $dcto->msg = 'Dcto Monturas Marca Premium';
            } else {
              $dcto->amount = $article->prodprice * 0.5;
              $dcto->msg = 'Dcto Monturas Marca Regular';
            }
            $article->allDcts->push($dcto);
            $discountFinal += $dcto->amount;
          }
        }
        // return response()->json($article->allDcts);

        $article->discount = ceil($discountFinal);
        $article->totalprice = $article->totalprice - $article->discount;
        $discountTotal = $discountTotal + ceil($discountFinal);
      }else{
        $article->discount = 0;
      }
      // return response()->json($article);
    }

    $preorder->items = $articles;
    $preorder->subtotal = Cart::subtotal();
    $preorder->coupon_id = null;
    $preorder->discount = $discountTotal;
    $preorder->comission = 0;
    $preorder->total = Cart::total();

    if($discountTotal > 0){
      $preorder->total = $preorder->total - $preorder->discount;
    }

    $districts = [
      [
        'name' => 'Ancón',
        'value' => 'Ancón'
      ],
      [
        'name' => 'Ate',
        'value' => 'Ate'
      ],
      [
        'name' => 'Barranco',
        'value' => 'Barranco'
      ],
      [
        'name' => 'Breña',
        'value' => 'Breña'
      ],
      [
        'name' => 'Cercado de Lima',
        'value' => 'Cercado de Lima'
      ],
      [
        'name' => 'Chorrillos',
        'value' => 'Chorrillos'
      ],
      [
        'name' => 'Comas',
        'value' => 'Comas'
      ],
      [
        'name' => 'El Agustino',
        'value' => 'El Agustino'
      ],
      [
        'name' => 'Independencia',
        'value' => 'Independencia'
      ],
      [
        'name' => 'Jesús María',
        'value' => 'Jesús María'
      ],
      [
        'name' => 'La Molina',
        'value' => 'La Molina'
      ],
      [
        'name' => 'La Victoria',
        'value' => 'La Victoria'
      ],
      [
        'name' => 'Lince',
        'value' => 'Lince'
      ],
      [
        'name' => 'Los Olivos',
        'value' => 'Los Olivos'
      ],
      [
        'name' => 'Magdalena del Mar',
        'value' => 'Magdalena del Mar'
      ],
      [
        'name' => 'Mi Perú',
        'value' => 'Mi Perú'
      ],
      [
        'name' => 'Miraflores',
        'value' => 'Miraflores'
      ],
      [
        'name' => 'Pueblo Libre',
        'value' => 'Pueblo Libre'
      ],
      [
        'name' => 'Puente Piedra',
        'value' => 'Puente Piedra'
      ],
      [
        'name' => 'Rimac',
        'value' => 'Rimac'
      ],
      [
        'name' => 'San Borja',
        'value' => 'San Borja'
      ],
      [
        'name' => 'San Isidro',
        'value' => 'San Isidro'
      ],
      [
        'name' => 'San Juan de Miraflores',
        'value' => 'San Juan de Miraflores'
      ],
      [
        'name' => 'San Juan de Lurigancho',
        'value' => 'San Juan de Lurigancho'
      ],
      [
        'name' => 'San Luis',
        'value' => 'San Luis'
      ],
      [
        'name' => 'San Martin de Porres',
        'value' => 'San Martin de Porres'
      ],
      [
        'name' => 'San Miguel',
        'value' => 'San Miguel'
      ],
      [
        'name' => 'Santa Anita',
        'value' => 'Santa Anita'
      ],
      [
        'name' => 'Santa Rosa',
        'value' => 'Santa Rosa'
      ],
      [
        'name' => 'Santiago de Surco',
        'value' => 'Santiago de Surco'
      ],
      [
        'name' => 'Surquillo',
        'value' => 'Surquillo'
      ],
      [
        'name' => 'Ventanilla',
        'value' => 'Ventanilla'
      ],
      [
        'name' => 'Villa El Savador',
        'value' => 'Villa El Savador'
      ],
      [
        'name' => 'Villa María del Triunfo',
        'value' => 'Villa María del Triunfo'
      ]
    ];
    // dd($preorder);
    $districts = json_decode(json_encode($districts));
    $districts = collect($districts);

    // return response()->json($preorder);
    return view('site.cart.index', compact('preorder', 'user', 'districts'));
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
    // return response()->json($request);
    $duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
      return $cartItem->id === $request['id'];
    });

    if (!$duplicates->isEmpty()) {
      return response()->json([
        'success' => false
      ]);
    }

    Cart::add([
      'id' => $request['id'],
      'qty' => $request['qty'],
      'name' => $request['name'],
      'price' => $request['price'],
      'options' => [
        'name_en' => $request['name_en'],
        'code' => $request['code'],
        'slug' => $request['slug'],
        'prod_price' => $request['prod_price'],
        'image' => $request['image'],
        'color_attr' => $request['color_attr'],
        'size_attr' => $request['size_attr'],
        'code_color' => $request['code_color'],
        'color' => $request['color'],
        'size' => $request['size'],
        'sizecolor_id' => $request['sizecolor_id'],
        'type_pack_id' => $request['type_pack_id'],
        'type_id' => $request['type_id'],
        'pack_id' => $request['pack_id'],
        'pack_price' => $request['pack_price'],
        'pack_name' => $request['pack_name'],
        'opt_id' => $request['option_id'],
        'prescription_id' => $request['prescription_id'],
        'opt_price' => $request['option_price'],
        // 'aditcolor_id' => $request['aditcolor_id'],
        'optcolor_id' => $request['optcolor_id'],
        'warranty_id' => $request['warranty_id'],
        'warranty_price' => $request['warranty_price']
      ]
    ])->associate('App\Product');

    return response()->json([
      'success' => true
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
    $validator = Validator::make($request->all(), [
      'quantity' => 'required|numeric|between:1,5'
    ]);

    if ($validator->fails()) {
      session()->flash('error_message', 'La cantidad debe estar entre 1 y 5.');
      return response()->json(['success' => false]);
    }

    Cart::update($id, $request->quantity);
    session()->flash('success_message', 'Cantidad actualizada correctamente.');

    return response()->json(['success' => true]);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    Cart::remove($id);
    // return redirect('cart')->withSuccessMessage('El producto fue removido');
    return response()->json([
      'success' => true
    ]);
  }

  public function empty()
  {
    Cart::destroy();
    return redirect('cart')->withSuccessMessage('Tu carrito ha sido vaciado.');
  }

  public function checkout()
  {

  }
}
