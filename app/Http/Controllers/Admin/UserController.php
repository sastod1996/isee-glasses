<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Redirect;

class UserController extends Controller
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
    $users = User::orderBy('last_name')->get();
    return view('admin.users.index', ['users' => $users]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('admin.users.create');
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
      if(User::create($this->params($request))){
        $request->session()->flash('success', 'Creado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('users.index');
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $user = User::find($id);
    return view('users.show', ['user' => $user]);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $user = User::find($id);
    return view('admin.users.edit', compact('user'));
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
      if(User::find($id)->update($this->params($request))){
        $request->session()->flash('success', 'Actualizado correctamente');
      }else{
        $request->session()->flash('danger', 'Error, intente de nuevo.');
      }
    }
    return redirect()->route('users.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    User::destroy($id);
    return redirect()->route('users.index');
  }

  private function params(Request $request){
    if( ! is_null($request->password)){
      $request->merge(["password" => bcrypt($request->password)]);
      return $request->only('first_name', 'last_name', 'email', 'password');
    }
    return $request->only('first_name', 'last_name', 'email');
  }

  private function validateRequest(Request $request, $id = null){
    $rules = [
    'first_name' => 'required',
    'last_name' => 'required',
    'email'=> 'required|unique:users,email,'.$id
    ];
    $messages = [
    'first_name.required' => 'El nombre es requerido',
    'last_name.required' => 'El apellido es requerido',
    'email.required' => 'El correo es requerido'
    ];
    if( is_null($id) ){
      $rules['password'] = 'required';
      $messages['password.required'] = 'La contraseña es requerida';
    }
    return Validator::make($request->all(), $rules, $messages);
  }
}
