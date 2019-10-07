<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Route;
use App\Coupon;
use App\Client;
use App\Order;
use App\Product;
use App\Prescription;
use App\State;
use Validator;
use Redirect;
use Carbon\Carbon;
use Excel;
use Mail;

class OrderController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Request $request, $type)
  {
    // Type: 1 (en proceso) - 2 (finalizadas)
    $title = 'Órdenes';
    $orders = Order::select('orders.*', 'order_state.state_id as current_state')
                   ->join('order_state', 'order_state.order_id', 'orders.id')
                   ->where('order_state.active', '=', 1)
                   ->orderBy('orders.created_at', 'desc')
                   ->get();

    if ($type == 1) {
      $title = 'Órdenes en proceso';
      $orders = $orders->whereNotIn('current_state', [5,6]); //5 (finalizadas), 6(anuladas)

    }elseif ($type == 2) {
      $title = 'Órdenes finalizadas';
      $orders = $orders->whereIn('current_state', [5,6]);
    }

    return view('admin.orders.index', ['title' => $title, 'type' => $type, 'orders' => $orders]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $clients = Client::all();
    $coupons = Coupon::all();
    $products = Product::all();
    if (Auth::user()->is_administrator()) {
      $prescriptions = Prescription::all();
    }else{
      $prescriptions = Prescription::where('client_id', Auth::id())->get();
    }
    return view('admin.orders.create', compact('clients', 'coupons', 'prescriptions', 'products'));
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $validator = $this->validateRequest($request);
    if($validator->fails()){
      return Redirect::back()->withErrors($validator)->withInput($request->all());
    }else{
      if(Order::create($this->params($request))){
        $request->session()->flash('success', 'Creado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('orders.index');
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($type, $id)
  {
    // 1 (ordenes en proceso) - 2 (ordenes finalizadas)
    if (Auth::user()->is_administrator()) {
      $order = Order::findOrFail($id);
      $states = State::all();
      // $type = $this->type;
      return view('admin.orders.show', compact('order', 'states', 'type'));
    }else {
      return back()->withInput();
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
    if (Auth::user()->is_administrator()) {
      $order = Order::find($id);
      $states = State::all();

      return view('admin.orders.edit', compact('order', 'states'));
    }else {
      return back()->withInput();
    }
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
    $validator = $this->validateRequest($request, $id);
    if($validator->fails()){
      return Redirect::back()->withErrors($validator)->withInput($request->all());
    }else{
      $order = Order::where('id', '=', $id)->first();
      $change_state = false;

      if($order->getCurrentState()->id != $request->state_id){
        $change_state = true;
      }

      if($order->update($this->params($request))){
        $now = Carbon::now();

        if ($change_state) {
          // Actualizar estado
          DB::table('order_state')
              ->where('order_id', $id)
              ->update(['active' => false]);

          DB::table('order_state')->insert([
            'order_id' => $id,
            'state_id' => $request->state_id,
            'active' => true,
            'date' => $now->format('Y-m-d')
          ]);

          // Estado anulado - regresa stock
          if ($request->state_id == 6) {
            $this->resetStock($order);
          }

          try {
            $state = State::where('id','=', $request->state_id)->first();
            if ($state->id == 5) {
              $template = "site.mail.product-delivered";
            }else{
              $template = "site.mail.order-state";
            }
            Mail::send($template, array(
              'first_name' => $order->client->user->first_name,
              'last_name' => $order->client->user->last_name,
              'state' => $state->name
            ), function($message) use ($order) {
              $message->from('sales@isee-glasses.com', 'I-SEE Sales');
              $message->to($order->client->user->email, $order->client->user->first_name);
              $message->subject('SEGUIMIENTO DE TU ORDEN');
            });
          } catch (Exception $e) {
            $request->session()->flash('order-status', 'Error, intente de nuevo.');
          }
        }
        $request->session()->flash('order-status', 'Orden actualizada correctamente');
      }else{
        $request->session()->flash('order-status', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('orders.indexbyStatus', ['type' => $request->type]);
    // return back();
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    if (Auth::user()->is_administrator()) {
      Order::destroy($id);
      return redirect()->route('orders.index');
    }else{
      return back()->withInput();
    }
  }

  public function updatePrescription(Request $request, $order_id, $product_id){
    try {
      DB::table('order_product')
        ->where('order_id', $order_id)
        ->where('product_id', $product_id)
        ->update([ 'pres_esfod' => $request->esfod, 'pres_cilod' => $request->cilod, 'pres_axiod' => $request->axiod, 'pres_addod' => $request->addod,
                   'pres_esfoi' => $request->esfoi, 'pres_ciloi' => $request->ciloi, 'pres_axioi' => $request->axioi, 'pres_addoi' => $request->addoi,
                   'pres_esfdip' => $request->esfdip, 'pres_dip' => $request->dip
        ]);

      $request->session()->flash('prescription-status', 'Prescripción actualizada correctamente');
    } catch (Exception $e) {
      $request->session()->flash('prescription-status', 'Error, intente de nuevo.');
    }
    return Redirect::back()->with('update', 'Actualizado');
  }

  public function resetStock($order){
    foreach ($order->products as $product) {
      DB::table('color_sizes')
        ->where('color_id', '=', $product->pivot->color_attr)
        ->where('size_id', '=', $product->pivot->size_attr)
        ->increment('stock');
    }
  }

  private function params(Request $request){
    return $request->only('code', 'address', 'city', 'country');
  }

  private function validateRequest(Request $request, $id = null){
    $rules = [
    'address' => 'required',
    'city' => 'required',
    'country' => 'required',
    'state_id' => 'required'
    // 'code' => 'unique:orders,code,'.$id
    ];
    $messages = [
    'address.required' => 'La dirección de envío es requerida',
    'city.required' => 'La ciudad es requerida',
    'country.required' => 'El país es requerido',
    'state_id.required' => 'El estado de la orden es requerido'
    // 'code.unique' => 'El código de la órden ya se encuentra en uso'
    ];
    return Validator::make($request->all(), $rules, $messages);
  }
}
