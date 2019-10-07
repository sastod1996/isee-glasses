<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Coupon;
use App\Client;
use App\Order;
use App\Attribute;
use App\Characteristic;
use App\Type;
use Validator;
use Redirect;

class CouponController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('administrator');
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $coupons = Coupon::orderBy('code')->get();

    $coupons = $coupons->map( function($coupon){
      $coupon->comission_total = Order::where('coupon_id', '=', $coupon->id)
                                      ->select(DB::raw('SUM(comission) as comission'))
                                      ->first();
      $coupon->comission_total = $coupon->comission_total->comission;
      return $coupon;
    });
    return view('admin.coupons.index', ['coupons' => $coupons]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $affiliates = Client::where('status_affiliate', '=', 1)
                        ->orderBy('user_id')
                        ->get();
    $characteristics = Characteristic::whereIn('slug', ['marca', 'uso', 'montura', 'forma', 'genero', 'tipo', 'material'] )
                                     ->get();

    $attributes = Attribute::join('characteristics', 'characteristics.id', '=', 'attributes.characteristic_id')
                           ->whereIn('characteristics.slug', ['marca', 'uso', 'montura', 'forma', 'genero', 'tipo', 'material'] )
                           ->select('attributes.*')
                           ->get();
    $types = Type::all();

    return view('admin.coupons.create', compact('affiliates', 'characteristics', 'attributes', 'types'));
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

      try {
        // dd($request);
        $coupon = Coupon::create($this->params($request));
        // $coupon->attributes()->sync(array_filter($request->attrs));
        $coupon->attributes()->sync($request->attr);
        $coupon->types()->sync($request->type);
        $request->session()->flash('success', 'Cupón creado correctamente');

      } catch (\Exception $e) {
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('coupons.index');
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $coupon = Coupon::where('id', '=', $id)->with('orders')->first();
    return view('admin.coupons.show')->with('coupon', $coupon);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $affiliates = Client::where('status_affiliate', '=', 1)
                        ->orderBy('user_id')
                        ->get();
    $characteristics = Characteristic::whereIn('slug', ['marca', 'uso', 'montura', 'forma', 'genero', 'tipo', 'material'] )
                                     ->get();

    $attributes = Attribute::join('characteristics', 'characteristics.id', '=', 'attributes.characteristic_id')
                           ->whereIn('characteristics.slug', ['marca', 'uso', 'montura', 'forma', 'genero', 'tipo', 'material'] )
                           ->select('attributes.*')
                           ->get();
    $types = Type::all();
    $coupon = Coupon::find($id);
    return view('admin.coupons.edit', compact('coupon', 'affiliates', 'characteristics', 'attributes', 'types'));
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
      try {
        $coupon = Coupon::find($id);
        $coupon->update($this->params($request));
        // $coupon->attributes()->sync(array_filter($request->attrs));
        $coupon->attributes()->sync($request->attr);
        $coupon->types()->sync($request->type);

        $request->session()->flash('success', 'Cupón actualizado correctamente');
      } catch (\Exception $e) {
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('coupons.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
      $coupon = Coupon::find($id);
      if ($coupon->count > 0) {
        return redirect()->route('coupons.index')->with('error', 'El cupón ya tiene órdenes registradas');
      }else {
        $coupon->attributes()->detach();
        $coupon->delete();
        return redirect()->route('coupons.index');
      }
  }

  private function params(Request $request){
    return $request->only('code', 'affiliate_id', 'status', 'percent', 'limit', 'percent_commission', 'max_commission', 'payment_status', 'start_date', 'end_date', 'affiliate_id');
  }

  private function validateRequest(Request $request, $id = null){
    // dd($request);
    $rules = [
    'code' => 'required | unique:coupons,code,'.$id,
    'percent' => 'required',
    'limit' => 'required',
    'start_date' => 'required',
    'end_date' => 'required'
    // 'attr' => 'required'
    ];
    $messages = [
    'code.required' => 'El código es requerido',
    'code.unique' => 'El código ya está en uso',
    'percent.required' => 'El porcentaje es requerido',
    'limit.required' => 'El límite es requerido',
    'start_date.required' => 'La fecha de inicio es requerida',
    'end_date.required' => 'La fecha fin es requerida'
    // 'attr.required' => 'Debe selecconar al menos un atributo'
    ];
    return Validator::make($request->all(), $rules, $messages);
  }
}
