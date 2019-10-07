<?php

namespace App\Http\Controllers\Site\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Client;
use App\User;
use Validator;
use Redirect;

class RegisterController extends Controller
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
    return view('site.auth.register', compact('districts'));
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
}
