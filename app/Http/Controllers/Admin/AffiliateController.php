<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;
use App\User;
use Mail;
use Validator;

class AffiliateController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $affiliates = Client::where('status_affiliate','=',1)
                        ->orderBy('user_id')
                        ->get();
    return view('admin.affiliates.index')->with('affiliates', $affiliates);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $clients = Client::with('user')
                     ->whereNull('status_affiliate')
                     ->orderBy('user_id')
                     ->get();
    return view('admin.affiliates.create', compact('clients', $clients));
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
      if (Client::where('user_id','=', $request->user_id)->update($this->params($request))) {
        $user = User::find($request->user_id);
        //Actualizar estado
        // if ($request->status == 1) {
          $user->update(['role_id' => 3 ]);
        // }
      }
    }
    return redirect()->route('affiliates.index');
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {

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
    // dd($request);
    if(Client::where('user_id', '=', $id)->update(['status_affiliate' => $request->status])){

      $user = User::find($id);
      //Actualizar estado
      if ($request->status == 1) {
        $user->update(['role_id' => 3 ]);
      }
      //correo de aceptación de afiliación
      try {
        // $status = $request->status == 1 ? 'aceptada' : 'rechazada';
        if ($request->status == 1 ) {
          $template = "site.mail.accept-affiliate";
        }else{
          $template = "site.mail.denied-affiliate";
        }
        Mail::send($template,array(
          'first_name' => $user->first_name,
          'last_name' => $user->last_name
        ), function($message) use ($user) {
          $message->from('affiliation@isee-glasses.com', 'I-SEE Affiliation');
          $message->to($user->email, $user->first_name);
          $message->subject('ESTADO DE SOLICITUD DE AFILIACIÓN');
        });
      } catch (Exception $e) {
        $request->session()->flash('status', 'Actualizado. Problemas en el envío de correo');
      }
      $request->session()->flash('status', 'Actualizado');
    }else{
      $request->session()->flash('status', 'Error');
    }
    return back();
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

  public function newAffiliates()
  {
    $affiliates = Client::where('status_affiliate','=',0)->get();
    return view('admin.affiliates.new_affiliates')->with('affiliates', $affiliates);
  }

  private function params(Request $request){
    return $request->only('status_affiliate', 'dni', 'facebook', 'instagram', 'twitter', 'youtube');
  }

  private function validateRequest(Request $request, $id = null){
    $rules = [
      'dni' => 'required|max:10'
    ];
    $messages = [
      'dni.required' => 'Completar DNI',
      'dni.max' => 'Máximo 10 caracteres'
    ];
    return Validator::make($request->all(), $rules, $messages);
  }

}
