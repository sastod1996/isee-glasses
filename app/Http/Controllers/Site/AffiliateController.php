<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Client;
use App\User;
use Auth;
use Mail;

class AffiliateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
      $user = Auth::user();

      return view('site.afiliacion.register',compact('user', 'districts'));
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
      if ($validator->fails()) {
        $request->session()->flash('error', 'Falta completar datos');
        return back()->withErrors($validator)->withInput($request->all());
      }else {
        if ($request->user_id == 0 ) {
          $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'rate_id' => $request->rate_id,
            'password' => bcrypt($request->password),
            ]);

          $client = Client::create([
            'user_id' => $user->id,
            'country' => $request->country,
            'city' => $request->city,
            'code' => $request->code,
            'district' => $request->district,
            'address' => $request->address,
            'reference' => $request->reference,
            ]);

            try {
              Mail::send('site.mail.welcome', array(
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
              ), function($message) use ($user) {
                $message->from('service@isee-glasses.com', 'I-SEE Service');
                $message->to($user->email, $user->first_name);
                $message->subject('BIENVENIDO');
              });
              $status = true;
            } catch (Exception $e) {
              $status = false;
            }
        }else {
          $user = User::find($request->user_id);
        }

        if (Client::where('user_id','=', $user->id)->update($this->params($request))) {
          try {
            Mail::send('site.mail.affiliate',array(
              'first_name' => $user->first_name,
              'last_name' => $user->last_name
            ), function($message) use ($user) {
              $message->from('affiliation@isee-glasses.com', 'I-SEE Affiliation');
              $message->to($user->email, $user->first_name);
              $message->subject('SOLICITUD DE AFILIACIÓN');
            });
            Mail::send('site.mail.new-affiliate',array(
              'request' => $request,
              'user'  => $user
            ), function($message) {
              $message->from('affiliation@isee-glasses.com', 'I-SEE Affiliation');
              $message->to('affiliation@isee-glasses.com', 'I-SEE Affiliation');
              $message->subject('PROGRAMA DE AFILIACIÓN');
            });
          } catch (Exception $e) {
            $request->session()->flash('status', 'Problema en el envío de correo.');
          }
          $request->session()->flash('status', 'Su solicitud de afiliación ha sido enviada correctamente.');

        }else {
          $request->session()->flash('error', 'Error. Por favor, intentelo nuevamente');
        }

        return back();
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

    private function params(Request $request){
      return $request->only('status_affiliate', 'dni', 'facebook', 'instagram', 'twitter', 'youtube');
    }

    private function validateRequest(Request $request, $id = null){
      $rules = [
        'dni' => 'required',
        'first_name' => 'sometimes|required|string|max:255',
        'last_name' => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|string|email|max:255|unique:users',
        'telephone' => 'sometimes|required',
        'password' => 'sometimes|required|string|min:6|confirmed',
        'password-confirmation' => 'sometimes|required',
      ];
      $messages = [
        'dni.required' => 'Completar DNI. ',
        'first_name.required' => 'Completar nombres. ',
        'last_name.required' => 'Completar apellidos. ',
        'email.required' => 'Completar email. ',
        'email.unique' => 'El email ya se encuentra registrado. ',
        'telephone.required' => 'Completar telefono. ',
        'password.required' => 'Ingresa una contraseña. ',
        'password-confirmation.required' => 'Confirma tu contraseña. '
      ];
      return Validator::make($request->all(), $rules, $messages);
    }
}
