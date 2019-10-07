<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Culqi\Culqi;
use Mail;
use \Cart as Cart;
use App\Order;
use App\Product;
use App\Coupon;
use App\Client;
use App\Attribute;
use Validator;
use Redirect;
use Carbon\Carbon;

class CheckoutController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    //
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
    $SECRET_KEY = env('CULQI_SK');
    $culqi = new Culqi(array('api_key' => $SECRET_KEY));

    try {
      // Creando Cargo a una tarjeta
      $charge = $culqi->Charges->create(
        array(
          "amount" => $request->amount,
          "capture" => true,
          "currency_code" => $request->currency_code,
          "description" => "Venta de prueba",
          "email" => $request->email,
          "installments" => 0,
          "metadata" => array("test"=>"test"),
          "antifraud_details" => array(
            "address" => $request->address,
            "address_city" => $request->city,
            "country_code" => "PE",
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "phone_number" => $request->telephone,
          ),
          "source_id" => $request->source_id,
          "installments" => $request->installments
        )
      );
    } catch (Exception $e) {
      response()->json([
        'success' => false,
        'message' => 'Error en Culqi'
      ]);
    }

    if ($charge) {
      $validator = $this->validateRequest($request);

      if(!$validator->fails()){

        $now = Carbon::now();
        $order = new Order();
        $client = Client::where('user_id', '=', $request->user_id)->first();
        $client->code = $request->postal_code;
        $client->district = $request->district;
        $client->reference = $request->reference;
        $client->save();

        $index = Order::all()->last();
        $index = isset($index->id) ? $index->id+1 : '1';
        $order->nro = substr($now->year,2,2).'-'.$now->month.'-'.$now->day.'-'.str_pad($index,3,0, STR_PAD_LEFT);
        $order->client_id = $request->user_id;

        $order->country = $request->country;
        $order->city = $request->city;
        $order->district = $request->district;
        $order->address = $request->address;
        $order->postal_code = $request->postal_code;
        $order->reference = $request->reference;

        // $order->rate_id = $request->rate_id;
        $order->rate_id = $request->rate_id; //siempre se manda en soles 10-nov-2017 lplp
        $order->subtotal = $request->preorder['subtotal'];
        $order->discount = $request->preorder['discount'];
        $order->comission = $request->preorder['comission'];
        $order->coupon_id = $request->preorder['coupon_id'];
        $order->price = $request->preorder['total'];
        $order->date_order =$now->format('Y-m-d');

        $order->save();

        //Aumentar nro de veces usado por cupon
        if(isset($request->preorder['coupon'])){
          $coupon = Coupon::where('id', '=',$request->preorder['coupon']['id'])
                          ->where('status', '=', 1)
                          ->first();
          $coupon->count++;
          $coupon->save();
        }

        $items = $request->preorder['items'];
        // return response()->json($items);
        foreach ($items as $item) {
          $product = Product::find($item['id']);

          // $color = Attribute::where('slug','=',$item['color'])->get();

          if ($product) {
            DB::table('order_product')->insert([
              'order_id' => $order->id,
              'product_id' => $product->id,
              'prod_price' => $item['prodprice'],
              'image' => $item['image'],
              'color_id' => $item['color']['id'],
              'color_attr' => $item['color_attr']['id'],
              'size_id' => $item['size']['id'],
              'size_attr' => $item['size_attr'],
              'type_id' => $item['type']['id'],
              'pack_id' => $item['pack']['id'],
              'pack_price' => $item['pack_price'],
              'opt_id' => $item['option']['id'],
              'optcolor_id' => $item['optcolor']['id'],
              'opt_price' => $item['opt_price'],
              'code_color' => $item['code_color'],
              'prescription_id' => $item['prescription']['id'],
              'pres_esfod' => $item['prescription']['esfod'],
              'pres_esfoi' => $item['prescription']['esfoi'],
              'pres_esfdip' => $item['prescription']['esfdip'],
              'pres_dip' => $item['prescription']['dip'],
              'pres_cilod' => $item['prescription']['cilod'],
              'pres_ciloi' => $item['prescription']['ciloi'],
              'pres_axiod' => $item['prescription']['axiod'],
              'pres_axioi' => $item['prescription']['axioi'],
              'pres_addod' => $item['prescription']['addod'],
              'pres_addoi' => $item['prescription']['addoi'],
              // 'warranty_id' => array_get($item, 'options.warranty_id'),
              // 'warranty_price' => array_get($item, 'options.warranty_price'),
              'subtotalprice' => $item['subtotal'],
              'discount' => $item['discount'],
              'comission' => $item['comission'],
              'totalprice' => $item['totalprice']
            ]);

            //Descontar stock
            DB::table('color_sizes')
              ->where('id', '=', $item['sizecolor_id'])
              ->decrement('stock');
          }
        }

        DB::table('order_state')->insert([
          'order_id' => $order->id,
          'state_id' => 1, //Emision de orden
          'active' => true,
          'date' => $now->format('Y-m-d')
        ]);

        Cart::destroy();

        try {
          Mail::send('site.mail.congrats',array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
          ), function($message) use ($request) {
            $message->from('sales@isee-glasses.com', 'I-SEE Sales');
            $message->to('sales@isee-glasses.com', 'I-SEE Sales');
            $message->to($request->email, $request->first_name);
            $message->subject('FELICITACIONES');
          });
          $status = true;
          return response()->json([
            'success' => true,
            'message' => 'Cargo y orden creados exitosamente',
            'cargo' => $charge
          ]);
        } catch (Exception $e) {
          $status = false;
          response()->json([
            'success' => false,
            'message' => 'Mensaje no enviado'
          ]);
        }
      } else {
        response()->json([
          'success' => false,
          'message' => 'Order no creada'
        ]);
      }
    } else {
      return response()->json([
        'success' => false,
        'message' => 'Cargo no creado',
        'cargo' => $charge
      ]);
    }
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

  private function validateRequest(Request $request){
    $rules = [
      'user_id' => 'required',
      'rate_id' => 'required',
      // 'subtotal' => 'required',
      // 'price' => 'required',
      'preorder' => 'required'
    ];
    return Validator::make($request->all(), $rules);
  }
}
