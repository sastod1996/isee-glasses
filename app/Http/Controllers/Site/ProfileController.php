<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Client;
use App\Coupon;
use App\Enterprise;
use App\Order;
use App\User;
use Validator;

class ProfileController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
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
    $districts = json_decode(json_encode($districts));
    $districts = collect($districts);
    $enterprises = Enterprise::all();
    $user = Auth::user();
    return view('site.profile.index', compact('user', 'districts', 'enterprises'));
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
    // dd($request);
    $status = false;
    $user = User::findOrFail($id);

    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->telephone = $request->telephone;

    $user->save();
    $status = true;

    if ($user->is_client() || $user->is_affiliate()) {
      $client = Client::where('user_id', '=', $id)->first();
      $client->country = $request->country;
      $client->city = $request->city;
      $client->code = $request->code;
      $client->district = $request->district;
      $client->address = $request->address;
      $client->reference = $request->reference;
      $client->enterprise_id = $request->enterprise_id;
      $client->save();
      $status = true;
    }
    return redirect('/profile')->with('update_profile', $status);
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

  public function coupons(){
    $coupons = Coupon::where('affiliate_id', '=', Auth::user()->id)
                      ->orderBy('code')
                      ->get();

    $coupons = $coupons->map(function ($coupon) {
      $coupon->attributes = $coupon->attributes->pluck('name');
      $coupon->types = $coupon->types->pluck('name');
      $coupon->comission = DB::table('orders')
                             ->distinct()
                             ->where('coupon_id', '=', $coupon->id)
                             ->select(DB::raw('SUM(comission) as comission'))
                             ->first();
      $coupon->comission = $coupon->comission->comission;

      $coupon->orders = Order::where('coupon_id', '=', $coupon->id)
                              ->orderBy('date_order','id')
                              ->get();
      return $coupon;
    });
    // dd($coupons);
    return view('site.profile.promotions.index')->with('coupons', $coupons);
  }

  public function orders()
  {
    if (Auth::user()->is_client() || Auth::user()->is_affiliate()) {
      $orders = Order::where('client_id', Auth::id())
                     ->orderBy('created_at')
                     ->with('products')
                     ->with('states')
                     ->get();
      // dd($orders);
      return view('site.profile.orders.index', ['orders' => $orders]);
    }else{
      $orders = Order::orderBy('created_at')
                     ->with('products')
                     ->with('states')
                     ->get();
      return view('site.profile.orders.index', ['orders' => $orders]);
    }
  }

  public function changePassword(Request $request){
    $validator = $this->validateRequest($request);

    if($validator->fails()){
      return Redirect::back();
    }else{
      if($this->validateCurrentPassword($request->password)){
        if ($request->new_password === $request->confirm_password) {
          $user = User::findOrFail(Auth::user()->id);
          $user->password = Hash::make($request->new_password);
          $user->save();
          return redirect('/profile')->with('changePassword', 'Contraseña actualizada');
        }
      }else {
        return redirect('/profile')->with('errorPassword', 'Contraseña errónea');
      }
    }
  }

  private function validateRequest(Request $request){
    $rules = [
      'password' => 'required',
      'new_password' => 'required',
      'confirm_password' => 'required'
    ];
    return Validator::make($request->all(), $rules);
  }

  private function validateCurrentPassword($value){
    return Hash::check($value, Auth::user()->password);
  }
}
