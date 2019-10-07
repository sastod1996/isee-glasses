<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Client;
use App\Enterprise;
use App\User;
use Validator;
use Redirect;

class ClientController extends Controller
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
    $clients = Client::paginate(20);

    $clients->getCollection()->transform(function ($client) {
    // $clients = $clients->map(function($client){
      $client->hasWishes = DB::table('wishes')
                             ->join('products', 'products.id', 'wishes.product_id')
                             ->where('user_id', '=', $client->user_id)
                             ->select('products.*')
                             ->count();
      return $client;
    });
    $enterprises = Enterprise::all();
    return view('admin.clients.index', compact('clients', 'enterprises'));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $enterprises = Enterprise::all();
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
    return view('admin.clients.create', compact('enterprises', 'districts'));
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $user = new User;
    $validator = $this->validateRequest($request);
    if($validator->fails()){
      return Redirect::back()->withErrors($validator)->withInput($request->all());
    }else{
      try {
        $user = User::create([
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'email' => $request->email,
          'telephone' => $request->telephone,
          'password' => bcrypt($request->password),
          'role_id' => 2,
          'rate_id' => 1
        ]);
        $user->client()->updateOrCreate([
          'user_id' => $user->id,
          'country' => $request->country,
          'city' => $request->city,
          'code' => $request->code,
          'district' => $request->district,
          'address' => $request->address,
          'reference' => $request->reference,
          'ally' => $request->ally,
          'enterprise_id' => $request->enterprise_id
        ]);
        $request->session()->flash('success', 'Actualizado correctamente');
      } catch (Exception $e) {
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('clients.index');
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
    $backTo = url()->previous();
    $user = User::find($id);
    if ($user) {
      $enterprises = Enterprise::all();
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
      return view('admin.clients.edit', compact('user', 'enterprises', 'districts', 'backTo'));
    } else {
      return redirect()->route('clients.index');
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
    $user = User::findOrFail($id);
    if ($user) {
      $validator = $this->validateRequest($request, $id);
      if($validator->fails()){
        return Redirect::back()->withErrors($validator)->withInput($request->all());
      }else{
        try {
          if (!Hash::check($request->password, $user->password) && isset($request->password)) {
            $password = bcrypt($request->password);
          } else {
            $password = $user->password;
          }
          User::where('id',$user->id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'telephone' => $request->telephone,
            'password' => $password
          ]);
          Client::where('user_id', $user->id)->update([
            'country' => $request->country,
            'city' => $request->city,
            'code' => $request->code,
            'district' => $request->district,
            'address' => $request->address,
            'reference' => $request->reference,
            'ally' => $request->ally ? 1 : 0,
            'enterprise_id' => $request->enterprise_id
          ]);
          $request->session()->flash('success', 'Actualizado correctamente');
        } catch (Exception $e) {
          $request->session()->flash('danger', 'Error, intente de nuevo.');
        }
      }
    } else {
      $request->session()->flash('danger', 'Error, intente de nuevo.');
    }
    return redirect($request->backTo);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    Client::destroy($id);
    return redirect()->route('clients.index');
  }

  private function params(Request $request){
    return $request->only('user_id', 'first_name', 'last_name', 'email', 'password');
  }

  private function validateRequest(Request $request, $id = null){
    $rules = [
    ];
    $messages = [
    ];
    return Validator::make($request->all(), $rules, $messages);
  }
}
